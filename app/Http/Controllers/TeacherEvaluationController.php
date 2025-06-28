<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LecturerEvaluation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\LecturerEvaluationSetting;
use Illuminate\Support\Facades\Validator;

class TeacherEvaluationController extends Controller
{
    public function lecturerEvaluationSetting()
    {
        $lecturerEvaluationSetting = LecturerEvaluationSetting::where('id', 1)->first();
        return view('backEnd.teacherEvaluation.setting.lecturerEvaluationSetting', compact('lecturerEvaluationSetting'));
    }
    
    public function lecturerEvaluationSettingUpdate(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'endDate' => 'after:startDate',
        ]);
        if ($validator->fails()) {
            Toastr::error('End Date cannot be before Start Date', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $lecturerEvaluationSetting = LecturerEvaluationSetting::find(1);
            if ($request->type == 'evaluation') {
                $lecturerEvaluationSetting->is_enable = $request->is_enable;
                $lecturerEvaluationSetting->auto_approval = $request->auto_approval;
            }
            if ($request->type == 'submission') {
                $lecturerEvaluationSetting->submitted_by = $request->submitted_by ? $request->submitted_by : $lecturerEvaluationSetting->submitted_by;
                $lecturerEvaluationSetting->rating_submission_time = $request->rating_submission_time;
                $lecturerEvaluationSetting->from_date = date('Y-m-d', strtotime($request->startDate));
                $lecturerEvaluationSetting->to_date = date('Y-m-d', strtotime($request->endDate));
            }
            $lecturerEvaluationSetting->update();
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function lecturerEvaluationSubmit(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'rating' => "required",
            'comment' => "required",
        ]);
        if ($validator->fails()) {
            Toastr::error('Empty Submission', 'Failed');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $lecturerEvaluationSetting = LecturerEvaluationSetting::find(1);
            $lecturerEvaluation = new LecturerEvaluation();
            $lecturerEvaluation->rating = $request->rating;
            $lecturerEvaluation->comment = $request->comment;
            $lecturerEvaluation->record_id = $request->record_id;
            $lecturerEvaluation->subject_id = $request->subject_id;
            $lecturerEvaluation->lecturer_id = $request->lecturer_id;
            $lecturerEvaluation->student_id = $request->student_id;
            $lecturerEvaluation->parent_id = $request->parent_id;
            $lecturerEvaluation->role_id = Auth::user()->role_id;
            $lecturerEvaluation->academic_id = getAcademicId();
            if ($lecturerEvaluationSetting->auto_approval == 0) {
                $lecturerEvaluation->status = 1;
            }
            $lecturerEvaluation->save();
            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
