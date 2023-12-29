<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // User Dashboard Page
    public function index()
    {
        if (Auth::check()) {
            $todos = Todo::where('user_id', auth()->user()->id)->get();
            return view('user.user-dashboard', compact('todos'));
        } else {
            return redirect()->route('login'); // Redirect to the login page
        }
    }

    // Add Todo Page
    public function createTodo()
    {
        if (Auth::check()) {
            return view('todo.create-todo');
        } else {
            return redirect()->route('login'); // Redirect to the login page
        }
    }

    // Store Todo Page

    public function storeTodo(Request $request)
    {
        $this->validate($request, [
            'header' => 'required',
            'description' => 'required',
            'deadline' => 'date|nullable',
        ]);

        $todo = new Todo;
        $todo->header = $request->input('header');
        $todo->description = $request->input('description');
        $todo->deadline = $request->input('deadline');
        $todo->user_id = auth()->user()->id;

        $todo->save();

        return redirect('/dashboard')->with('success', 'Todo created successfully.');
    }

    public function todoList()
    {
        if (Auth::check()) {
            $todos = Todo::where('user_id', auth()->user()->id)->get();
            return view('todo.index-todo', compact('todos'));
        } else {
            return redirect()->route('login');
        }
    }

    public function editTodo($id)
    {
        $todo = Todo::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        return view('todo.edit-todo', compact('todo'));
    }

    public function updateTodo(Request $request, $id)
    {
        $todo = Todo::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $this->validate($request, [
            'header' => 'required',
            'description' => 'required',
            'deadline' => 'date|nullable',
        ]);

        $todo->update([
            'header' => $request->input('header'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Todo updated successfully.');
    }

    public function destroyTodo($id)
    {
        $todo = Todo::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $todo->delete();
        return redirect()->route('user.dashboard')->with('success', 'Todo deleted successfully.');
    }

    public function toggleStatus($id)
    {
        // Find the todo by ID
        $todo = Todo::findOrFail($id);

        // Toggle the status (from completed to processing or vice versa)
        $todo->completed = !$todo->completed;
        $todo->save();

        return response()->json(['completed' => $todo->completed]);
    }

}
