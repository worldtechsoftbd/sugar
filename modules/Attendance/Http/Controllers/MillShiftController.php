<?php

namespace Modules\Attendance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Attendance\Entities\MillShift;
use Modules\Attendance\Entities\Shift;
use Modules\HumanResource\Entities\Department;
use Modules\Organization\App\Models\Organization;
use Modules\Organization\App\Models\OrganizationOffices;
use PDO;

class MillShiftController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_organization_shift_config')->only(['index']);
        $this->middleware('permission:create_organization_shift_config')->only(['create', 'store']);
        $this->middleware('permission:update_organization_shift_config')->only(['edit', 'update']);
        $this->middleware('permission:delete_organization_shift_config')->only(['destroy']);
    }
    public function index()
    {
        if (!auth()->user()->can('read_organization_shift_config')) {
            abort(403, 'Unauthorized action.');
        }
        $mills=Department::all();
        $millShifts = MillShift::with('shift')->get();
        return view('attendance::mill_shifts.index', compact('millShifts', 'mills'));

    }
    public function getOffices($organizationId)
    {
        $offices = OrganizationOffices::where('org_id', $organizationId)->get();
//        foreach ($offices as $office)
//        {
//            $departments = Department::where('org_offices_id', $office->id)->get();
//        }

        return response()->json($offices);
    }

    public function create()
    {
        if (!auth()->user()->can('create_organization_shift_config')) {
            abort(403, 'Unauthorized action.');
        }
        $org=Organization::all();
        $shifts = Shift::all();
        //$millShift = MillShift::with('shift')->get();
        return view('attendance::mill_shifts.create', compact('org', 'shifts'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_organization_shift_config')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            // 'mill_id' => 'required|exists:mills,id',
            // 'shift_id' => 'required|exists:shifts,id',
            'status' => 'required|boolean',
        ]);
        MillShift::create($request->all());
        // Redirect to a specific page after storing data
        return redirect()->route('attendance.mill-shifts.index') // Replace with your index route name
        ->with('message', 'Organization-Shift mapping created successfully.');
    }


//    public function edit($id)
//    {
//        $millShift = MillShift::findOrFail($id);
////        $mills = Mill::all();
//        $org=Organization::all();
//        $departments = Department::where('org_offices_id', $millShift->DepartmentId)->get();
//
//        $shifts = Shift::all();
//        return view('attendance::mill_shifts.edit', compact('millShift', 'org', 'shifts','departments'));
//    }

    public function edit($id)
    {
        if (!auth()->user()->can('update_organization_shift_config')) {
            abort(403, 'Unauthorized action.');
        }
        $millShift = MillShift::findOrFail($id);
        $org = Organization::all();
        $shifts = Shift::all();
        return view('attendance::mill_shifts.edit', compact('millShift', 'org', 'shifts'));
    }


    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('update_organization_shift_config')) {
            abort(403, 'Unauthorized action.');
        }
        $millShift = MillShift::findOrFail($id);
        $request->validate([
            'mill_id' => 'required',
            'shift_id' => 'required|exists:shifts,id',
            'status' => 'required|boolean',
        ]);
        //dd($request->all());
        $millShift->update($request->all());
        return redirect()->route('attendance.mill-shifts.index')->with('message', 'Mill-Shift mapping updated successfully.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_organization_shift_config')) {
            abort(403, 'Unauthorized action.');
        }
        MillShift::findOrFail($id)->delete();
        return redirect()->back()->with('message', 'Mill-Shift mapping deleted successfully.');
    }

    public function importUserInfo()
    {
        try {
            // Path to the Microsoft Access database file
            $dbFile = "G:/xampp 8.2 latest/htdocs/database/attBackup.mdb";
            $connStr = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFile;";

            // Connect to the Access database
            $pdo = new PDO($connStr);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch data from the userinfo table
            $query = "SELECT * FROM userinfo";
            $stmt = $pdo->query($query);

            foreach ($stmt as $row) {
                // Extract data from the row
                $USERID = $row['USERID']; // Replace with the actual column name for user ID
                $NAME = $row['Name'];     // Replace with the actual column name for user name

                // Check if the USERID already exists in the employees table
                $exists = DB::table('employees')->where('id', $USERID)->exists();

                if (!$exists) {
                    // Insert data into the employees table if it does not exist
                    DB::table('employees')->insert([
                        'id' => $USERID,         // Assuming `id` is the primary key in `employees` table
                        'first_name' => $NAME,   // Assuming `first_name` is the column for the name
                        'user_id' => $USERID,    // Assuming `user_id` is a required column
                    ]);
                }
            }


            return response()->json(['message' => 'Data imported successfully'], 200);
        } catch (PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
