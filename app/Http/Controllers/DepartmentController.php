<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::query()->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }
    public function create()
    {
        return view('admin.departments.create');
    }
    public function store(StoreDepartmentRequest $request)
    {
        Department::create($request->validated());
        return redirect()
            ->route('admin.departments.index')
            ->with('success', __('Department created successfully.'));
    }

    public function show(Department $department)
    {
        return view('admin.departments.show', compact('department'));
    }
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
