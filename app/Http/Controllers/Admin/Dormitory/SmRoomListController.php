<?php

namespace App\Http\Controllers\Admin\Dormitory;
use App\SmStudent;
use App\SmRoomList;
use App\SmRoomType;
use App\SmDormitoryList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Dormitory\SmDormitoryRoomRequest;

class SmRoomListController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
	}

    public function index(Request $request)
    {
        try{
            // Get all room lists with their relationships
            $room_lists = SmRoomList::with(['accommodation', 'roomType'])
                ->where('school_id', Auth::user()->school_id)
                ->get();
                
            // Log the room lists data for debugging
            \Log::info('Room Lists Data:', [
                'count' => $room_lists->count(),
                'data' => $room_lists->toArray()
            ]);
            
            // Get room types
            $room_types = SmRoomType::where('school_id', Auth::user()->school_id)
                ->get();
                
            // Get accommodation lists
            $accommodation_lists = SmDormitoryList::where('school_id', Auth::user()->school_id)
                ->orderBy('id', 'DESC')
                ->get();
                
            // Log the accommodation lists data
            \Log::info('Accommodation Lists:', [
                'count' => $accommodation_lists->count(),
                'data' => $accommodation_lists->toArray()
            ]);
                
            return view('backEnd.dormitory.room_list', compact('room_lists', 'room_types', 'accommodation_lists'));
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }
    public function store(SmDormitoryRoomRequest $request)
    {
        try{
            // Log the incoming request data
            \Log::info('Store Room Request:', $request->all());
            
            // Create new room
            $room_list = new SmRoomList();
            $room_list->name = $request->name;
            $room_list->accommodation_id = $request->accommodation;
            $room_list->room_type_id = $request->room_type;
            $room_list->number_of_bed = $request->number_of_bed;
            $room_list->cost_per_bed = $request->cost_per_bed;
            $room_list->description = $request->description;
            $room_list->school_id = Auth::user()->school_id;
            $room_list->active_status = 1;
            
            // Set academic ID based on university module
            if(moduleStatusCheck('University')){
                $room_list->un_academic_id = getAcademicId();
            } else {
                $room_list->academic_id = getAcademicId();
            }
            
            // Save the room
            $room_list->save();
            
            // Log successful creation
            \Log::info('Room created successfully:', [
                'id' => $room_list->id,
                'name' => $room_list->name,
                'accommodation_id' => $room_list->accommodation_id
            ]);

            Toastr::success('Room added successfully', 'Success');
            return redirect()->route('room-list-index');
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        try{
            // Get the room to edit with its relationships
            $room_list = SmRoomList::with(['accommodation', 'roomType'])
                ->where('school_id', Auth::user()->school_id)
                ->findOrFail($id);
                
            // Get all rooms for the list
            $room_lists = SmRoomList::with(['accommodation', 'roomType'])
                ->where('school_id', Auth::user()->school_id)
                ->get();
                
            // Get room types and accommodations
            $room_types = SmRoomType::where('school_id', Auth::user()->school_id)
                ->get();
                
            $accommodation_lists = SmDormitoryList::where('school_id', Auth::user()->school_id)
                ->orderBy('dormitory_name', 'ASC')
                ->get();
                
            // Log the data being passed to the view
            \Log::info('Edit Room Data:', [
                'room' => $room_list->toArray(),
                'room_types_count' => $room_types->count(),
                'accommodations_count' => $accommodation_lists->count()
            ]);
                
            return view('backEnd.dormitory.room_list', compact('room_lists', 'room_list', 'room_types', 'accommodation_lists'));
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function update(SmDormitoryRoomRequest $request, $id)
    {
        try {
            // Log the incoming request data
            \Log::info('Update Room Request:', $request->all());
            
            // Find the room to update
            $room_list = SmRoomList::where('school_id', Auth::user()->school_id)
                ->findOrFail($request->id);
                
            // Update room details
            $room_list->name = $request->name;
            $room_list->accommodation_id = $request->accommodation;
            $room_list->room_type_id = $request->room_type;
            $room_list->number_of_bed = $request->number_of_bed;
            $room_list->cost_per_bed = $request->cost_per_bed;
            $room_list->description = $request->description;
            $room_list->active_status = $request->active_status ?? 1;
            
            // Set academic ID based on university module
            if(moduleStatusCheck('University')) {
                $room_list->un_academic_id = getAcademicId();
            } else {
                $room_list->academic_id = getAcademicId();
            }
            
            // Save the updated room
            $room_list->save();
            
            // Log successful update
            \Log::info('Room updated successfully:', [
                'id' => $room_list->id,
                'name' => $room_list->name,
                'accommodation_id' => $room_list->accommodation_id
            ]);

            Toastr::success('Room updated successfully', 'Success');
            return redirect()->route('room-list-index');
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
            $key_id = 'room_id';
            $tables = SmStudent::where('dormitory_id',$id)->first();
            try {
                if ($tables==null) {
                    SmRoomList::destroy($id);

                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                } else {
                    $msg = 'This data already used in Student Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }
}