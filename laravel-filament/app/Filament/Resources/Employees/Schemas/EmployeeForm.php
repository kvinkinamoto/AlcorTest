<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        $money = fn (string $name, string $label) => TextInput::make($name)
            ->label($label)
            ->required()
            ->regex('/^\d+(\.\d{1,2})?$/')
            ->default('0.00');

        return $schema->components([
            Section::make('Employee')->schema([
                TextInput::make('name')->required()->maxLength(255)->disabledOn('edit')->helperText('Fixed when the employee is hired.'),
                Select::make('currency')
                    ->options(['USD' => 'USD', 'EUR' => 'EUR', 'UAH' => 'UAH'])
                    ->default('USD')
                    ->required()
                    ->disabledOn('edit')
                    ->helperText('Fixed when the employee is hired.'),
            ])->columns(2),

            Section::make('Salary source data')
                ->description('The stub calculation is base salary − benefits deduction + bonus. Changing these values simulates "source data changed"; run the calculation to pick them up.')
                ->schema([
                    $money('base_salary', 'Base salary'),
                    $money('benefits_deduction', 'Benefits deduction'),
                    $money('bonus', 'Bonus'),
                ])->columns(3),
        ]);
    }
}
