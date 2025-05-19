<?php

namespace Modules\Attendance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attendance\Entities\DeviceAttendance;
use Yajra\DataTables\DataTables;


class DeviceAttendanceController extends Controller
{
    public function index()
    {
        return view('attendance::attendance.device.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = DeviceAttendance::select([
                'id', 'userId', 'status', 'checkTime', 'checkType',
                'verifyCode', 'sensorId', 'memoInfo', 'workCode', 'sn', 'userExtFmt'
            ]);

            return DataTables::of($data)
//                ->addColumn('action', function ($row) {
//                    return '<a href="' . route('device_attendances.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
//                            <a href="' . route('device_attendances.show', $row->id) . '" class="btn btn-sm btn-success">View</a>';
//                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
