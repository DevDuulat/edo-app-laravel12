<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Department::create($validatedData);

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
    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate(['name' => 'required', 'location' => 'nullable'] );
        $department->update($validatedData);
        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');

    }
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
