<?php


namespace Modules\Organization\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Modules\Organization\App\Models\ShiftMaster;
use Yajra\DataTables\DataTables;


class ShiftMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_shift_master', ['only' => ['index', 'getShiftDetails']]);
        $this->middleware('permission:create_shift_master', ['only' => ['store']]);
        $this->middleware('permission:edit_shift_master', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_shift_master', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('read_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $shiftMasters = ShiftMaster::paginate(5);

        return view('organization::shiftMaster.index', ['shiftMasters' => $shiftMasters]);
    }

    public function getData(Request $request)
    {
        if (!auth()->user()->can('read_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $query = ShiftMaster::select([
            'ShiftID',
            'ShiftName',
            'Description',
            'StartTime',
            'EndTime',
            'GracePeriod',
            'IsApplicableGracePeriod',
            'Status'
        ]);

        return DataTables::of($query)
            ->addColumn('action', function ($shiftMaster) {
                return '
                <a href="' . route('shiftMasters.edit', $shiftMaster->ShiftID) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:void(0)" onclick="deleteShift(' . $shiftMaster->ShiftID . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
            ';
            })
            ->editColumn('Status', function ($shiftMaster) {
                return $shiftMaster->Status == 1 ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getShiftDetails()
    {
        if (!auth()->user()->can('read_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $shiftMasters = Shiftmaster::paginate(5);
        return view('organization::shiftMasters.details', ['shiftMasters' => $shiftMasters]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->user()->can('create_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'ShiftName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'StartTime' => 'required|date_format:H:i:s',
            'EndTime' => 'required|date_format:H:i:s|after:StartTime',
            'GracePeriod' => 'nullable|integer|min:0',
            'IsApplicableGracePeriod' => 'required|boolean',
            'Status' => 'required|integer|in:1,2,276',
        ]);

        ShiftMaster::create($request->all());
        Toastr::success('Shift added successfully :)', 'Success');
        return redirect()->route('shiftMasters.index');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $shift = ShiftMaster::where('ShiftID', $id)->firstOrFail();
        return view('organization::shiftMasters.edit', compact('shift'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('edit_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'ShiftName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'StartTime' => 'required|date_format:H:i:s',
            'EndTime' => 'required|date_format:H:i:s|after:StartTime',
            'GracePeriod' => 'nullable|integer|min:0',
            'IsApplicableGracePeriod' => 'required|boolean',
            'Status' => 'required|integer|in:1,2,276',
        ]);

        $shift = ShiftMaster::where('ShiftID', $id)->firstOrFail();
        $shift->update($request->all());

        Toastr::success('Shift updated successfully :)', 'Success');
        return redirect()->route('shiftMasters.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_shift_master')) {
            abort(403, 'Unauthorized action.');
        }

        $shift = Shiftmaster::where('id', $id)->firstOrFail();
        $shift->update(['Status' => Shiftmaster::STATUS_DELETED]);
        Toastr::success('Shift deleted successfully :)', 'Success');
        return response()->json(['success' => 'success']);
    }
}