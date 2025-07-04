@push('css')
    <link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}"/>
    <style>
        .school-table-style tr th {
            padding: 10px 18px 10px 10px !important;
        }
        .school-table-style tr td {
            padding: 20px 10px 20px 10px !important;
        }
        
        /* M-PESA Payment Styles */
        #mpesaStatus .alert {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-radius: 4px;
            font-size: 14px;
        }
        #mpesaStatus .alert i {
            margin-right: 8px;
        }
        #mpesaLoading {
            background-color: #e7f4ff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        #mpesaSuccess {
            background-color: #e8f5e9;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        #mpesaError {
            background-color: #fde8e8;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
@endpush

<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees::feesModule.add_fees_payment')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees::feesModule.fees')</a>
                @if (isset($role) && $role =='admin')
                    <a href="{{route('fees.fees-invoice-list')}}">@lang('fees::feesModule.fees_invoice')</a>
                @elseif(isset($role) && $role =='student')
                    <a href="#">@lang('fees::feesModule.fees_invoice')</a>
                @endif
                <a href="#">@lang('fees::feesModule.add_fees_payment')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor student-details">
    <div class="container-fluid p-0">
        @if (isset($role) && $role =='admin')
            {{ Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => 'fees.fees-payment-store', 'enctype' => 'multipart/form-data']) }}
            <input type="hidden" name="record_id" value="{{$invoiceInfo->recordDetail->id}}">
        @else
            {{ Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => 'fees.student-fees-payment-store', 'id'=>'addFeesPayment','enctype' => 'multipart/form-data']) }}
            @if (isset(Auth::user()->wallet_balance))
                <input type="hidden" name="wallet_balance"
                       value="{{(Auth::user()->wallet_balance != null) ? Auth::user()->wallet_balance:""}}">
            @endif
        @endif
        <div class="row">
            <div class="col-lg-3">
                <div class="main-title">
                    <h3 class="mb-30">@lang('student.student_details')</h3>
                </div>


                <div class="student-meta-box">
                    <div class="student-meta-top"></div>
                    <img class="student-meta-img img-100"
                         src="{{($invoiceInfo->studentInfo->student_photo)? $invoiceInfo->studentInfo->student_photo : asset('public/uploads/staff/demo/staff.jpg')}}"
                         alt="">
                    <div class="white-box radius-t-y-0">
                        <div class="single-meta mt-50">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('student.student_name')</div>
                                <div class="value">{{$invoiceInfo->studentInfo->full_name}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('student.admission_number')</div>
                                <div class="value">{{$invoiceInfo->studentInfo->admission_no}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('student.roll_number')</div>
                                <div class="value">{{$invoiceInfo->recordDetail->roll_no}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('common.class')</div>
                                <div class="value">{{$invoiceInfo->recordDetail->class->class_name}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name"> @lang('common.section')</div>
                                <div class="value">{{$invoiceInfo->recordDetail->section->section_name}}</div>
                            </div>
                        </div>
                        @if (isset($role) && $role =='admin')
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">@lang('wallet::wallet.wallet_balance')</div>
                                    <div class="value">
                                       {{currency_format(@$invoiceInfo->studentInfo->user->wallet_balance)}}
                                    </div>
                                </div>
                            </div>
                        @else
                            @if (isset(Auth::user()->id))
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">@lang('wallet::wallet.wallet_balance')</div>
                                        <div class="value">
                                            {{(Auth::user()->wallet_balance != null) ? currency_format(Auth::user()->wallet_balance): currency_format(0.00)}}
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="wallet_balance"
                                       value="{{(Auth::user()->wallet_balance != null) ? Auth::user()->wallet_balance:""}}">
                            @endif
                        @endif
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('wallet::wallet.add_in_wallet')</div>
                                <div class="value">
                                    <span class="add_wallet">{{ currency_format(0.00) }}</span>
                                    <input type="hidden" id="currencySymbol"
                                           value="{{generalSetting()->currency_symbol}}">
                                    <input type="hidden" name="add_wallet" id="addWallet" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-25">
                            <div class="col-lg-12">
                                <select class="primary_select  form-control{{ $errors->has('payment_method') ? ' is-invalid' : '' }}"
                                        name="payment_method" id="paymentMethodAddFees">
                                    <option data-display="@lang('accounts.payment_method')*"
                                            value="">@lang('accounts.payment_method')*
                                    </option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{$paymentMethod->method}}" {{old('payment_method') == $paymentMethod->method ? 'selected' : ''}}>{{$paymentMethod->method}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('payment_method'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ $errors->first('payment_method') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-25 d-none" id="bankPaymentAddFees">
                            <div class="col-lg-12">
                                <select class="primary_select  form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}"
                                        name="bank">
                                    <option data-display="@lang('fees::feesModule.select_bank')*"
                                            value="">@lang('fees::feesModule.select_bank')*
                                    </option>
                                    @foreach ($bankAccounts as $bankAccount)
                                        <option value="{{$bankAccount->id}}" {{old('bank') == $bankAccount->id ? 'selected' : ''}}>{{$bankAccount->bank_name}}
                                            ({{$bankAccount->account_number}})
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('bank'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ $errors->first('bank') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-25 chequeBank d-none">
                            <div class="col-lg-12">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('common.note') <span></span> </label>
                                    <textarea class="primary_input_field form-control" cols="0" rows="3" name="payment_note"
                                              id="note">{{old('payment_note')}}</textarea>


                                </div>
                            </div>
                        </div>

                        <div class="row chequeBank d-none">
                            <div class="col-lg-12">
                                <div class="primary_input">
                                    <label class="primary_input_label"
                                        for="">{{ trans('common.file') }}</label>
                                    <div class="primary_file_uploader">
                                        <input class="primary_input_field form-control {{ $errors->has('file') ? ' is-invalid' : '' }}"
                                        readonly="true" type="text"
                                        placeholder="{{isset($editData->upload_file) && @$editData->upload_file != ""? getFilePath3(@$editData->upload_file):trans('common.file').''}}"
                                        id="placeholderUploadContent">

                                 @if ($errors->has('file'))
                                     <span class="text-danger mb-20" role="alert">
                                         {{ $errors->first('file') }}
                                     </span>
                                 @endif
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="upload_content_file"><span
                                                    class="ripple rippleEffect"
                                                    style="width: 56.8125px; height: 56.8125px; top: -16.4062px; left: 10.4219px;"></span>@lang('common.browse')</label>
                                                    <input type="file" class="d-none form-control" name="file" id="upload_content_file">
                                        </button>
                                    </div>
                                    <code>(JPG, JPEG, PNG, PDF are allowed for upload)</code>
                                    @if ($errors->has('upload_event_image'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('upload_event_image') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>


                        <div class="stripPayment d-none">
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.name_on_card') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control{{ $errors->has('name_on_card') ? ' is-invalid' : '' }}"
                                               type="text" name="name_on_card" autocomplete="off"
                                               value="{{old('name_on_card')}}">


                                        @if ($errors->has('name_on_card'))
                                            <span class="text-danger"
                                                  role="alert"> {{ $errors->first('name_on_card') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.card_number') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control{{ $errors->has('card-number') ? ' is-invalid' : '' }} card-number"
                                               type="text" name="card-number" autocomplete="off"
                                               value="{{old('card-number')}}">


                                        @if ($errors->has('card-number'))
                                            <span class="text-danger"
                                                  role="alert"> {{ $errors->first('card-number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.cvc') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control card-cvc" type="text" name="card-cvc"
                                               autocomplete="off" value="{{old('card-cvc')}}">


                                        @if ($errors->has('card-cvc'))
                                            <span class="text-danger"
                                                  role="alert"> {{ $errors->first('card-cvc') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.expiration_month') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control card-expiry-month" type="text"
                                               name="card-expiry-month" autocomplete="off"
                                               value="{{old('card-expiry-month')}}">


                                        @if ($errors->has('card-expiry-month'))
                                            <span class="text-danger"
                                                  role="alert"> {{ $errors->first('card-expiry-month') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.expiration_year') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control card-expiry-year" type="text"
                                               name="card-expiry-year" autocomplete="off"
                                               value="{{old('card-expiry-year')}}">
                                        @if ($errors->has('card-expiry-year'))
                                            <span class="text-danger"
                                                  role="alert"> {{ $errors->first('card-expiry-year') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- M-PESA Payment Input -->
                        <div class="mpesaPayment d-none">
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="mpesa_phone">@lang('fees::feesModule.phone_number') <span class="text-danger">*</span></label>
                                        <input class="primary_input_field form-control" type="text" 
                                               name="mpesa_phone" id="mpesa_phone" 
                                               placeholder="07XXXXXXXX" 
                                               required>
                                        <small class="text-muted">Enter your M-PESA registered phone number (e.g., 0712345678)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (moduleStatusCheck('MercadoPago') == true)
                            @include('mercadopago::form.userForm',['student_id' => $invoiceInfo->recordDetail->id, 'invoice_id' => $invoiceInfo->id,'fees'=>true])
                        @endif
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg submit fmInvoice" data-toggle="tooltip">
                                    <span class="ti-check"></span>
                                    @lang('inventory.add_payment')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('fees::feesModule.fees_type_list')</h3>
                        </div>
                    </div>
                </div>
                <div class="white-box mt-4">
                    <div class="row">
                        <div class="col-lg-12">

                            <input type="hidden" class="weaverType" value="amount">
                            <div class="big-table">
                                <h4 class="text-danger" id="serviceChargeTitle"></h4>
                                <span id="payable_amount"></span>
                                <table class="table school-table-style p-0" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('fees::feesModule.fees_type')</th>
                                        <th>@lang('accounts.amount')</th>
                                        <th>@lang('fees::feesModule.due')</th>
                                        <th>@lang('fees::feesModule.paid_amount')</th>
                                        <th>@lang('exam.waiver')</th>
                                        <th>@lang('fees::feesModule.fine')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($invoiceInfo))
                                        <input type="hidden" name="invoice_id" value="{{$invoiceInfo->id}}">
                                        <input type="hidden" class="weaverType" value="amount">
                                        <input type="hidden" name="student_id" value="{{$invoiceInfo->recordDetail->id}}">
                                        @foreach ($invoiceDetails as $key=>$invoiceDetail)
                                            <tr>
                                                <td></td>
                                                <input type="hidden" name="fees_type[]"
                                                    value="{{$invoiceDetail->fees_type}}">
                                                <td>{{@$invoiceDetail->feesType->name}}</td>
                                                <td>
                                                    <div class="primary_input">
                                                        <input class="primary_input_field border-0 form-control addFeesAmount{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                                            type="text" name="amount[]" autocomplete="off"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->amount: old('amount')}}"
                                                            readonly>

                                                        @if ($errors->has('amount'))
                                                            <span class="text-danger" >
                                                                {{ $errors->first('amount') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="primary_input">
                                                        <input class="primary_input_field border-0 form-control showTotalValue"
                                                            type="text" name="due[]"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->due_amount:""}}"
                                                            autocomplete="off" readonly>
                                                        <input class="dueAmount" type="hidden"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->due_amount:0}}">
                                                        <input class="extraAmount" type="hidden" name="extraAmount[]"
                                                            value="0">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="primary_input_field form-control addFeesPaidAmount" type="text"
                                                        name="paid_amount[]" autocomplete="off">
                                                </td>
                                                <td>
                                                    @if (isset($role) && $role == 'admin')
                                                        <div class="primary_input">
                                                            <input class="primary_input_field form-control addFeesWeaver"
                                                                type="text" name="weaver[]" autocomplete="off"
                                                                value="{{isset($invoiceDetail)? $invoiceDetail->weaver: old('weaver')}}">
                                                            <input class="previousWeaver" type="hidden"
                                                                value="{{isset($invoiceDetail)? $invoiceDetail->weaver: ''}}">

                                                        </div>
                                                    @else
                                                        <input class="primary_input_field border-0 form-control"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->weaver:0}}"
                                                            autocomplete="off" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($role) && $role == 'admin')
                                                        <input class="primary_input_field form-control addFeesFine" type="text"
                                                            name="fine[]" autocomplete="off" value="0">
                                                    @else
                                                        <input class="primary_input_field border-0 form-control"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->fine:0}}"
                                                            autocomplete="off" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="primary-btn icon-only fix-gr-bg" data-toggle="modal"
                                                            data-tooltip="tooltip"
                                                            data-target="#addNotesModal{{$invoiceDetail->fees_type}}"
                                                            type="button"
                                                            data-placement="top" title="@lang('common.add_note')">
                                                        <span class="ti-pencil-alt"></span>
                                                    </button>
                                                </td>
                                                {{-- Notes Modal Start --}}
                                                <div class="modal fade admin-query"
                                                    id="addNotesModal{{$invoiceDetail->fees_type}}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('common.add_note')</h4>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    &times;
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="primary_input">
                                                                    <label class="primary_input_label" for="">@lang('common.note')</label>
                                                                    <input class="primary_input_field form-control has-content" type="text" name="note[]" autocomplete="off">
                                                                </div>
                                                                </br>
                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                                    <button type="button" class="primary-btn fix-gr-bg" data-dismiss="modal">@lang('common.save')</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Notes Modal End --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8">
                                                <input class="totalStudentPaidAmount" id="ttlpaidAmount" type="hidden" name="total_paid_amount">
                                                <span id="amountDetail" class="main-title"></span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</section>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@if(moduleStatusCheck('RazorPay'))
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif
<script>
    window.paymentValue = $('#paymentMethodAddFees').val();
    let mpesaProcessing = false;

    $(function () {
        var $form = $("form#addFeesPayment");
        var publisherKey = '{!!@$stripe_info->gateway_publisher_key !!}';
        var ccFalse = false;

        // Handle M-PESA payment submission
        $(document).on('submit', '#addFeesPayment', function(e) {
            if ($('#paymentMethodAddFees').val() === 'M-PESA') {
                e.preventDefault();
                
                if (mpesaProcessing) return false;
                
                const $phoneInput = $('#mpesa_phone');
                if (!$phoneInput.length) {
                    toastr.error('M-PESA phone input field not found');
                    return false;
                }
                
                const phone = $phoneInput.val() ? $phoneInput.val().trim() : '';
                if (!phone) {
                    toastr.error('Please enter your M-PESA registered phone number');
                    return false;
                }

                const phoneRegex = /^(?:0|\+?254)([0-9]{9})$/;
                if (!phoneRegex.test(phone)) {
                    toastr.error('Please enter a valid Kenyan phone number (e.g., 0712345678)');
                    return false;
                }
                
                // Show loading state
                mpesaProcessing = true;
                $('#mpesaStatus').show();
                $('#mpesaLoading').show();
                $('#mpesaSuccess').hide();
                $('#mpesaError').hide();
                $('#mpesa_phone').prop('disabled', true);
                $('button[type="submit"]').prop('disabled', true);
                
                // Prepare STK Push data with required format
                const studentId = '{{ $invoiceInfo->studentInfo->admission_no ?? "" }}';
                
                // Get the paid amount from the input field
                let amount = 0;
                const $form = $(this);
                
                // Get the paid amount from the paid_amount input field
                const $paidAmountInput = $('input[name="paid_amount[]"]').first();
                if ($paidAmountInput.length) {
                    const val = $paidAmountInput.val();
                    if (val && !isNaN(parseFloat(val)) && parseFloat(val) > 0) {
                        amount = parseFloat(val);
                        console.log('Using paid amount from input:', amount);
                    } else {
                        toastr.error('Please enter a valid payment amount');
                        return false;
                    }
                } else {
                    // Fallback to other amount inputs if paid_amount not found
                    const $amountInputs = $('.fees-amount, input[name^="amount"], input[name$="amount"], input[name*="amount"], .amount-input');
                    let found = false;
                    
                    $amountInputs.each(function() {
                        if (found) return;
                        const $input = $(this);
                        const val = $input.val();
                        if (val && !isNaN(parseFloat(val)) && parseFloat(val) > 0) {
                            amount = parseFloat(val);
                            found = true;
                            console.log('Fallback: Found amount in input:', $input, 'Value:', amount);
                        }
                    });
                    
                    if (!found) {
                        toastr.error('Could not determine payment amount');
                        return false;
                    }
                }
                
                // 3. If no amount found, try to get it from the total amount display
                if (amount <= 0) {
                    const $totalDisplay = $('.total-amount, .amount-total, .total, .payable-amount, #totalAmount, #amountTotal, #payable_amount');
                    if ($totalDisplay.length) {
                        const totalText = $totalDisplay.text().replace(/[^0-9.]/g, '');
                        if (totalText) {
                            amount = parseFloat(totalText);
                            console.log('Found amount in total display:', amount);
                        }
                    }
                }
                
                // 4. If still no amount, check if there's a single amount input in the form
                if (amount <= 0) {
                    const $allInputs = $('input[type="number"], input[type="text"]');
                    const numericInputs = [];
                    
                    $allInputs.each(function() {
                        const val = $(this).val();
                        if (val && !isNaN(parseFloat(val)) && parseFloat(val) > 0) {
                            numericInputs.push(parseFloat(val));
                        }
                    });
                    
                    // If there's only one numeric input, use that as the amount
                    if (numericInputs.length === 1) {
                        amount = numericInputs[0];
                        console.log('Using single numeric input as amount:', amount);
                    }
                }
                
                // Ensure amount is a valid number and greater than 0
                amount = isNaN(amount) || amount <= 0 ? 0 : parseFloat(amount).toFixed(2);
                
                if (amount <= 0) {
                    toastr.error('Please enter a valid payment amount');
                    mpesaProcessing = false;
                    $('#mpesaLoading').hide();
                    $('button[type="submit"]').prop('disabled', false);
                    return false;
                }
                
                // Get invoice ID from the form
                const invoiceId = $('input[name="invoice_id"]').val();
                
                // Prepare STK push data
                const stkPushData = {
                    phone: phone,
                    amount: amount,
                    studentId: studentId,
                    invoiceId: invoiceId,
                    _token: '{{ csrf_token() }}'
                };
                // Show loading state
                mpesaProcessing = true;
                $('#mpesaLoading').show();
                $('button[type="submit"]').prop('disabled', true);
                
                // Call the Node.js API directly to initiate STK push
                $.ajax({
                    url: '{{ env("MPESA_NODE_API_URL") }}',
                    type: 'POST',
                    data: JSON.stringify(stkPushData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('M-PESA payment response:', response);
                        if (response.success && response.response.CheckoutRequestID) {
                            // Save the transaction details to our database
                            $.ajax({
                                url: '{{ route("mpesa.save-transaction") }}',
                                type: 'POST',
                                data: {
                                    phone: phone,
                                    amount: amount,
                                    student_id: studentId,
                                    invoice_id: invoiceId,
                                    checkout_request_id: response.response.CheckoutRequestID,
                                    merchant_request_id: response.response.MerchantRequestID,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(saveResponse) {
                                    console.log('Transaction saved:', saveResponse);
                                    // Show success message
                                    showMpesaSuccess('Payment request sent. Please check your phone to complete payment.');
                                    
                                    // Start polling for payment status
                                    checkMpesaPaymentStatus(response.response.CheckoutRequestID, response.response.MerchantRequestID);
                                },
                                error: function() {
                                    console.error('Failed to save transaction');
                                    // Still continue with payment flow even if saving fails
                                    showMpesaSuccess('Payment request sent. Please check your phone to complete payment.');
                                    checkMpesaPaymentStatus(response.response.CheckoutRequestID, response.response.MerchantRequestID);
                                }
                            });
                        } else {
                            showMpesaError(response.message || 'Failed to initiate M-PESA payment');
                            resetMpesaForm();
                        }
                    },
                    error: function(xhr) {
                        console.error('M-PESA Error:', xhr);
                        const error = xhr.responseJSON || {};
                        showMpesaError(error.message || 'An error occurred while processing your payment');
                        resetMpesaForm();
                    }
                });

                return false;
            }
        });
        
        // Show M-PESA success message
        function showMpesaSuccess(message) {
            $('#mpesaLoading').hide();
            $('#mpesaSuccess').show();
            $('#mpesaError').hide();
            $('#mpesaSuccessText').html('<i class="ti-check text-success"></i> ' + message);
            
            // Show toastr success notification
            toastr.success(message, 'Success!', {
                closeButton: true,
                progressBar: true,
                timeOut: 5000,
                extendedTimeOut: 2000,
                positionClass: 'toast-top-right'
            });
            
            // Auto-close the success message after 10 seconds
            setTimeout(function() {
                $('#mpesaSuccess').fadeOut();
            }, 10000);
        }
        
        // Show M-PESA error message
        function showMpesaError(message) {
            $('#mpesaLoading').hide();
            $('#mpesaError').show();
            $('#mpesaSuccess').hide();
            $('#mpesaErrorText').text(message);
            toastr.error(message);
        }
        
        // Check M-PESA payment status
        function checkMpesaPaymentStatus(checkoutRequestId, transactionId) {
            let attempts = 0;
            const maxAttempts = 20;
            const checkInterval = 6000; // 6 seconds
            
            // Debug log the parameters
            console.log('Starting payment status check with:', { 
                checkoutRequestId, 
                transactionId,
                url: '{{ route("mpesa.payment.status") }}'
            });
            
            const checkStatus = setInterval(function() {
                attempts++;
                console.log(`Checking payment status (Attempt ${attempts}/${maxAttempts})`);
                
                if (attempts >= maxAttempts) {
                    clearInterval(checkStatus);
                    showMpesaError('Payment verification timeout. Please check your M-PESA messages or try again.');
                    resetMpesaForm();
                    return;
                }
                
                // Build URL with query parameters
                const statusUrl = new URL('{{ route("mpesa.payment.status") }}', window.location.origin);
                statusUrl.searchParams.append('checkout_request_id', checkoutRequestId);
                if (transactionId) {
                    statusUrl.searchParams.append('transaction_id', transactionId);
                }
                
                console.log('Checking status at:', statusUrl.toString());
                
                // Make the request directly to the URL with query parameters
                console.log('Sending payment status check request to:', statusUrl.toString());
                $.ajax({
                    url: statusUrl.toString(),
                    type: 'GET',
                    success: function(response) {
                        console.group('Payment Status Check Response');
                        console.log('Attempt:', attempts);
                        console.log('Status:', response.status);
                        console.log('Full Response:', response);
                        console.log('Receipt Number:', response.receipt_number || 'Not available');
                        console.log('Amount:', response.amount || 'Not available');
                        console.log('Message:', response.message || 'No message');
                        console.groupEnd();
                        
                        if (response.status === 'completed') {
                            // Payment completed successfully
                            clearInterval(checkStatus);
                            const receiptNumber = response.receipt_number || 'N/A';
                            const amountPaid = response.amount ? 'KSh ' + parseFloat(response.amount).toLocaleString('en-US', {minimumFractionDigits: 2}) : '';
                            const phoneNumber = response.phone ? response.phone : '';
                            
                            const successMessage = `
                                <div class="text-left">
                                    <h5 class="text-success mb-2"><i class="ti-check-circle mr-2"></i> Payment Received Successfully!</h5>
                                    <div class="pl-4">
                                        ${amountPaid ? `<p class="mb-1"><strong>Amount:</strong> ${amountPaid}</p>` : ''}
                                        ${receiptNumber ? `<p class="mb-1"><strong>Receipt #:</strong> ${receiptNumber}</p>` : ''}
                                        ${phoneNumber ? `<p class="mb-1"><strong>Paid by:</strong> ${phoneNumber}</p>` : ''}
                                        <p class="mb-0 mt-2 text-muted">Updating your records...</p>
                                    </div>
                                </div>
                            `;
                            
                            showMpesaSuccess(successMessage);
                            
                            // Show a more prominent success notification
                            toastr.success(
                                `Payment of ${amountPaid} received successfully! Receipt: ${receiptNumber}`,
                                'Payment Successful!',
                                {
                                    timeOut: 10000,
                                    extendedTimeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: 'toast-top-center',
                                    onHidden: function() {
                                        window.location.reload();
                                    }
                                }
                            );
                            
                            // Reload the page after 5 seconds to show updated balance
                            setTimeout(function() {
                                window.location.reload();
                            }, 5000);
                            
                        } else if (response.status === 'failed' || response.status === 'cancelled') {
                            // Payment failed or was cancelled
                            clearInterval(checkStatus);
                            showMpesaError('Payment ' + response.status + '. ' + (response.message || 'Please try again.'));
                            resetMpesaForm();
                        }
                        // If status is still pending, continue polling
                    },
                    error: function(xhr) {
                        console.error('Status check error:', xhr);
                        // Continue polling on error
                    }
                });
            }, checkInterval);
        }
        
        // Reset M-PESA form to initial state
        function resetMpesaForm() {
            mpesaProcessing = false;
            $('#mpesaLoading').hide();
            $('#mpesaSuccess').hide();
            $('#mpesaError').hide();
            $('#mpesa_phone').prop('disabled', false);
            $('button[type="submit"]').prop('disabled', false);
        }

        $('form#addFeesPayment').on('submit', function (e) {
            if (paymentValue == "Stripe") {
                if (!ccFalse) {
                    e.preventDefault();
                    Stripe.setPublishableKey(publisherKey);
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            }


                    @if(moduleStatusCheck('RazorPay'))
            else if (paymentValue == 'RazorPay') {
                if (!payment) {
                    e.preventDefault();
                    let value = parseFloat($('input[name="total_paid_amount"]').val());
                    value = isNaN(value) ? 0 : value;
                    value = value * 100;

                    if (value > 0) {
                        var options = {
                            key: "{{ @$razorpay_info->gateway_secret_key }}",
                            amount: value,
                            name: 'Online fee payment',
                            image: 'https://i.imgur.com/n5tjHFD.png',
                            handler: demoSuccessHandler
                        }

                        window.r = new Razorpay(options);
                        r.open();
                    } else {
                        toastr.error('Please make some payment');
                    }
                }
            }
            @endif
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error').removeClass('hide').find('.alert').text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

        $(document).on('change', '#paymentMethodAddFees', function () {
            let gateway = $(this).val();
            paymentValue = gateway;

            $('.stripPayment, #bankPaymentAddFees, .chequeBank, .mpesaPayment').addClass('d-none');

            if (gateway === 'Stripe') {
                $('.stripPayment').removeClass('d-none');
            } else if (gateway === 'Bank') {
                $('#bankPaymentAddFees, .chequeBank').removeClass('d-none');
            } else if (gateway === 'Cheque') {
                $('.chequeBank').removeClass('d-none');
            } else if (gateway === 'M-PESA') {
                $('.mpesaPayment').removeClass('d-none');
            }

            let showStudentPaidAmount = 0;
            $('.dueAmount').each(function () {
                showStudentPaidAmount += parseFloat($(this).val()) || 0;
            });

            serviceCharge(gateway, showStudentPaidAmount, 'payment_method');
        });

        $('form#addFeesPayment').on('submit', function (e) {
            if (paymentValue === 'M-PESA') {
                const phone = $('#phone_number').val().trim();
                if (!/^07\d{8}$/.test(phone)) {
                    e.preventDefault();
                    alert('Please enter a valid M-PESA phone number (e.g., 0712345678)');
                    return false;
                }
            }
        });


        $(document).on('keyup', '.addFeesPaidAmount', function () {
            let gateway = $('#paymentMethodAddFees').val();
            if (gateway === '') return;

            let paidAmount = 0;
            $('.addFeesPaidAmount').each(function (i, e) {
                let amount = $(this).val() - 0;
                paidAmount += amount;
            });

            serviceCharge(gateway, paidAmount, 'goingToPay');
        });

        function serviceCharge(gateway, amount, status) {
            var symbol = "{{ generalSetting()->currency_symbol }}";
            let amountTotal = parseFloat(amount);
            $.ajax({
                type: "GET",
                data: {gateway: gateway, amount: amountTotal, status: status},
                dataType: "JSON",
                url: "{{ route('gateway-service-charge') }}",
                success: function (data) {
                    if (data.service_charge) {
                        if (status == 'payment_method') {
                            $('#serviceChargeTitle').html('You Have to Pay service charge ' + data.service_charge + ' for ' + gateway + ' per transaction');
                        }
                        if (data.service_charge_amount && status == 'goingToPay') {
                            let total = parseFloat(amount) + parseFloat(data.service_charge_amount);
                            $("#ttlpaidAmount").val(total);
                            $('#amountDetail').html('Your payable amount with service charge: ' + symbol + amount + ' + ' + symbol + data.service_charge_amount + ' = ' + symbol + parseFloat(total));
                        }
                    }
                }
            });
        }
    });
</script>

<script type="text/javascript" src="{{url('Modules\Fees\Resources\assets\js\app.js')}}"></script>
<script>
    selectPosition({!! feesInvoiceSettings()->invoice_positions !!});
</script>