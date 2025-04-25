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

        return view('todo.index', compact('todos'));
    }

    public function create()
    {
        return view('todo.create');
    }

    public function edit()
    {
        return view('todo.edit');
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
}