@extends('layouts.app')

@section('content')
<div class="card shadow-lg" style="max-width: 700px; margin: 50px auto;">
    <div class="card-header text-center bg-primary text-white">
        <h4>Edit Duty</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('duties.update', $duty->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title input -->
            <div class="mb-4">
                <label for="title" class="form-label">Duty Title</label>
                <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Enter the duty title" value="{{ old('title', $duty->title) }}" required>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description input -->
            <div class="mb-4">
                <label for="description" class="form-label">Duty Description</label>
                <textarea name="description" id="description" class="form-control form-control-lg" placeholder="Enter the duty description" required>{{ old('description', $duty->description) }}</textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Assign To dropdown -->
            <div class="mb-4">
                <label for="assigned_to" class="form-label">Assign to (optional)</label>
                <select name="assigned_to" id="assigned_to" class="form-select form-select-lg">
                    <option value="">None</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $duty->assigned_to) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
                @error('assigned_to')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg px-4 py-2">Update Duty</button>
            </div>
        </form>
    </div>
</div>
@endsection
