<?php

namespace App\Filament\Resources\Employees\RelationManagers;

use App\Filament\Pages\PayrollAudit;
use App\Models\PayrollLine;
use App\Payroll\Earning\Application\Command\AddAdjustment;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Domain\DomainRuleViolation;
use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

/** Earning lines of the employee, read from the Audit read model. The only write path from here is the "Add adjustment" command. */
class PayrollLinesRelationManager extends RelationManager
{
    protected static string $relationship = 'payrollLines';

    protected static ?string $title = 'Payroll periods';

    /** Rendered with the page instead of on scroll: the periods are the main content of the employee screen. */
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('period')->sortable(),
                TextColumn::make('system_value')->label('System value')->alignEnd()->state(fn (PayrollLine $r) => $r->systemValue()->format()),
                TextColumn::make('current_value')
                    ->label('Current value')
                    ->weight('bold')
                    ->alignEnd()
                    ->state(fn (PayrollLine $r) => $r->currentValue()->format()),
                IconColumn::make('frozen')->label('Frozen')->boolean(),
                TextColumn::make('adjustment_count')->label('Adjustments'),
            ])
            ->defaultSort('period', 'desc')
            ->recordActions([
                Action::make('adjust')
                    ->label('Add adjustment')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        TextInput::make('amount')
                            ->helperText('Positive or negative, e.g. -45.55')
                            ->required()
                            ->regex('/^[+-]?\d+(\.\d{1,2})?$/'),
                        Textarea::make('comment')->required(),
                        Hidden::make('key')->default(fn () => (string) Str::uuid()),
                    ])
                    ->action(function (PayrollLine $record, array $data, CommandBus $commands): void {
                        try {
                            $commands->dispatch(new AddAdjustment(
                                $record->employee_id,
                                Period::parse($record->period),
                                Money::parse($data['amount'], $record->currency),
                                $data['comment'],
                                auth()->user()?->name ?? 'unknown',
                                $data['key'],
                            ));
                        } catch (DomainRuleViolation $e) {
                            Notification::make()->title($e->getMessage())->danger()->send();

                            return;
                        }
                        Notification::make()->title('Adjustment saved')->success()->send();
                    }),
                Action::make('history')
                    ->label('History')
                    ->icon('heroicon-o-clock')
                    ->url(fn (PayrollLine $record) => PayrollAudit::getUrl(['employee' => $record->employee_id, 'period' => $record->period])),
            ]);
    }
}
