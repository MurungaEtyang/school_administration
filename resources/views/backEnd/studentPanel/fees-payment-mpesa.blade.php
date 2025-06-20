<div class="container-fluid">
    <form method="POST" action="{{ route('fees-payment-mpesa-store') }}" id="mpesa-payment-form">
        @csrf
        <input type="hidden" name="assign_id" value="{{ $assign_id }}">
        <input type="hidden" name="student_id" value="{{ $student_id }}">
        <input type="hidden" name="fees_type" value="{{ $fees_type }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="record_id" value="{{ $record_id }}">
        <input type="hidden" name="payment_method" value="Mpesa">

        <div class="row">
            <div class="col-lg-6 mt-20">
                <div class="primary_input">
                    <label class="primary_input_label" for="mpesa_number">
                        @lang('accounts.phone_number') <span class="text-danger">*</span>
                    </label>
                    <input
                            type="text"
                            name="mpesa_number"
                            id="mpesa_number"
                            class="primary_input_field form-control"
                            placeholder="e.g. 2547XXXXXXXX"
                            required
                    >
                </div>
            </div>

            <div class="col-lg-12 text-center mt-40">
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">
                        @lang('common.cancel')
                    </button>
                    <button class="primary-btn fix-gr-bg submit" type="submit">
                        @lang('common.pay_now')
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
