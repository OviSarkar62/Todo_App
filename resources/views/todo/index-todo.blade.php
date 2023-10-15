@extends('layouts.app') <!-- Include your layout file if you have one -->

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="create-body-container">
            <div class="card">
                <div class="card-header">Todo List</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todos as $todo)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $todo->header }}</td>
                                <td>{{ $todo->description }}</td>
                                <td>{{ date('d-m-Y', strtotime($todo->created_at . '+06:00')) }}</td>
                                <td>{{ date('d-m-Y', strtotime($todo->deadline . '+06:00')) }}</td>
                                <td>
                                    <a href="{{ route('edit.todo', $todo->id) }}" class="btn btn-primary">Edit</a>
                                    <form method="POST" action="{{ route('destroy.todo', $todo->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
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
