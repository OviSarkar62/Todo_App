@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="create-body-container">
                <div class="card">
                    <div class="card-header">
                        Add Todo
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('store.todo') }}">
                            @csrf
                            <div class="form-group">
                                <label for="header">Todo Header</label>
                                <input type="text" name="header" id="header" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="description">Todo Description</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="date" name="deadline" id="deadline" class="form-control">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
