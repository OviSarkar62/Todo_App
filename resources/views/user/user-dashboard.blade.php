@extends('layouts.app')
<style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</style>
<style>
    .toas {
        background-color: #f44336;
        color: #fff;
    }

    #toast-container>.toast-success {
        background-color: #4CAF50;
        color: #fff;
        height: 60px;
        width: 300px;
        overflow: hidden;
        border-radius: 3px;
        background-position: 15px center;
        /*background-repeat: no-repeat;*/
        box-shadow: 0 0 12px #999;
        opacity: .8;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        padding: 8px 16px;
    }

    #toast-container>.toast-error {
        background-color: #f44336;
        color: #fff;
    }

    .toast {
        width: 300px !important;
    }

    .card-text.checked {
        text-decoration: line-through;
    }

    /* Responsive Media Query */
    @media (max-width: 767px) {
        #toast-container.toast-bottom-full-width {
            bottom: 0; /* Fixed at the bottom */
            position: fixed; /* Fixed position regardless of the page scroll */
            width: 100%; /* Full width */
            padding: 0; /* Reset any padding if necessary */
            margin: 0 auto; /* Centered horizontally if needed */
            left: 0; /* Align to the left edge */
            right: 0; /* Align to the right edge */
        }

        .toast {
            width: auto !important; /* Allow toast to fill width */
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* This centers the cards in the row */
        }

        .row .col-md-8, /* Selector for the header card column */
        .row .col-md-4 { /* Selector for the todo cards column */
            flex: 0 0 100%; /* This makes each column take the full width of the row */
            max-width: 100%; /* Prevents any exceeding of the row's width */
        }
}
</style>
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-center align-items-center"
                        style="background-color: #232D3F; color: #fff;">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-full-width",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>

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

        function updateTodoDOM(todoId, completed) {
            const todoContainer = document.querySelector(`[data-todo-id="${todoId}"]`).closest('.dashboard-container');

            if (todoContainer) {
                const badge = todoContainer.querySelector('.badge');
                const toggleButton = todoContainer.querySelector('.toggle-todo');
                const cardText = todoContainer.querySelector('.card-text');

                if (badge && toggleButton && cardText) {
                    // Update badge classes and text
                    badge.classList.toggle('badge-success', completed);
                    badge.classList.toggle('badge-secondary', !completed);
                    badge.textContent = completed ? 'Completed' : 'Processing';

                    // Update checkmark button classes
                    toggleButton.classList.toggle('completed', completed);
                    toggleButton.classList.toggle('processing', !completed);

                    // Toggle the 'checked' class to apply or remove the strikethrough
                    cardText.classList.toggle('checked', completed);

                } else {
                    console.error('Badge, button, or card text elements not found.');
                }
            } else {
                console.error('Todo container not found.');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
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
