@extends('layouts.app') <!-- Include your layout file if you have one -->

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="create-body-container">
            <div class="card">
                <div class="card-header">Edit Todo</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('update.todo', $todo->id) }}">
                        @csrf
                        @method('PUT') <!-- Use PUT method for updates -->

                        <div class="form-group">
                            <label for="header">Todo Header</label>
                            <input type="text" name="header" id="header" class="form-control" value="{{ $todo->header }}" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="description">Todo Description</label>
                            <textarea name="description" id="description" class="form-control" required>{{ $todo->description }}</textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ $todo->deadline }}">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
