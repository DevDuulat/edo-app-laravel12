<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Models\Position;
use Alert;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::query()->paginate(15);

        return view('admin.positions.index', compact('positions'));
    }

    public function store(StorePositionRequest $request)
    {
        Position::create($request->validated());

        Alert::success('Должность успешно создан!', 'Готово');
        return redirect()->route('admin.positions.index');

    }

     public function destroy(Position $position)
    {
        $position->delete();
        Alert::error('Должность успешно удалён!', 'Готово');

        return redirect()->route('admin.positions.index');
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $position->update($validated);

        Alert::success('Должность успешно обновлен!', 'Готово');
        return redirect()->route('admin.positions.index');
    }
}
