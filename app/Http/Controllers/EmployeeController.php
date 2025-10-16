<?php

namespace App\Http\Controllers;

use App\Enums\EmployeeFileType;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Services\EmployeeService;

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


    public function show(string $id)
    {
//        $employee = Employee::with(['department', 'files'])->findOrFail($id);
        $employee = Employee::findOrFail($id);
        $passportFiles = $employee->files()
            ->where('type', EmployeeFileType::PASSPORT)
            ->get();
        $otherFiles = $employee->files()
            ->where('type', EmployeeFileType::OTHER)
            ->get();
        return view('admin.employees.show', compact('employee', 'otherFiles', 'passportFiles'));

    }


    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $passportFile = $employee->files()
            ->where('type', EmployeeFileType::PASSPORT)
            ->get();
        $otherFiles = $employee->files()
            ->where('type', EmployeeFileType::OTHER)
            ->get();
        return view('admin.employees.edit', compact('employee', 'departments', 'otherFiles', 'passportFile'));
    }

    public function update(UpdateEmployeeRequest $request, EmployeeService $employeeService, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('avatar_url')) {
            $validated['avatar_url'] = $employeeService->handleAvatarUpload($request->file('avatar_url'), $employee);
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
