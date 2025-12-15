<?php

namespace App\Http\Controllers;

use App\Enums\EmployeeFileType;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeFile;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::query()->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.employees.create' , compact('departments'))  ;
    }

    public function store(StoreEmployeeRequest $request, EmployeeService $employeeService)
    {
        $validated = $request->validated();

        $employee = $employeeService->createEmployee(
            $validated,
            $request->file('avatar_url')
        );

        $allFiles = [];

        if ($request->hasFile('passport_copy')) {
            $allFiles['passport_copy'] = $request->file('passport_copy');
        }

        if ($request->hasFile('files')) {
            $allFiles['files'] = $request->file('files');
        }

        $employeeService->uploadEmployeeFiles($employee, $allFiles);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно создан и файлы загружены.');
    }



    public function show(Employee $employee)
    {
        $passportFiles = $employee->files()
            ->where('type', EmployeeFileType::PASSPORT)
            ->get();
        $otherFiles = $employee->files()
            ->where('type', EmployeeFileType::OTHER)
            ->get();
        return view('admin.employees.show', compact('employee', 'otherFiles', 'passportFiles'))
            ->with('canDelete', false);
    }


    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $passportFiles = $employee->files()
            ->where('type', EmployeeFileType::PASSPORT)
            ->get();
        $otherFiles = $employee->files()
            ->where('type', EmployeeFileType::OTHER)
            ->get();
        return view('admin.employees.edit', compact('employee', 'departments', 'passportFiles', 'otherFiles'))
            ->with('canDelete', true);
    }

    public function update(UpdateEmployeeRequest $request, EmployeeService $employeeService, Employee $employee)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar_url')) {
            $validated['avatar_url'] = $employeeService->handleAvatarUpload($request->file('avatar_url'), $employee);
        }

        if ($request->has('files_to_delete')) {
            $filesToDeleteIds = $request->input('files_to_delete');
            $filesToDelete = EmployeeFile::whereIn('id', $filesToDeleteIds)->get();
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file->file_url);
                $file->delete();
            }
        }

        $employee->update($validated);

        $allFiles = [];
        if ($request->hasFile('passport_copy')) {
            $allFiles['passport_copy'] = $request->file('passport_copy');
        }
        if ($request->hasFile('files')) {
            $allFiles['files'] = $request->file('files');
        }

        if (!empty($allFiles)) {
            $employeeService->uploadEmployeeFiles($employee, $allFiles);
        }

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно обновлён.');
    }



    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function byDepartment(Department $department)
    {
        $employees = $department->employees()->with('department')->paginate(10);
        return view('admin.employees.index', compact('employees', 'department'));
    }


}
