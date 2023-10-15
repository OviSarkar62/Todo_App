@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Hello, {{ auth()->user()->name }}, manage your todos</h5>
                </div>
            </div>
            <div class="container-fluid px-4">
                <div class="row mt-4">
                    @foreach ($todos as $todo)
                        <div class="col-md-4 mb-4">
                            <div class="dashboard-container">
                                <div class="card">
                                    <div class="card-header">{{ $todo->header }}</div>
                                    <div class="card-body">
                                        <p class="card-text {{ $todo->completed ? 'checked' : '' }}">
                                            {{ $todo->description }}
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <span class="badge {{ $todo->completed ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $todo->completed ? 'Completed' : 'Processing' }}
                                        </span>
                                        <button
                                            class="btn btn-sm toggle-todo {{ $todo->completed ? 'completed' : 'processing' }}"
                                            data-todo-id="{{ $todo->id }}">
                                            &#10004;
                                        </button>
                                        <a href="{{ route('edit.todo', $todo->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('destroy.todo', $todo->id) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-todo');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const todoId = button.getAttribute('data-todo-id');
                    toggleTodoStatus(todoId, button); // Pass the button element to the function
                });
            });

            function toggleTodoStatus(todoId, button) {
                fetch(`/todos/toggle/${todoId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => {
                        if (response.status === 200) {
                            return response.json();
                        } else {
                            // Handle the case where the toggle was not successful
                            console.error('Toggle was not successful.');
                        }
                    })
                    .then(data => {
                        const taskDescription = document.querySelector(
                            `[data-todo-id="${todoId}"] .card-body .card-text`);
                        const toggleButton = document.querySelector(`[data-todo-id="${todoId}"] .toggle-todo`);

                        if (taskDescription && toggleButton) {
                            taskDescription.classList.toggle('checked');

                            if (data.completed) {
                                toggleButton.classList.add('completed');
                            } else {
                                toggleButton.classList.remove('completed');
                            }
                        }
                    });
            }
        });
    </script>
@endsection
