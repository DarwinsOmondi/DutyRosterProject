<?php

namespace App\Http\Controllers;

use App\Models\Duty;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\DutyAssignedNotification;
use App\Notifications\ShiftChangeRequestedNotification;
use Illuminate\Support\Facades\Auth;

class DutyController extends Controller
{
    public function index()
    {
        $duties = Duty::all();
        return view('duties.index', compact('duties'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time' => 'required|date_format:H:i', // Validate time format
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Create the duty
        $duty = Duty::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'time' => $validatedData['time'],
            'assigned_to' => $validatedData['assigned_to'] ?? null,
        ]);

        // Notify the assigned user if any
        if ($duty->assigned_to) {
            $user = User::find($duty->assigned_to);
            $user->notify(new DutyAssignedNotification($duty));
        }

        return redirect()->route('duties.index')->with('success', 'Duty created successfully!');
    }

    public function update(Request $request, Duty $duty)
    {
        if (Auth::check() && Auth::user()->role === 'manager') {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'time' => 'required|date_format:H:i',
            ]);

            $duty->update($request->all());
        }

        return redirect()->route('duties.index')->with('success', 'Duty updated successfully!');
    }

    public function markAsDone(Duty $duty)
    {
        if (Auth::check() && Auth::user()->role === 'janitor') {
            $duty->update(['is_completed' => true]);
        }

        return redirect()->route('duties.index');
    }

    public function create()
    {
        $users = User::all();

        return view('duties.create', compact('users'));
    }


    
    public function edit(Duty $duty)
    {
        // Ensure that only the manager can edit the duty
        if (Auth::check() && Auth::user()->role === 'manager') {
            $users = User::all();
            return view('duties.edit', compact('duty', 'users'));
        }

        return redirect()->route('duties.index')->with('error', 'Unauthorized action.');
    }


    public function destroy(Duty $duty)
    {
        // Ensure that only the manager can delete the duty
        if (Auth::check() && Auth::user()->role === 'manager') {
            $duty->delete();
            return redirect()->route('duties.index')->with('success', 'Duty deleted successfully!');
        }

        return redirect()->route('duties.index')->with('error', 'Unauthorized action.');
    }

    public function requestShiftChangeForm()
    {
        $duties = Duty::where('assigned_to', Auth::id()) // Only show duties assigned to the logged-in janitor
                       ->where('is_completed', false)
                       ->where('shift_change_requested', false)
                       ->get();
        return view('duties.request', compact('duties'));
    }

    // Handle the shift change request
    public function requestShiftChange(Duty $duty)
    {
        // Check if the janitor is requesting a shift change
        if (Auth::check() && Auth::user()->role === 'janitor' && !$duty->is_completed && !$duty->shift_change_requested) {
            $duty->update(['shift_change_requested' => true]);

            // Notify the manager of the shift change request
            $manager = User::where('role', 'manager')->first(); // Assuming one manager for simplicity
            $manager->notify(new ShiftChangeRequestedNotification($duty));

            return redirect()->route('duties.index')->with('success', 'Shift change request sent!');
        }

        return redirect()->route('duties.index')->with('error', 'Unable to request shift change.');
    }

}
