@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Duties</h2>

    <!-- Display Notifications -->
    @if(auth()->check() && auth()->user()->notifications->isNotEmpty())
        <div class="mb-4">
            <h4>Notifications</h4>
            @foreach (auth()->user()->notifications as $notification)
                <div class="alert alert-info">
                    <strong>{{ $notification->data['title'] }}</strong>
                    <p>{{ $notification->data['description'] }}</p>
                    <p><strong>Time:</strong> {{ $notification->data['time'] }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Display Duties -->
    @foreach($duties as $duty)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">{{ $duty->title }}</h3>
                <p class="card-text">{{ $duty->description }}</p>
                <p><strong>Time:</strong> {{ $duty->time }}</p>

                <span class="badge {{ $duty->is_completed ? 'bg-success' : 'bg-warning' }}">
                    {{ $duty->is_completed ? 'Completed' : 'Pending' }}
                </span>

                <div class="mt-3">
                    @if(auth()->check() && auth()->user()->role === 'manager')
                        <!-- Edit Duty Button -->
                        <a href="{{ route('duties.edit', $duty->id) }}" class="btn btn-primary btn-sm mr-2">Edit Duty</a>
                        
                        <!-- Delete Duty Button -->
                        <form action="{{ route('duties.destroy', $duty->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete Duty</button>
                        </form>
                    @endif

                    @if(auth()->check() && auth()->user()->role === 'janitor' && !$duty->is_completed)
                        <!-- Mark as Done Button -->
                        <form action="{{ route('duties.markAsDone', $duty->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Mark as Done</button>
                        </form>
                    @endif

                    @if(Auth::check() && Auth::user()->role === 'janitor' && !$duty->is_completed && !$duty->shift_change_requested)
                        <!-- Request Shift Change Button -->
                        <form action="{{ route('duties.requestShiftChange', $duty->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm mt-2">Request Shift Change</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
