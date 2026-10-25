<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Filament\Resources\Employees\Tables\EmployeesTable;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\Workforce\Application\Command\ChangeSourceData;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        // No delete: an employee with payroll history is part of the audit trail.
        return [
            // Reload afterwards so the "Payroll periods" tab below shows the line that was just calculated.
            EmployeesTable::calculateAction()->after(fn () => $this->redirect(EmployeeResource::getUrl('edit', ['record' => $this->getRecord()]))),
        ];
    }

    /** Only the salary source data can change after hiring, and it changes through a command. */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        app(CommandBus::class)->dispatch(new ChangeSourceData(
            (string) $record->getKey(),
            $data['base_salary'],
            $data['benefits_deduction'],
            $data['bonus'],
        ));

        return $record->refresh();
    }
}
