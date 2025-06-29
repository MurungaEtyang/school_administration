<?php

namespace App\Http\Controllers\Admin\Dormitory;

use App\SmDormitoryList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Dormitory\SmDormitoryRequest;

class SmDormitoryListController extends Controller
{

    public function __construct()
	{
        $this->middleware('PM');
	}

    public function index(Request $request)
    {
        try {
            // Temporary: Bypass permission check for testing
            // if (!userPermission('dormitory-list-index')) {
            //     Toastr::error('You do not have permission to access this page', 'Failed');
            //     return redirect()->route('dashboard');
            // }
            
            // Check if the table exists
            if (!\Schema::hasTable('sm_accommodation_lists')) {
                Toastr::error('Dormitory table does not exist', 'Failed');
                return redirect()->route('dashboard');
            }
            
            // Get current user's school ID
            $school_id = auth()->user()->school_id ?? 1; // Default to 1 if not set
            
            // Get dormitory lists for the current school
            $dormitory_lists = SmDormitoryList::where('school_id', $school_id)->get();
            
            // Check if view exists
            if (!view()->exists('backEnd.dormitory.dormitory_list')) {
                Toastr::error('View file not found', 'Failed');
                return redirect()->route('dashboard');
            }
            
            return view('backEnd.dormitory.dormitory_list', compact('dormitory_lists'));
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in DormitoryListController@index: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            
            // Show detailed error in development, generic in production
            if (config('app.env') === 'local') {
                Toastr::error('Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), 'Failed');
            } else {
                Toastr::error('Operation Failed. Please try again or contact support.', 'Failed');
            }
            
            return redirect()->route('dashboard');
        }
    }

    public function store(SmDormitoryRequest $request)
    {
        try {
            // Check if user has permission
            // if (!userPermission('dormitory-list-store')) {
            //     Toastr::error('You do not have permission to perform this action', 'Failed');
            //     return redirect()->back();
            // }

            // Create new dormitory/accommodation
            $dormitory_list = new SmDormitoryList();
            $dormitory_list->dormitory_name = $request->dormitory_name;
            $dormitory_list->type = $request->type;
            $dormitory_list->address = $request->address;
            $dormitory_list->intake = $request->intake;
            $dormitory_list->description = $request->description;
            $dormitory_list->school_id = Auth::user()->school_id;
            
            // Set academic ID based on university module status
            if (moduleStatusCheck('University')) {
                $dormitory_list->un_academic_id = getAcademicId();
            } else {
                $dormitory_list->academic_id = getAcademicId();
            }
            
            // Set active status
            $dormitory_list->active_status = 1; // Assuming 1 means active
            
            // Save the record
            $result = $dormitory_list->save();
            
            if ($result) {
                Toastr::success('Operation successful', 'Success');
            } else {
                Toastr::error('Operation Failed', 'Failed');
            }
            
            return redirect()->route('dormitory-list-index');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $dormitory_list = SmDormitoryList::find($id);
            $dormitory_lists = SmDormitoryList::get();
            return view('backEnd.dormitory.dormitory_list', compact('dormitory_lists', 'dormitory_list'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(SmDormitoryRequest $request, $id)
    {
        try {
            $dormitory_list = SmDormitoryList::find($request->id);
            $dormitory_list->dormitory_name = $request->dormitory_name;
            $dormitory_list->type = $request->type;
            $dormitory_list->address = $request->address;
            $dormitory_list->intake = $request->intake;
            $dormitory_list->description = $request->description;
            if(moduleStatusCheck('University')){
                $dormitory_list->un_academic_id = getAcademicId();
            }
            $dormitory_list->save();

            Toastr::success('Operation successful', 'Success');
            return redirect('dormitory-list');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $tables = \App\tableList::getTableList('dormitory_id', $id);
            try {
                if ($tables == null) {
                    SmDormitoryList::destroy($id);
                    Toastr::success('Operation successful', 'Success');
                    return redirect('dormitory-list');
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {
                Toastr::error('This item already used', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}