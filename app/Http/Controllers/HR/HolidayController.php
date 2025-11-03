<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $availableYears = Holiday::selectRaw('EXTRACT(YEAR FROM date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->input('year', date('Y'));

        $query = Holiday::query();

        if ($selectedYear && $selectedYear !== 'all') {
            $query->whereYear('date', $selectedYear);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->input('search') . '%');
        }

        $holidays = $query->orderBy('date', 'asc')->get();

        $holidaysByMonth = $holidays->groupBy(function ($holiday) {
            return \Carbon\Carbon::parse($holiday->date)->format('F Y');
        });

        return view('hr.holidays.index', compact('holidaysByMonth', 'availableYears', 'selectedYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date',
        ]);

        try {
            Holiday::create($validated);
            toast('Holiday added successfully', 'success');
            return redirect()->route('holidays.index')->with('success', 'Holiday added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add holiday: ' . $e->getMessage());
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        toast('Holiday deleted successfully', 'success');
        return redirect()->route('holidays.index')->with('success', 'Holiday deleted successfully.');
    }
}
