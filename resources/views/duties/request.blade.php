@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Request Shift Change</h2>

    <!-- Display Duties that can be requested for shift change -->
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
                    @if(auth()->check() && auth()->user()->role === 'janitor' && !$duty->is_completed && !$duty->shift_change_requested)
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
