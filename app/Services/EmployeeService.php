<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeFile;
use App\Enums\EmployeeFileType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EmployeeService
{
    public function createEmployee(array $data, ?UploadedFile $avatar = null): Employee
    {
        if ($avatar) {
            $data['avatar_url'] = $avatar->store('avatars', 'public');
        }

        return Employee::create($data);
    }

    public function uploadEmployeeFiles(Employee $employee, array $files): void
    {
        foreach ($files as $input => $fileOrFiles) {
            // Определяем тип файла
            $type = match ($input) {
                'passport_copy' => EmployeeFileType::PASSPORT,
                'files' => EmployeeFileType::OTHER,
            };
            // Если пришёл массив (множественные файлы)
            $fileList = is_array($fileOrFiles) ? $fileOrFiles : [$fileOrFiles];

            foreach ($fileList as $file) {
                if (!$file instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                $path = $file->store("employee_files/{$employee->id}", 'public');

                EmployeeFile::create([
                    'employee_id' => $employee->id,
                    'file_name'   => basename($path),
                    'file_url'    => $path,
                    'type'        => $type,
                ]);
            }
        }
    }



    public function handleAvatarUpload(?UploadedFile $file, Employee $employee): ?string
    {
        if (!$file) {
            return $employee->avatar_url;
        }

        if ($employee->avatar_url) {
            Storage::disk('public')->delete($employee->avatar_url);
        }

        return $file->store('avatars', 'public');
    }

}
