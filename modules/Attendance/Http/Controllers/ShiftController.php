<?php

namespace Modules\Attendance\Http\Controllers;

use App\DataTables\ShiftConfigDataTable;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attendance\Entities\Shift;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_shift_config')->only(['index']);
        $this->middleware('permission:create_shift_config')->only(['create', 'store']);
        $this->middleware('permission:update_shift_config')->only(['edit', 'update']);
        $this->middleware('permission:delete_shift_config')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     * @param ShiftConfigDataTable $dataTable
     * @return Renderable
     */
    public function index()
    {
        if (!auth()->user()->can('read_shift_config')) {
            abort(403, 'Unauthorized action.');
        }

        $shifts = Shift::all();
        return view('attendance::shift.index', compact('shifts'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('create_shift_config')) {
            abort(403, 'Unauthorized action.');
        }

        //$this->middleware('permission:create_shift_config');

        return view('attendance::shift.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->middleware('permission:create_shift_config');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'grace_period' => 'max:255',
            'is_next_day' => 'boolean',
            'status' => 'required|max:255',
            'description' => 'nullable|string',
            'isApplicableGracePeriod' => 'boolean',
        ]);

        // Handle next day scenario for end_time
        if ((int)$validated['is_next_day'] === 1) {
            $startDateTime = Carbon::createFromFormat('H:i', $validated['start_time']);
            $endDateTime = Carbon::createFromFormat('H:i', $validated['end_time'])->addDay();

            if ($startDateTime->greaterThanOrEqualTo($endDateTime)) {
                return redirect()->back()->withErrors([
                    'end_time' => 'The end time must be a date after start time when is_next_day is checked.',
                ]);
            }
        } else {
            $request->validate([
                'end_time' => 'after:start_time',
            ]);
        }
//dd($validated);
        Shift::create($validated);

        return redirect()->route('shifts.index')->with('success', 'Shift configuration saved successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     * @param ShiftConfig $shiftConfig
     * @return Renderable
     */
    public function edit($id)
    {
        $this->middleware('permission:update_shift_config');

        $shift = Shift::findOrFail($id); // Find the shift or throw a 404
        return view('attendance::shift.edit', compact('shift'));
    }

    /**
     * Update the specified shift in storage.
     */
    public function update(Request $request, $id)
    {
        $this->middleware('permission:update_shift_config');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'grace_period' => 'nullable|integer|min:0',
            'is_next_day' => 'boolean',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string',
            'isApplicableGracePeriod' => 'boolean',
        ]);

        if ((int)$validated['is_next_day'] === 1) {
            $startDateTime = Carbon::createFromFormat('H:i', $validated['start_time']);
            $endDateTime = Carbon::createFromFormat('H:i', $validated['end_time'])->addDay();

            if ($startDateTime->greaterThanOrEqualTo($endDateTime)) {
                return redirect()->back()->withErrors([
                    'end_time' => 'The end time must be a date after start time when is_next_day is checked.',
                ]);
            }
        } else {
            $request->validate([
                'end_time' => 'after:start_time',
            ]);
        }

        $shift = Shift::findOrFail($id);


        $shift->update($validated);

        return redirect()->route('shifts.index')->with('success', localize('shift_updated_successfully'));
    }

    /**
     * Remove the specified shift from storage.
     */
    public function destroy($id)
    {
        $this->middleware('permission:delete_shift_config');

        $shift = Shift::findOrFail($id); // Find the shift or throw a 404
        $shift->delete();

        return redirect()->route('shifts.index')->with('success', localize('shift_deleted_successfully'));
    }
}