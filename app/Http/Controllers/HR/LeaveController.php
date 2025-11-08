<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Status: 0 = Pending, 1 = Approved, 2 = Rejected
        $pendingCount = LeaveRequest::where('status', 0)->count();

        $todayLeaves = LeaveRequest::whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->where('status', 1)
            ->count();

        // STATISTIK BARU: Menghitung cuti yang disetujui & ditolak bulan ini
        $approvedThisMonth = LeaveRequest::where('status', 1)
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        $rejectedThisMonth = LeaveRequest::where('status', 2)
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();


        $leaveRequests = LeaveRequest::with(['employee.department', 'employee.position'])
            ->orderByRaw('CASE WHEN status = ? THEN 0 ELSE 1 END', [0])
            ->latest()
            ->paginate(10);

        return view('hr.leaves.index', compact(
            'leaveRequests',
            'pendingCount',
            'todayLeaves',
            'approvedThisMonth',
            'rejectedThisMonth'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        return view('hr.leaves.show', ['leaveRequest' => $leaveRequest]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $leaveRequest = LeaveRequest::findOrFail($id);

            if ($request->action == 'approve') {
                $leaveRequest->update([
                    'status' => 1,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);

                toast('Leave request has been approved.', 'success');
                return redirect()->route('leaves.index')->with('success', 'Leave request has been approved.');
            }

            if ($request->action == 'reject') {
                $request->validate([
                    'rejection_reason' => 'required_without:no_reason|string|max:255',
                ]);

                $leaveRequest->update([
                    'status' => 2,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                    'rejection_reason' => $request->no_reason ? null : $request->rejection_reason,
                ]);

                toast('Leave request has been rejected.', 'success');
                return redirect()->route('leaves.index')->with('success', 'Leave request has been rejected.');
            }

            toast('Invalid action.', 'error');
            return redirect()->back()->with('error', 'Invalid action.');
        } catch (\Exception $e) {
            toast('Failed to update leave request: ' . $e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred while processing the request.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
