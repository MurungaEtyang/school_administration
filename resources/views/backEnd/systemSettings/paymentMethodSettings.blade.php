@extends('backEnd.master')
@section('title')
    @lang('system_settings.payment_method_settings')
@endsection

@section('mainContent')
    @push('css')
        <style>
            /* your existing styles */
        </style>
    @endpush

    <section class="sms-breadcrumb mb-20">
        <!-- breadcrumb markup -->
    </section>

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row pt-20">
                <!-- LEFT COLUMN: enable gateways -->
                <div class="col-lg-3">
                    @if(userPermission('is-active-payment'))
                        {{ Form::open(['route' => 'is-active-payment', 'class' => 'form-horizontal']) }}
                    @endif
                    <div class="white-box">
                        <h3 class="main-title mb-15">@lang('system_settings.select_a_payment_gateway')</h3>
                        <table class="table">
                            @foreach($paymeny_gateway as $value)
                                @if(!(moduleStatusCheck('RazorPay') == FALSE && $value->method == "RazorPay"))
                                    <tr>
                                        <td class="CustomPaymentMethod">
                                            <div class="primary_input">
                                                <input type="checkbox" id="gateway_{{ $value->method }}" name="gateways[{{ $value->id }}]" class="common-checkbox" value="{{ $value->id }}" {{ $value->active_status == 1 ? 'checked' : '' }}>
                                                <label for="gateway_{{ $value->method }}">{{ $value->method }}</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                        <div class="mt-15 text-center">
                            <button class="primary-btn fix-gr-bg">@lang('common.update')</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>

                <!-- RIGHT COLUMN: gateway settings tabs -->
                <div class="col-lg-9">
                    <div class="white-box">
                        <h3 class="main-title pt-10">@lang('system_settings.gateway_setting')</h3>
                        <ul class="nav nav-tabs my-2">
                            @foreach($paymeny_gateway_settings as $row)
                                @if(!(moduleStatusCheck('RazorPay') == FALSE && $row->gateway_name == "RazorPay"))
                                    <li class="nav-item">
                                        <a class="nav-link {{ $row->gateway_name == 'PayPal' ? 'active show' : '' }}" href="#{{ $row->gateway_name }}" data-toggle="tab">{{ $row->gateway_name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @php $forServiceCharge = ['service_charge', 'charge']; @endphp
                            @foreach($paymeny_gateway_settings as $row)
                                <div class="tab-pane fade {{ $row->gateway_name == 'PayPal' ? 'active show' : '' }}" id="{{ $row->gateway_name }}">
                                    @if(userPermission('update-payment-gateway'))
                                        <form action="{{ route('update-payment-gateway') }}" method="POST" class="form-horizontal">
                                            @csrf
                                            <input type="hidden" name="gateway_name" value="{{ $row->gateway_name }}">
                                            @endif

                                            <div class="row mb-15"><div class="col-md-12">
    @php
        $count = 0;
        if($row->gateway_name == "PayPal") {
            $paymeny_gateway = ['gateway_name','gateway_username','gateway_password','gateway_signature','gateway_client_id','gateway_mode','gateway_secret_key','service_charge','charge'];
        }
        else if($row->gateway_name == "M-PESA") {
            $paymeny_gateway = ['gateway_name','gateway_client_id','gateway_secret_key','gateway_signature','gateway_mode','short_code','stk_push_url','service_charge','charge'];
        }
        else if($row->gateway_name == "Stripe") {
            $paymeny_gateway = ['gateway_name','gateway_username','gateway_secret_key','gateway_publisher_key','service_charge','charge'];
        }
        // ... other existing gateways ...
        else if($row->gateway_name == "Cheque") {
            $paymeny_gateway = ['gateway_name','cheque_details'];
        }
    @endphp

    @foreach($paymeny_gateway as $input_field)
        @php
            $newStr = $input_field;
            $label_name = str_replace('_', ' ', $newStr);
            // M-PESA label override
            if($row->gateway_name == 'M-PESA') {
                $map = [
                    'gateway_client_id' => 'Consumer Key',
                    'gateway_secret_key' => 'Consumer Secret',
                    'gateway_signature' => 'Passkey',
                    'gateway_mode' => 'Environment (sandbox/live)',
                    'short_code' => 'Short Code',
                    'stk_push_url' => 'STK Push Endpoint'
                ];
                if(isset($map[$input_field])) {
                    $label_name = $map[$input_field];
                }
            }
            $value = $row->$input_field;
        @endphp
                                                        @if(!in_array($input_field, $forServiceCharge))
                                                            <div class="row mb-15">
                                                                <div class="col-lg-12">
                                                                    <label>{{ $label_name }}
                                                                        @if($input_field == 'gateway_mode') <small>(sandbox or live)</small> @endif
                                                                    </label>
                                                                    <input type="text" name="{{ $input_field }}" class="form-control" value="{{ $value }}" {{ $count == 0 ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($input_field == 'service_charge')
                                                            @php $d_none = $row->service_charge == 0 ? 'd-none' : ''; @endphp
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <input type="checkbox" id="service_charge_{{ $row->gateway_name }}" name="service_charge" class="common-checkbox service_charge" data-gateway_name="{{ $row->gateway_name }}" {{ $row->service_charge == 1 ? 'checked' : '' }}>
                                                                    <label for="service_charge_{{ $row->gateway_name }}">@lang('common.service_charge')</label>
                                                                </div>
                                                            </div>
                                                            <div class="row {{ $d_none }}" id="charge_type_{{ $row->gateway_name }}">
                                                                <div class="col-lg-6">
                                                                    <input type="radio" name="charge_type" value="P" class="common-radio type_{{ $row->gateway_name }}" {{ $row->charge_type == 'P' ? 'checked' : '' }}> @lang('common.Percentage')
                                                                    <input type="radio" name="charge_type" value="F" class="common-radio type_{{ $row->gateway_name }}" {{ $row->charge_type == 'F' ? 'checked' : '' }}> @lang('common.Flat')
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="number" name="charge" class="form-control chargeValue" data-gateway_name="{{ $row->gateway_name }}" value="{{ $row->charge }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @php $count++; @endphp
                                                    @endforeach
                                                </div></div>

                                            <div class="row">
                                                <div class="col-md-7 text-center">
                                                    @if(!empty($row->logo))
                                                        <img src="{{ asset($row->logo) }}" style="height:100px">
                                                    @endif
                                                </div>
                                            </div>

                                            @if($row->gateway_name != 'Bank')
                                                <div class="row mt-40"><div class="col-lg-12 text-center">
                                                        <button class="primary-btn fix-gr-bg">@lang('common.update')</button>
                                                    </div></div>
                                            @endif

                                            @if(userPermission('update-payment-gateway'))
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).on('click', '.service_charge', function(){
            let gn = $(this).data('gateway_name');
            $('#charge_type_'+gn).toggleClass('d-none', !this.checked);
        });

        $(document).on('keyup', '.chargeValue', function(){
            let gn = $(this).data('gateway_name');
            let type = $("input.type_" + gn + ":checked").val();
            let val = parseFloat($(this).val());
            if(type == 'P' && val > 100) {
                toastr.error("@lang('common.percentage_max_error')");
                $(this).val('');
            }
        });
    </script>
@endpush
