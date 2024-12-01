@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Shift Change Requests</h2>

    <!-- Display Notifications -->
    @if(auth()->check() && auth()->user()->role === 'manager')
        @foreach(auth()->user()->unreadNotifications as $notification)
            <div class="alert alert-info">
                <strong>{{ $notification->data['title'] }}</strong>
                <p>{{ $notification->data['description'] }}</p>
                <p><strong>Time:</strong> {{ $notification->data['time'] }}</p>

                <!-- Buttons for editing or deleting the duty -->
                <form action="{{ route('duties.edit', $notification->data['duty_id']) }}" method="GET" style="display: inline;">
                    <button type="submit" class="btn btn-primary btn-sm">Edit Duty</button>
                </form>

                <form action="{{ route('duties.destroy', $notification->data['duty_id']) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete Duty</button>
                </form>
            </div>
        @endforeach
    @endif

    <h2 class="mt-5 mb-4">Create Duty</h2>

    <!-- Create Duty Form (if the manager wants to create a new duty) -->
    <form action="{{ route('duties.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select class="form-control" id="assigned_to" name="assigned_to">
                <option value="">Select Janitor</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Duty</button>
    </form>
</div>
@endsection
