<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeFile;
use App\Enums\EmployeeFileType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;

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
            $type = match ($input) {
                'passport_copy' => EmployeeFileType::PASSPORT,
                'files' => EmployeeFileType::OTHER,
            };

            $fileList = is_array($fileOrFiles) ? $fileOrFiles : [$fileOrFiles];

            foreach ($fileList as $file) {
                if (!$file instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $directory = 'employee_files/' . $employee->id;

                Storage::disk('public')->makeDirectory($directory);

                $fullPath = storage_path('app/public/' . $directory . '/' . $fileName);

                if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    Image::load($file->getRealPath())
                        ->width(1200)
                        ->optimize()
                        ->save($fullPath);
                } else {
                    $file->storeAs($directory, $fileName, 'public');
                }

                EmployeeFile::create([
                    'employee_id' => $employee->id,
                    'file_name'   => $file->getClientOriginalName(),
                    'file_url'    => $directory . '/' . $fileName,
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


    public function deleteAvatar(Employee $employee): void
    {
        if ($employee->avatar_url && Storage::disk('public')->exists($employee->avatar_url)) {
            Storage::disk('public')->delete($employee->avatar_url);
        }
    }

}
