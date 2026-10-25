<?php

namespace App\Filament\Pages;

use App\Models\Employee;
use App\Payroll\Audit\Application\Query\GetAudit;
use App\Payroll\Audit\Application\ReadModel\AuditReport;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\SharedKernel\Period;
use Carbon\CarbonImmutable;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** Audit of one employee: full history, or a date window (with an opening balance), optionally one period. */
class PayrollAudit extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $navigationLabel = 'Payroll audit';

    protected static ?string $title = 'Payroll audit';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected string $view = 'filament.pages.payroll-audit';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->filtersForm->fill([
            'employee_id' => request()->query('employee') ?: Employee::query()->orderBy('name')->value('id'),
            'period' => request()->query('period'),
            'from' => request()->query('from'),
            'to' => request()->query('to'),
        ]);
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->columns(4)
            ->components([
                Select::make('employee_id')
                    ->label('Employee')
                    ->options(fn () => Employee::query()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('period', null)),
                Select::make('period')
                    ->label('Period (optional)')
                    ->options(fn () => $this->periodOptions())
                    ->placeholder('All periods')
                    ->live(),
                DatePicker::make('from')->label('From')->native(false)->live(),
                DatePicker::make('to')->label('To')->native(false)->live(),
            ]);
    }

    /** @return array<string, string> */
    private function periodOptions(): array
    {
        $employee = $this->employee();

        return $employee ? $employee->payrollLines()->pluck('period', 'period')->all() : [];
    }

    private function employee(): ?Employee
    {
        return ($id = $this->data['employee_id'] ?? null) ? Employee::query()->find($id) : null;
    }

    public function getReport(): ?AuditReport
    {
        $employee = $this->employee();
        if (! $employee) {
            return null;
        }

        $from = ($this->data['from'] ?? null) ? CarbonImmutable::parse($this->data['from'])->startOfDay() : null;
        $to = ($this->data['to'] ?? null) ? CarbonImmutable::parse($this->data['to'])->endOfDay() : null;

        $period = $this->data['period'] ?? null;

        return app(QueryBus::class)->ask(new GetAudit((string) $employee->getKey(), $from, $to, $period ? Period::parse($period) : null));
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('fullHistory')
                ->label('Full history')
                ->color('gray')
                ->action(fn () => $this->data = [...$this->data, 'from' => null, 'to' => null, 'period' => null]),
            Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (): ?StreamedResponse {
                    $report = $this->getReport();
                    if (! $report) {
                        return null;
                    }

                    return response()->streamDownload(function () use ($report) {
                        $rows = $report->rows();
                        $out = fopen('php://output', 'w');
                        fputcsv($out, array_keys($rows[0] ?? ['employee' => '']), escape: '');
                        foreach ($rows as $row) {
                            fputcsv($out, $row, escape: '');
                        }
                        fclose($out);
                    }, "audit-{$report->employeeId}.csv", ['Content-Type' => 'text/csv']);
                }),
        ];
    }
}
