<?php

namespace Modules\Attendance\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\Attendance;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    public function index()
    {
        return view('attendance::attendance.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
                ->select(['attendances.id', 'attendances.employee_id',
                    \DB::raw('CONCAT(employees.first_name, " ", employees.last_name,"-",employees.employee_id) AS employee_info'),
                    'attendances.attendance_date', 'attendances.machine_id',
                    'attendances.machine_state', 'attendances.checkType','attendances.sn','attendances.attendance_remarks',
                    'attendances.time','attendances.sensorId']);

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('attendances.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                            ';
                    //<a href="' . route('attendances.show', $row->id) . '" class="btn btn-sm btn-success">View</a>
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
//    public function index()
//    {
//        dd('working');
//        return view('attendence::index');
//    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('attendence::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('attendence::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('attendence::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
