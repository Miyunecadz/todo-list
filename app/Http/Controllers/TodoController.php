<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Todo::with(['owner', 'subTodos'])->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        return Todo::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        return $todo->load(['owner', 'subTodos']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        return response('Resource successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response('Resource successfully deleted!');
    }
}
