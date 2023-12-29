@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 768px) {
    /* Force table to not be like tables anymore */
    table, thead, tbody, th, td, tr {
        display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    tr { border: 1px solid #ccc; }

    td {
        /* Behave like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
    }

    td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        /* Label the data */
        content: attr(data-title);
    }
    .card-header {
        background-color: #232D3F; /* Set a background color for the card header */
        color: #fff;
    }
}
.card-header {
        background-color: #232D3F; /* Set a background color for the card header */
        color: #fff;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Todo List</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todos as $todo)
                                <tr>
                                    <td scope="row">{{ $loop->index+1 }}</td>
                                    <td>{{ $todo->header }}</td>
                                    <td>{{ $todo->description }}</td>
                                    <td>{{ date('d-m-Y', strtotime($todo->deadline . '+06:00')) }}</td>
                                    <td>
                                        <a href="{{ route('edit.todo', $todo->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('destroy.todo', $todo->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
