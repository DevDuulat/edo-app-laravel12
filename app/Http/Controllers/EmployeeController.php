<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
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

        $employeeService->uploadEmployeeFiles($employee, $request->allFiles());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно создан и файлы загружены.');
    }

    public function show(string $id)
    {
        $employee = Employee::with(['department', 'files'])->findOrFail($id);

        return view('admin.employees.show', compact('employee'));
    }


    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();

        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('avatar_url')) {
            if ($employee->avatar_url) {
                Storage::disk('public')->delete($employee->avatar_url);
            }
            $validated['avatar_url'] = $request->file('avatar_url')->store('avatars', 'public');
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
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
