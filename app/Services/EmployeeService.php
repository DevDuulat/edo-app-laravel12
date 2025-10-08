<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeFile;
use App\Enums\EmployeeFileType;

class EmployeeService
{
    public function createEmployee(array $data, ?\Illuminate\Http\UploadedFile $avatar = null): Employee
    {
        if ($avatar) {
            $data['avatar_url'] = $avatar->store('avatars', 'public');
        }

        return Employee::create($data);
    }

    public function uploadEmployeeFiles(Employee $employee, array $files): void
    {
        $documents = [
            'passport_copy' => EmployeeFileType::PASSPORT,
            'inn_file' => EmployeeFileType::INN,
            'snils_file' => EmployeeFileType::SNILS,
        ];

        foreach ($documents as $input => $typeEnum) {
            if (isset($files[$input])) {
                $path = $files[$input]->store("employee_files/{$employee->id}", 'public');
                EmployeeFile::create([
                    'employee_id' => $employee->id,
                    'file_name' => basename($path),
                    'file_url' => $path,
                    'type' => $typeEnum,
                ]);
            }
        }
    }
}
