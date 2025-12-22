<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Models\Position;
use Alert;

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
        Alert::error('Должнсть успешно удалён!', 'Готово');

        return redirect()->route('admin.positions.index');
    }
}
