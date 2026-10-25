<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Employee;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\Workforce\Application\Command\ChangeSourceData;
use App\Payroll\Workforce\Application\Command\HireEmployee;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    /** Hiring is a Workforce command; the record shown afterwards is read back from the employees table. */
    protected function handleRecordCreation(array $data): Model
    {
        $commands = app(CommandBus::class);
        $id = (string) Str::ulid();

        $commands->dispatch(new HireEmployee($id, $data['name'], $data['base_salary'], $data['currency']));
        $commands->dispatch(new ChangeSourceData($id, benefitsDeduction: $data['benefits_deduction'], bonus: $data['bonus']));

        return Employee::query()->findOrFail($id);
    }
}
