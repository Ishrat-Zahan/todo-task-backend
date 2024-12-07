<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return auth()->user()->todos;
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $todo = auth()->user()->todos()->create([
            'title' => $request->title,
        ]);

        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $todo->update($request->all());

        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);

        $todo->delete();

        return response()->noContent();
    }
}
