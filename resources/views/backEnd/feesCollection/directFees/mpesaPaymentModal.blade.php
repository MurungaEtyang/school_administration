<script src="{{ asset('public/backEnd/') }}/js/main.js"></script>

<div class="container-fluid">
    <form method="POST" action="{{ route('fees-payment-mpesa-store') }}" id="mpesa-payment-form">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="installment_id" value="{{ $installment->id }}">
                <input type="hidden" name="student_id" value="{{ $installment->student_id }}">
                <input type="hidden" name="amount" value="{{ $installment->amount }}">
                <input type="hidden" name="record_id" value="{{ $installment->record_id }}">
                <input type="hidden" name="payment_method" value="MPESA">

                <div class="row mt-25">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 mt-20">
                                <div class="primary_input">
                                    <input class="primary_input_field form-control"
                                           type="text" name="phone_number"
                                           id="phone_number" required
                                           placeholder="07XXXXXXXX">
                                    <label class="primary_input_label" for="phone_number">
                                        @lang('accounts.phone_number') <span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row end -->
            </div>
        </div>

        <div class="col-lg-12 text-center mt-40">
            <div class="mt-40 d-flex justify-content-between">
                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                <button class="primary-btn fix-gr-bg" type="submit">@lang('common.save_information')</button>
            </div>
        </div>
    </form>
</div>
