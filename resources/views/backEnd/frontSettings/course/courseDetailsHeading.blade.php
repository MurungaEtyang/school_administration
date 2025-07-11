@extends('backEnd.master')
@section('title')
@lang('front_settings.update_course_details_heading_section')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('front_settings.course_details_heading')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('front_settings.front_settings')</a>
                    <a href="#"> @lang('front_settings.course_details_heading')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'course-details-heading-update',
                                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @lang('front_settings.update_course_details_heading')
                                         
                                    </h3>
                                </div> 
                                <div class="add-visitor {{isset($update)? '':'isDisabled'}}">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="primary_input">
                                                <label> @lang('front_settings.title')<span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field "
                                                    type="text" name="title" autocomplete="off"
                                                    value="{{isset($update)? ($SmCoursePage != ''? $SmCoursePage->title:''):''}}">
                                              
                                                
                                                @if ($errors->has('title'))
                                                    <span class="text-danger" >
                                                    {{ $errors->first('title') }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="primary_input mt-25">
                                                <div class="primary_input">
                                                    <label> @lang('common.description') <span class="text-danger"> *</span> </label>
                                                    <textarea class="primary_input_field form-control" cols="0" rows="5" name="description" id="description">{{isset($update)? ($SmCoursePage != ''? $SmCoursePage->description:''):'' }}</textarea>
                                                    
                                                    @if($errors->has('description'))
                                                        <span class="text-danger" >
                                                        {{ $errors->first('description') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="primary_input mt-25">
                                                <label> @lang('front_settings.button_text')<span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('button_text') ? ' is-invalid' : '' }}"
                                                    type="text" name="button_text" autocomplete="off"
                                                    value="{{isset($update)? ($SmCoursePage != ''? $SmCoursePage->button_text:''):'' }}">
                                               
                                                
                                                @if ($errors->has('button_text'))
                                                    <span class="text-danger" >
                                                    {{ $errors->first('button_text') }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="primary_input mt-25">
                                                <label> @lang('front_settings.button_url')<span class="text-danger"> *</span></label>
                                                
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('button_text') ? ' is-invalid' : '' }}"
                                                    type="text" name="button_url" autocomplete="off"
                                                    value="{{isset($update)? ($SmCoursePage != ''? $SmCoursePage->button_url:''):'' }}">
                                               
                                                @if ($errors->has('button_url'))
                                                    <span class="text-danger" >
                                                    {{ $errors->first('button_url') }}
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        
                                        <div class="col-lg-12 mt-15">
                                            <div class="primary_input">
                                                <div class="primary_file_uploader">
                                                    <input class="primary_input_field form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" id="placeholderInput" type="text"
                                                       placeholder="{{isset($update)? ($SmCoursePage and $SmCoursePage->image !="") ? getFilePath3($SmCoursePage->image) :trans('front_settings.image') .' *' :trans('front_settings.image') .' *' }}"
                                                       readonly>
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg" for="browseFile">{{ __('common.browse') }}</label>
                                                        <input type="file" class="d-none" name="image" id="browseFile">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <span class="mt-10"> @lang('front_settings.image')(1420px*450px)</span>
                                    @php 
                                        $tooltip = "";
                                        
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{@$tooltip}}">
                                                <span class="ti-check"></span>
                                                @if(isset($update))
                                                    @lang('front_settings.update')
                                                @else
                                                    @lang('front_settings.save')
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
 
            </div>
        </div>
    </section>


    <div class="modal fade admin-query" id="showimageModal">
        <div class="modal-dialog modal-dialog-centered large-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('front_settings.course_details')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body p-0">
                    <div class="container student-certificate">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 text-center">
                                <div class="mt-20">
                                    <section class="container box-1420">
                                        <div class="banner-area" style="background: linear-gradient(0deg, rgba(50, 146, 255, 0.6), rgba(56, 187, 216, 0.6)), url({{@$SmCoursePage->image != ""? @$SmCoursePage->image : '../img/client/common-banner1.jpg'}}) no-repeat center;background-size: 100%">
                                            <div class="banner-inner">
                                                <div class="banner-content">
                                                    <h2 style="color: whitesmoke">{{@$SmCoursePage->title}}</h2>
                                                    <p style="color: whitesmoke">{{@$SmCoursePage->description}}</p>
                                                    <a class="primary-btn fix-gr-bg semi-large" href="{{@$SmCoursePage->button_url}}">{{@$SmCoursePage->button_text}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <div class="mt-10 row">
                                        <div class="col-md-6">
                                            <div class="academic-item">
                                                <div class="academic-img">
                                                    <img class="img-fluid" src="{{asset(@$SmCoursePage->main_image)}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="academic-text mt-30">
                                                <h4>
                                                    {{@$SmCoursePage->main_title}}
                                                </h4>
                                                <p>
                                                    {{@$SmCoursePage->main_description}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection