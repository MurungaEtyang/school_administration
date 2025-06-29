@extends('backEnd.master')
@section('title')
    @lang('accommodation.accommodation_list')
@endsection

@push('css')
<style>
    .breadcrumb-item a {
        color: #6777ef;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0;
        margin-left: 0;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button a {
        padding: 0.5em 1em;
    }
</style>
@endpush
@section('mainContent')

    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('accommodation.accommodation_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('accommodation.accommodation')</a>
                    <a href="#">@lang('accommodation.accommodation_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($dormitory_list))
                @if (userPermission('dormitory-list-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('dormitory-list-edit', 'new') }}" class="primary-btn small fix-gr-bg">
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
                            @if (isset($dormitory_list))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['dormitory-list-update', $dormitory_list->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                               
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'dormitory-list-store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                               
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($dormitory_list))
                                            @lang('accommodation.edit_accommodation')
                                        @else
                                            @lang('accommodation.add_accommodation')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('accommodation.accommodation_name') <span
                                                        class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('dormitory_name') ? ' is-invalid' : '' }}"
                                                    type="text" name="dormitory_name" autocomplete="off"
                                                    value="{{ isset($dormitory_list) ? $dormitory_list->dormitory_name : old('dormitory_name') }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($dormitory_list) ? $dormitory_list->id : '' }}">
                                                @if ($errors->has('dormitory_name'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('dormitory_name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <label class="primary_input_label" for="">@lang('common.type') <span
                                                    class="text-danger"> *</span></label>
                                            <select
                                                class="primary_select  form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                                name="type">
                                                <option data-display="@lang('common.type') *" value="">
                                                    @lang('common.type') *</option>
                                                @if (isset($dormitory_list))
                                                    <option value="B"
                                                        {{ @$dormitory_list->type == 'B' ? 'selected' : '' }}>
                                                        @lang('dormitory.boys')</option>
                                                    <option value="G"
                                                        {{ @$dormitory_list->type == 'G' ? 'selected' : '' }}>
                                                        @lang('dormitory.girls')</option>
                                                @else
                                                    <option value="B">@lang('dormitory.boys')</option>
                                                    <option value="G">@lang('dormitory.girls')</option>
                                                @endif

                                            </select>
                                            @if ($errors->has('type'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('type') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row  mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('accommodation.address') <span
                                                        class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                    type="text" name="address"
                                                    value="{{ isset($dormitory_list) ? $dormitory_list->address : old('address') }}">
                                                @if ($errors->has('address'))
                                                    <span class="text-danger invalid-select" role="alert">
                                                        {{ $errors->first('address') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('accommodation.intake') <span
                                                        class="text-danger"> *</span></label>
                                                <input oninput="numberCheck(this)"
                                                    class="primary_input_field form-control{{ $errors->has('intake') ? ' is-invalid' : '' }}"
                                                    type="text" name="intake"
                                                    value="{{ isset($dormitory_list) ? $dormitory_list->intake : old('intake') }}">
                                                @if ($errors->has('intake'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('intake') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('common.description')
                                                    <span></span></label>
                                                <textarea class="primary_input_field form-control" cols="0" rows="4" name="description">{{ isset($dormitory_list) ? $dormitory_list->description : old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" type="submit">
                                                <span class="ti-check"></span>
                                                @if (isset($dormitory_list))
                                                    @lang('common.update')
                                                @else
                                                    @lang('accommodation.save_accommodation')
                                                @endif
                                            </button>
                                            <a href="{{ route('dormitory-list-index') }}" class="primary-btn tr-bg ml-2">
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
                                    <h3 class="mb-15"> @lang('accommodation.accommodation_list')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.sl')</th>
                                                <th>@lang('accommodation.accommodation_name')</th>
                                                <th>@lang('accommodation.accommodation_type')</th>
                                                <th>@lang('accommodation.address')</th>
                                                <th>@lang('accommodation.intake')</th>
                                                <th>@lang('common.status')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dormitory_lists as $key => $dormitory_list)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ @$dormitory_list->dormitory_name }}</td>
                                                    <td>{{ @$dormitory_list->type }}</td>
                                                    <td>{{ Str::limit(@$dormitory_list->address, 30) }}</td>
                                                    <td>{{ @$dormitory_list->intake }}</td>
                                                    <td>
                                                        @if(@$dormitory_list->active_status == 1)
                                                            <span class="badge_1">@lang('accommodation.active')</span>
                                                        @else
                                                            <span class="badge_2">@lang('accommodation.inactive')</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <x-drop-down>
                                                            <a class="dropdown-item" href="{{ route('dormitory-list-edit', $dormitory_list->id) }}">
                                                                <i class="ti-pencil-alt"></i> @lang('common.edit')
                                                            </a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteDormitoryListModal{{ @$dormitory_list->id }}">
                                                                <i class="ti-trash"></i> @lang('common.delete')
                                                            </a>
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query" id="deleteDormitoryListModal{{ @$dormitory_list->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h4 class="modal-title">@lang('common.delete_confirmation')</h4>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <i class="ti-alert text-warning" style="font-size: 48px; margin-bottom: 20px;"></i>
                                                                    <h5>@lang('common.are_you_sure_to_delete')</h5>
                                                                    <p class="mb-0">@lang('accommodation.accommodation'): <strong>{{ $dormitory_list->dormitory_name }}</strong></p>
                                                                    <p class="text-danger">@lang('common.this_action_cannot_be_undone')</p>
                                                                </div>
                                                                <div class="mt-4 d-flex justify-content-between">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                        <i class="ti-close"></i> @lang('common.cancel')
                                                                    </button>
                                                                    {{ Form::open(['route' => ['dormitory-list-delete', $dormitory_list->id], 'method' => 'DELETE', 'class' => 'd-inline']) }}
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="ti-trash"></i> @lang('common.delete')
                                                                        </button>
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
