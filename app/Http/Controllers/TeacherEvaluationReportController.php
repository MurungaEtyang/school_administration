<?php

namespace App\Http\Controllers;

use App\SmClass;
use App\SmStaff;
use App\SmAssignSubject;
use Illuminate\Http\Request;
use App\Models\LecturerEvaluation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherEvaluationReportController extends Controller
{
    public function getAssignSubjectTeacher(Request $request)
    {
        try {
            $staffs = SmAssignSubject::where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->whereIn('section_id', $request->section_ids)
                ->with('teacher')
                ->select('teacher_id as lecturer_id') // Rename teacher_id to lecturer_id in the response
                ->distinct('teacher_id')
                ->get();
                
            return response()->json($staffs);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch lecturers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function lecturerApprovedEvaluationReport()
    {
        try {
            $classes = SmClass::get();
            $lecturerEvaluations = LecturerEvaluation::with('studentRecord.studentDetail.parents', 'staff')->get();
            return view('backEnd.teacherEvaluation.report.lecturer_approved_evaluation_report', compact('classes', 'lecturerEvaluations'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function lecturerPendingEvaluationReport()
    {
        $classes = SmClass::get();
        $lecturerEvaluations = LecturerEvaluation::where('status', 0)->with('studentRecord.studentDetail.parents', 'staff')->get();
        return view('backEnd.teacherEvaluation.report.lecturer_pending_evaluation_report', compact('classes', 'lecturerEvaluations'));
    }
    
    public function lecturerWiseEvaluationReport()
    {
        try {
            $classes = SmClass::get();
            $lecturers = SmStaff::where('role_id', 4)->get();
            $lecturerEvaluations = LecturerEvaluation::with(['studentRecord.studentDetail.parents', 'staff'])
                ->get();
                
            return view('backEnd.teacherEvaluation.report.lecturer_wise_evaluation_report', 
                compact('classes', 'lecturerEvaluations', 'lecturers'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed: ' . $e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }
    
    public function lecturerApprovedEvaluationReportSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class_id' => "required",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $classes = SmClass::get();
            $staffs = SmAssignSubject::where('class_id', $request->class_id)
                ->when($request->subject_id, function ($query) use ($request) {
                    $query->where('subject_id', $request->subject_id);
                })
                ->when($request->section_id, function ($query) use ($request) {
                    $query->whereIn('section_id', [$request->section_id]);
                })
                ->when($request->lecturer_id, function ($query) use ($request) {
                    $query->where('lecturer_id', $request->lecturer_id);
                })->get();

            $lecturerEvaluations = LecturerEvaluation::when($request->class_id, function ($q) use ($request) {
                $q->whereHas('studentRecord', function ($query) use ($request) {
                    $query->where('class_id', $request->class_id);
                });
            })
                ->when($request->subject_id, function ($q) use ($request) {
                    $q->where('subject_id', $request->subject_id);
                })
                ->when($request->section_id, function ($q) use ($request) {
                    $q->whereHas('studentRecord', function ($query) use ($request) {
                        $query->where('section_id', $request->section_id);
                    });
                })
                ->when($request->lecturer_id, function ($q) use ($staffs) {
                    foreach ($staffs as $staff) {
                        $q->where('lecturer_id', $staff->lecturer_id);
                    }
                })
                ->when($request->submitted_by, function ($q) use ($request) {
                    $q->where('role_id', $request->submitted_by);
                })
                ->with('studentRecord.studentDetail.parents', 'staff')->get();

            return view('backEnd.teacherEvaluation.report.lecturer_approved_evaluation_report', compact('classes', 'lecturerEvaluations'));
        } catch (\Exception $e) {
           
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function lecturerPendingEvaluationReportSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class_id' => "required",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $classes = SmClass::get();
            $staffs = SmAssignSubject::where('class_id', $request->class_id)
                ->when($request->subject_id, function ($query) use ($request) {
                    $query->where('subject_id', $request->subject_id);
                })
                ->when($request->section_id, function ($query) use ($request) {
                    $query->whereIn('section_id', [$request->section_id]);
                })
                ->when($request->lecturer_id, function ($query) use ($request) {
                    $query->where('lecturer_id', $request->lecturer_id);
                })->get();

            $lecturerEvaluations = LecturerEvaluation::when($request->class_id, function ($q) use ($request) {
                $q->whereHas('studentRecord', function ($query) use ($request) {
                    $query->where('class_id', $request->class_id);
                });
            })
                ->when($request->subject_id, function ($q) use ($request) {
                    $q->where('subject_id', $request->subject_id);
                })
                ->when($request->section_id, function ($q) use ($request) {
                    $q->whereHas('studentRecord', function ($query) use ($request) {
                        $query->where('section_id', $request->section_id);
                    });
                })
                ->when($request->lecturer_id, function ($q) use ($staffs) {
                    foreach ($staffs as $staff) {
                        $q->where('lecturer_id', $staff->lecturer_id);
                    }
                })
                ->when($request->submitted_by, function ($q) use ($request) {
                    $q->where('role_id', $request->submitted_by);
                })
                ->with('studentRecord.studentDetail.parents', 'lecturer')->get();

            return view('backEnd.teacherEvaluation.report.lecturer_pending_evaluation_report', compact('classes', 'lecturerEvaluations'));
        } catch (\Exception $e) {
         
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function lecturerWiseEvaluationReportSearch(Request $request)
    {
        try {
            $classes = SmClass::get();
            $lecturers = SmStaff::where('role_id', 4)->get();
            
            $lecturerEvaluations = LecturerEvaluation::query()
                ->when($request->lecturer_id, function($query) use ($request) {
                    return $query->where('lecturer_id', $request->lecturer_id);
                })
                ->when($request->submitted_by, function($query) use ($request) {
                    return $query->where('role_id', $request->submitted_by);
                })
                ->with(['studentRecord.studentDetail.parents', 'staff'])
                ->get();
                
            return view('backEnd.teacherEvaluation.report.lecturer_wise_evaluation_report', 
                compact('classes', 'lecturerEvaluations', 'lecturers'));
                
        } catch (\Exception $e) {
            Toastr::error('Operation Failed: ' . $e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }
    
    public function lecturerEvaluationApproveSubmit($id)
    {
        try {
            $lecturerEvaluation = LecturerEvaluation::find($id);
            $lecturerEvaluation->status = 1;
            $lecturerEvaluation->update();
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function lecturerEvaluationApproveDelete($id)
    {
        try {
            $lecturerEvaluation = LecturerEvaluation::find($id);
            $lecturerEvaluation->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function lecturerPanelEvaluationReport()
    {
        try {
            $staffId = SmStaff::where('user_id', auth()->user()->id)->select('id')->first();
            $lecturerEvaluations = LecturerEvaluation::where('lecturer_id', $staffId->id)
                ->with('studentRecord')
                ->get();
                
            return view('backEnd.teacherEvaluation.report.lecturer_panel_evaluation_report', compact('lecturerEvaluations'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed: ' . $e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }
}
