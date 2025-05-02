<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function index()
    {

        $todos = Todo::where('user_id', Auth::id())->orderBy('is_done', 'desc')->get();

  
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_done', true)
            ->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }


    public function create()
    {
        return view('todo.create');
    }

    public function edit(Todo $todo)
    {

        if (auth()->user()->id == $todo->user_id) {
            return view('todo.edit', compact('todo'));
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }
    }

    public function update(Request $request, Todo $todo)
    {

        $request->validate([
            'title' => 'required|max:255',
        ]);


        $todo->update([
            'title' => ucfirst($request->title),
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }


    public function complete(Todo $todo)
    {

        $todo->update(['is_done' => true]);

        return redirect()->route('todo.index')->with('success', 'Todo marked as complete.');
    }

    public function uncomplete(Todo $todo)
    {
        $todo->update(['is_done' => false]);

        return redirect()->route('todo.index')->with('success', 'Todo marked as incomplete.');
    }

 
    public function store(Request $request)
    {
   
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $todo = Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
            'is_done' => false,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo Created Successfully');
    }


    public function destroy(Todo $todo)
    {

        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }


    public function deleteAllCompleted()
    {
       
        Todo::where('is_done', true)->delete();

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully.');
    }
}
