@extends('backEnd.master')
@section('title')
@lang('accommodation.accommodation_rooms')
@endsection

@push('css')
<style>
    .breadcrumb-item a {
        color: #6777ef;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
@endpush
@section('mainContent')

@php  $setting = app('school_info');
 if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } 
@endphp
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accommodation.accommodation_rooms')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accommodation.accommodation')</a>
                <a href="#">@lang('accommodation.accommodation_rooms')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($room_list))
        @if(userPermission("room-list-store"))
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('room-list-index')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>
        @endif
        @endif
        <div class="row">
           
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        @if(isset($room_list))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('room-list-update',$room_list->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'room-list-store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">@if(isset($room_list))
                                        @lang('accommodation.edit_room')
                                    @else
                                        @lang('accommodation.add_room')
                                    @endif
                                 
                                </h3>
                            </div>
                            <div class="add-visitor">
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="primary_input_label" for="">@lang('accommodation.accommodation') <span class="text-danger"> *</span></label>
                                        <select class="primary_select  form-control{{ $errors->has('accommodation') ? ' is-invalid' : '' }}" name="accommodation">
                                            <option data-display="@lang('accommodation.accommodation') *" value="">@lang('accommodation.accommodation') *</option>
                                            @foreach($accommodation_lists as $accommodation_list)
                                                @if(isset($room_list))
                                                <option value="{{@$accommodation_list->id}}" {{@$accommodation_list->id == @$room_list->accommodation_id? 'selected': ''}}>{{@$accommodation_list->dormitory_name}}</option>
                                                @else
                                                <option value="{{@$accommodation_list->id}}" {{old('accommodation') == @$accommodation_list->id? 'selected':''}}>{{@$accommodation_list->dormitory_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('accommodation'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ $errors->first('accommodation') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accommodation.room_number') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($room_list)? $room_list->name: old('name')}}">
                                            <input type="hidden" name="id" value="{{isset($room_list)? $room_list->id: ''}}">
                                            
                                            
                                            @if ($errors->has('name'))
                                            <span class="text-danger" >
                                                {{ $errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <label class="primary_input_label" for="">@lang('common.type') <span class="text-danger"> *</span></label>
                                        <select class="primary_select  form-control{{ $errors->has('room_type') ? ' is-invalid' : '' }}" name="room_type">
                                            <option data-display="@lang('accommodation.room_type') *" value="">@lang('accommodation.select_room_type')</option>
                                            @foreach($room_types as $room_type)
                                                 @if(isset($room_list))
                                                <option value="{{@$room_type->id}}" {{@$room_type->id == @$room_list->room_type_id? 'selected': ''}}>{{ @$room_type->type}}</option>
                                                @else
                                                <option value="{{@$room_type->id}}" {{old('room_type') == @$room_type->id? 'selected':''}}>{{@$room_type->type}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('room_type'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ $errors->first('room_type') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row  mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('dormitory.number_of_bed') <span class="text-danger"> *</span></label>
                                            <input oninput="numberCheck(this)" class="primary_input_field form-control{{ $errors->has('number_of_bed') ? ' is-invalid' : '' }}" type="text" name="number_of_bed" value="{{isset($room_list)? $room_list->number_of_bed: old('number_of_bed')}}">
                                           
                                            
                                            @if ($errors->has('number_of_bed'))
                                        <span class="text-danger" >
                                            {{ $errors->first('number_of_bed') }}
                                        </span>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accommodation.cost_per_bed') ({{ generalSetting()->currency_symbol ?? '$' }}) <span class="text-danger">*</span></label>
                                            <input oninput="numberCheck(this)" class="primary_input_field form-control{{ $errors->has('cost_per_bed') ? ' is-invalid' : '' }}" type="text" step="0.1" name="cost_per_bed" value="{{isset($room_list)? $room_list->cost_per_bed: old('cost_per_bed')}}">
                                            
                                            
                                            @if ($errors->has('cost_per_bed'))
                                        <span class="text-danger" >
                                            {{ $errors->first('cost_per_bed') }}
                                        </span>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.description') <span></span></label>
                                            <textarea class="primary_input_field form-control" cols="0" rows="4" name="description">{{isset($room_list)? $room_list->description: old('description')}}</textarea>
                                          
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center mt-20">
                                        <button class="primary-btn fix-gr-bg">
                                            <span class="ti-check"></span>
                                            @if(isset($room_list))
                                                @lang('common.update')
                                            @else
                                                @lang('accommodation.save_room')
                                            @endif
                                        </button>
                                        <a href="{{ route('room-list-index') }}" class="primary-btn tr-bg ml-2">
                                            <span class="ti-close"></span>
                                            @lang('common.cancel')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15"> @lang('accommodation.accommodation_room_list')</h3>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-12">
                            <x-table>
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
    
                                <thead>
                                    <tr>
                                        <th>@lang('accommodation.room_number')</th>
                                        <th>@lang('accommodation.accommodation')</th>
                                        <th>@lang('accommodation.room_type')</th>
                                        <th>@lang('accommodation.number_of_bed')</th>
                                        <th>@lang('accommodation.cost_per_bed') ({{ generalSetting()->currency_symbol ?? '$' }})</th>
                                        <th>@lang('common.status')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    @php $i=0 @endphp
                                    @foreach($room_lists as $room_list)
                                    <tr>
                                        <td>{{ @$room_list->name }}</td>
                                        <td>{{ @$room_list->accommodation->dormitory_name ?? 'N/A' }}</td>
                                        <td>{{ @$room_list->roomType->type ?? 'N/A' }}</td>
                                        <td class="text-center">{{ @$room_list->number_of_bed ?? '0' }}</td>
                                        <td class="text-right">{{ number_format(@$room_list->cost_per_bed, 2) }}</td>
                                        <td class="text-center">
                                            @if($room_list->active_status == 1)
                                                <span class="badge_1">@lang('common.active')</span>
                                            @else
                                                <span class="badge_2">@lang('common.inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton{{ $loop->index }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @lang('common.action')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton{{ $loop->index }}">
                                                    <a class="dropdown-item" href="{{ route('room-list-edit', $room_list->id) }}">
                                                        <i class="ti-pencil"></i> @lang('common.edit')
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#deleteRoomModal{{ @$room_list->id }}">
                                                        <i class="ti-trash"></i> @lang('common.delete')
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteRoomModal{{ @$room_list->id }}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h4 class="modal-title">@lang('common.delete')</h4>
                                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        <p class="mb-4">@lang('accommodation.room'): <strong>{{ $room_list->name }}</strong></p>
                                                    </div>
                                                    <div class="mt-4 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.cancel')</button>
                                                        {{ Form::open(['route' => ['room-list-delete', $room_list->id], 'method' => 'DELETE', 'class' => 'd-inline']) }}
                                                            <button type="submit" class="btn btn-danger">@lang('common.delete')</button>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@include('backEnd.partials.data_table_js')