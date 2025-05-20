<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // Private method for checking user ownership of todos
    private function authorizeUser(Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $todos = Todo::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('is_done', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $todosCompleted = Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function create()
    {
         $categories = Category::all(); 
        return view('todo.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:todos,title,NULL,id,user_id,' . Auth::id(),
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
            'is_done' => false,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

    public function edit(Todo $todo)
    {
        $this->authorizeUser($todo);

        $categories = Category::all();
        return view('todo.edit', compact('todo', 'categories'));
    }


    public function update(Request $request, Todo $todo)
    {
        $this->authorizeUser($todo);

        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $this->authorizeUser($todo);

        $todo->delete();
        return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
    }

    public function complete(Todo $todo)
    {
        $this->authorizeUser($todo);

        $todo->update(['is_done' => true]);
        return redirect()->route('todo.index')->with('success', 'Todo marked as complete.');
    }

    public function uncomplete(Todo $todo)
    {
        $this->authorizeUser($todo);

        $todo->update(['is_done' => false]);
        return redirect()->route('todo.index')->with('success', 'Todo marked as incomplete.');
    }

    public function deleteAllCompleted()
    {
        Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->delete();

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted.');
    }
}
