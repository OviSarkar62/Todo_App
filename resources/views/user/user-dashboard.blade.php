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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-center align-items-center" style="background-color: #232D3F; color: #fff;">
                        <h5>Welcome, {{ ucwords(auth()->user()->name) }}</h5>
                    </div>
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
                                        <button class="btn btn-sm toggle-todo {{ $todo->completed ? 'completed' : 'processing' }}" data-todo-id="{{ $todo->id }}">
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
        async function toggleTodoStatus(todoId) {
            try {
                const response = await fetch(`/todos/toggle/${todoId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                });

                if (response.ok) {
                    const data = await response.json();
                    updateTodoDOM(todoId, data.completed, data.description);
                } else {
                    console.error('Toggle request failed with status:', response.status);
                }
            } catch (error) {
                console.error('Error during toggle:', error);
            }
        }

        function updateTodoDOM(todoId, completed, description) {
            const todoContainer = document.querySelector(`[data-todo-id="${todoId}"]`);

            if (todoContainer) {
                console.log('Todo container found:', todoContainer);

                const cardText = todoContainer.querySelector('.card-text');
                const toggleButton = todoContainer.querySelector('.toggle-todo');

                if (cardText && toggleButton) {
                    console.log('Card elements found:', cardText, toggleButton);

                    toggleButton.classList.toggle('completed', completed);
                    cardText.innerText = description;
                } else {
                    console.error('Card elements not found.');
                }
            } else {
                console.error('Todo container not found.');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-todo');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const todoId = button.getAttribute('data-todo-id');
                    toggleTodoStatus(todoId);
                });
            });
        });

    </script>
@endsection
