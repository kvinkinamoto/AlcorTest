<?php

namespace App\Filament\Resources\Employees\Tables;

use App\Filament\Pages\PayrollAudit;
use App\Models\Employee;
use App\Payroll\Earning\Application\Command\CalculateEarningLine;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Period;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('currency'),
                TextColumn::make('base_salary')->label('Base')->alignEnd(),
                TextColumn::make('benefits_deduction')->label('Benefits')->alignEnd(),
                TextColumn::make('bonus')->alignEnd(),
                TextColumn::make('payroll_lines_count')->counts('payrollLines')->label('Periods'),
            ])
            ->recordActions([
                EditAction::make(),
                self::calculateAction(),
                Action::make('audit')
                    ->label('Audit')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->url(fn (Employee $record) => PayrollAudit::getUrl(['employee' => $record->id])),
            ]);
    }

    public static function calculateAction(): Action
    {
        return Action::make('calculate')
            ->label('Calculate payroll')
            ->icon('heroicon-o-calculator')
            ->schema([
                TextInput::make('period')->label('Period (YYYY-MM)')->default(now()->format('Y-m'))->required()->regex('/^\d{4}-(0[1-9]|1[0-2])$/'),
            ])
            ->action(function (Employee $record, array $data, CommandBus $commands): void {
                $outcome = $commands->dispatch(new CalculateEarningLine((string) $record->getKey(), Period::parse($data['period'])));

                $notification = Notification::make()->title(match ($outcome->value) {
                    'created' => "Line for {$data['period']} created",
                    'recalculated' => "Line for {$data['period']} recalculated",
                    'ignored' => 'Ignored: the line already has manual adjustments (logged in the audit)',
                });
                $outcome->value === 'ignored' ? $notification->warning() : $notification->success();
                $notification->send();
            });
    }
}
