<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class ProcessController extends Controller
{
    /**
     * Display a listing of the technician's assigned tasks (processes)
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all tasks assigned to this technician
        $tasks = Ticket::where('technician_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('technician.process.index', compact('tasks'));
    }

    /**
     * Display the specified task
     */
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        
        // Verify the task belongs to this technician
        if ($ticket->technician_id !== $user->id) {
            abort(403, 'Unauthorized access to this task');
        }

        return view('technician.process.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified task
     */
    public function edit(Ticket $ticket)
    {
        $user = Auth::user();
        
        // Verify the task belongs to this technician
        if ($ticket->technician_id !== $user->id) {
            abort(403, 'Unauthorized access to this task');
        }

        return view('technician.process.edit', compact('ticket'));
    }

    /**
     * Update the specified task in storage
     */
    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        
        // Verify the task belongs to this technician
        if ($ticket->technician_id !== $user->id) {
            abort(403, 'Unauthorized access to this task');
        }

        $validated = $request->validate([
            'status' => 'required|in:assigned,in_progress,pending,resolved,closed',
            'notes' => 'nullable|string',
            'completion_date' => 'nullable|date',
        ]);

        $ticket->update($validated);

        return redirect()->route('technician.process.show', $ticket)->with('success', 'Task updated successfully');
    }
}
