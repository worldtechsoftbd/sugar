<?php

namespace Modules\HumanResource\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\HumanResource\Entities\Employee;
use Modules\HumanResource\Entities\TourAndVisit;
use Modules\HumanResource\Entities\TourAndVisitLog;
use Modules\HumanResource\Http\Functions\EmployeeFunction;


class TourAndVisitController extends Controller
{

    private function getTourAndVisitLogs($tourOrVisitId)
    {
        $tourAndVisitLogs = TourAndVisitLog::where('tourOrVisitId', $tourOrVisitId)
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();

        // Initialize an array to hold the extracted data
        $logs = [];

        foreach ($tourAndVisitLogs as $log) {
            $info = $log->tourOrVisitInfo;

            $logs[] = [
                'appliedStatus' => $info['appliedStatus'] ?? null,
                'remarks' => $info['remarks'] ?? null,
                'responsiblePerson' => EmployeeFunction::getEmployeeDetailsFormatted($info['responsiblePerson']) ?? null,
                'loggedAt' => $log->created_at ?? null,
            ];
        }

        return $logs;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourAndVisit = TourAndVisit::all();
        return view('humanresource::tourAndVisit.index', compact('tourAndVisit'));
    }

    public function getTourAndVisitData()
    {
        // Fetch all records from the TourAndVisit model
        $tourAndVisit = TourAndVisit::query();

        // Prepare the data for DataTables
        return datatables()->eloquent($tourAndVisit)
            ->addColumn('action', function ($tourAndVisit) {
                // You can add action buttons here (e.g., edit, delete)
                return '<a href="' . route('tourAndVisit.edit', $tourAndVisit->id) . '" class="btn btn-sm btn-primary">Edit</a>
                <form action="' . route('tourAndVisit.destroy', $tourAndVisit->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>';
            })
            ->editColumn('created_at', function ($tourAndVisit) {
                return $tourAndVisit->created_at->format('Y-m-d H:i:s');
            })
            ->make(true); // Return JSON response for DataTables
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createOrEdit(TourAndVisit $tourAndVisit = null)
    {
        $loggedInUser = auth()->user();
        $role = $loggedInUser->roles->first();
        $loggedInEmployee = Employee::where('user_id', $loggedInUser->id)->first();

        if ($role && $role->role_code == 'super-admin') {
            $employees = Employee::get();
            $responsiblePerson = Employee::get();
        } else {
            $responsiblePerson = Employee::where('department_id', $loggedInEmployee->department_id)
                ->where('user_id', '!=', $loggedInUser->id)
                ->get();
            $employees = Employee::where('user_id', $loggedInUser->id)
                ->get();
        }

        return view('humanresource::tourAndVisit.createOrUpdate', compact('tourAndVisit', 'responsiblePerson', 'employees'));
    }

    /**
     * Store or update the resource in storage.
     */
    public function storeOrUpdate(Request $request, TourAndVisit $tourAndVisit = null): RedirectResponse
    {
        try {
            $request->validate([
                'emp_id' => 'required',
                'applied_year' => 'required|numeric',
                'type_id' => 'required',
                'applied_date' => 'required|date',
                'started_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:started_date',
            ]);

            $data = $request->all();
            $data['appliedStatus'] = 1;
            $data['status'] = $tourAndVisit ? 201 : 101;

            if ($tourAndVisit) {
                $tourAndVisit->update($data);
                $message = localize('Tour/Visit updated successfully');
            } else {
                TourAndVisit::create($data);
                $message = localize('Tour/Visit created successfully');
            }

            return redirect()->route('tourAndVisit.index')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function viewHeadOrHrApproval($uuid)
    {
        $tourAndVisit = TourAndVisit::where('uuid', $uuid)->first();
        $tourAndVisitLogs = $this->getTourAndVisitLogs($tourAndVisit->id);
        return view('humanresource::tourAndVisit.approveTourAndVisit', compact('tourAndVisit', 'tourAndVisitLogs'));
    }

    public function approveTourAndVisit(Request $request): RedirectResponse
    {

        try {
            $tourAndVisit = TourAndVisit::findOrFail($request->id);

            // Update tour/visit status
            $tourAndVisit->update([
                'responsiblePerson' => (auth()->user()->roles->contains('role_code', 'super-admin') || auth()->user()->roles->contains('role_code', 'hr-admin'))
                    ? $request->hrApproval
                    : $request->headApproval,
                'appliedStatus' => $request->appliedStatus,
                'remarks' => $request->remarks
            ]);

            return redirect()->route('tourAndVisit.index')
                ->with('success', localize('Tour/Visit status updated successfully'));

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('humanresource::show');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
