<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myRequests = LeaveRequest::where('employee_id', Auth::user()->employee->id)
            ->latest()
            ->paginate(10);

        return view('userLeave.index', compact('myRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('userLeave.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments/leaves', 'public');
        }

        LeaveRequest::create([
            'employee_id' => Auth::user()->employee->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 0, // 0: Pending
        ]);

        return redirect()->route('my-leaves.index')->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        if ($leaveRequest->employee_id !== Auth::user()->employee->id) {
            abort(403, 'UNAUTHORIZED ACTION');
        }

        if ($leaveRequest->status !== 0) {
            return redirect()->route('my-leaves.index')->with('error', 'Cannot edit a request that has already been processed.');
        }

        return view('userLeave.edit', compact('leaveRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        // Otorisasi
        if ($leaveRequest->employee_id !== Auth::user()->employee->id) {
            abort(403, 'UNAUTHORIZED ACTION');
        }

        // Validasi
        $request->validate([
            'leave_type' => 'required|integer|in:0,1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $attachmentPath = $leaveRequest->attachment;
        if ($request->hasFile('attachment')) {
            // Hapus file lama jika ada
            if ($leaveRequest->attachment) {
                Storage::disk('public')->delete($leaveRequest->attachment);
            }
            $attachmentPath = $request->file('attachment')->store('attachments/leaves', 'public');
        }

        $leaveRequest->update([
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('my-leaves.index')->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        // Otorisasi
        if ($leaveRequest->employee_id !== Auth::user()->employee->id) {
            abort(403, 'UNAUTHORIZED ACTION');
        }

        // Hanya bisa dihapus jika status 'Pending'
        if ($leaveRequest->status !== 0) {
            return redirect()->route('my-leaves.index')->with('error', 'Cannot delete a request that has already been processed.');
        }

        // Hapus attachment dari storage
        if ($leaveRequest->attachment) {
            Storage::disk('public')->delete($leaveRequest->attachment);
        }

        $leaveRequest->delete();

        return redirect()->route('my-leaves.index')->with('success', 'Leave request deleted successfully.');
    }
}
