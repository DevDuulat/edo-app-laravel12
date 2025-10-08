<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'passport_number' => 'nullable|string|max:20',
            'inn' => 'nullable|string|max:12',
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar_url')) {
            $path = $request->file('avatar_url')->store('avatars', 'public');
            $validated['avatar_url'] = $path;
        }

        Employee::create($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник успешно создан.');
    }



    public function show(string $id)
    {
        $employee = Employee::with('department')->findOrFail($id);

        return view('admin.employees.show', compact('employee'));
    }


    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();

        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'passport_number' => 'nullable|string|max:20',
            'inn' => 'nullable|string|max:12',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('avatar_url')) {
            if ($employee->avatar_url) {
                Storage::disk('public')->delete($employee->avatar_url);
            }


            $avatarPath = $request->file('avatar_url')->store('avatars', 'public');
            $validated['avatar_url'] = $avatarPath;
        } else {

            unset($validated['avatar_url']);
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
