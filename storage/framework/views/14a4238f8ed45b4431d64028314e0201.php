<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('system_settings.payment_method_settings'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContent'); ?>
    <?php $__env->startPush('css'); ?>
        <style>
            /* your existing styles */
        </style>
    <?php $__env->stopPush(); ?>

    <section class="sms-breadcrumb mb-20">
        <!-- breadcrumb markup -->
    </section>

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row pt-20">
                <!-- LEFT COLUMN: enable gateways -->
                <div class="col-lg-3">
                    <?php if(userPermission('is-active-payment')): ?>
                        <?php echo e(Form::open(['route' => 'is-active-payment', 'class' => 'form-horizontal'])); ?>

                    <?php endif; ?>
                    <div class="white-box">
                        <h3 class="main-title mb-15"><?php echo app('translator')->get('system_settings.select_a_payment_gateway'); ?></h3>
                        <table class="table">
                            <?php $__currentLoopData = $paymeny_gateway; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!(moduleStatusCheck('RazorPay') == FALSE && $value->method == "RazorPay")): ?>
                                    <tr>
                                        <td class="CustomPaymentMethod">
                                            <div class="primary_input">
                                                <input type="checkbox" id="gateway_<?php echo e($value->method); ?>" name="gateways[<?php echo e($value->id); ?>]" class="common-checkbox" value="<?php echo e($value->id); ?>" <?php echo e($value->active_status == 1 ? 'checked' : ''); ?>>
                                                <label for="gateway_<?php echo e($value->method); ?>"><?php echo e($value->method); ?></label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                        <div class="mt-15 text-center">
                            <button class="primary-btn fix-gr-bg"><?php echo app('translator')->get('common.update'); ?></button>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>

                <!-- RIGHT COLUMN: gateway settings tabs -->
                <div class="col-lg-9">
                    <div class="white-box">
                        <h3 class="main-title pt-10"><?php echo app('translator')->get('system_settings.gateway_setting'); ?></h3>
                        <ul class="nav nav-tabs my-2">
                            <?php $__currentLoopData = $paymeny_gateway_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!(moduleStatusCheck('RazorPay') == FALSE && $row->gateway_name == "RazorPay")): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e($row->gateway_name == 'PayPal' ? 'active show' : ''); ?>" href="#<?php echo e($row->gateway_name); ?>" data-toggle="tab"><?php echo e($row->gateway_name); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <div class="tab-content">
                            <?php $forServiceCharge = ['service_charge', 'charge']; ?>
                            <?php $__currentLoopData = $paymeny_gateway_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-pane fade <?php echo e($row->gateway_name == 'PayPal' ? 'active show' : ''); ?>" id="<?php echo e($row->gateway_name); ?>">
                                    <?php if(userPermission('update-payment-gateway')): ?>
                                        <form action="<?php echo e(route('update-payment-gateway')); ?>" method="POST" class="form-horizontal">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="gateway_name" value="<?php echo e($row->gateway_name); ?>">
                                            <?php endif; ?>

                                            <div class="row mb-15"><div class="col-md-12">
    <?php
        $count = 0;
        if($row->gateway_name == "PayPal") {
            $paymeny_gateway = ['gateway_name','gateway_username','gateway_password','gateway_signature','gateway_client_id','gateway_mode','gateway_secret_key','service_charge','charge'];
        }
        else if($row->gateway_name == "M-PESA") {
            $paymeny_gateway = ['gateway_name','gateway_client_id','gateway_secret_key','gateway_signature','gateway_mode','service_charge','charge'];
        }
        else if($row->gateway_name == "Stripe") {
            $paymeny_gateway = ['gateway_name','gateway_username','gateway_secret_key','gateway_publisher_key','service_charge','charge'];
        }
        // ... other existing gateways ...
        else if($row->gateway_name == "Cheque") {
            $paymeny_gateway = ['gateway_name','cheque_details'];
        }
    ?>

    <?php $__currentLoopData = $paymeny_gateway; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $newStr = $input_field;
            $label_name = str_replace('_', ' ', $newStr);
            // M-PESA label override
            if($row->gateway_name == 'M-PESA') {
                $map = [
                    'gateway_client_id' => 'Consumer Key',
                    'gateway_secret_key' => 'Consumer Secret',
                    'gateway_signature' => 'Passkey',
                    'gateway_mode' => 'Environment (sandbox/live)'
                ];
                if(isset($map[$input_field])) {
                    $label_name = $map[$input_field];
                }
            }
            $value = $row->$input_field;
        ?>
                                                        <?php if(!in_array($input_field, $forServiceCharge)): ?>
                                                            <div class="row mb-15">
                                                                <div class="col-lg-12">
                                                                    <label><?php echo e($label_name); ?>

                                                                        <?php if($input_field == 'gateway_mode'): ?> <small>(sandbox or live)</small> <?php endif; ?>
                                                                    </label>
                                                                    <input type="text" name="<?php echo e($input_field); ?>" class="form-control" value="<?php echo e($value); ?>" <?php echo e($count == 0 ? 'readonly' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if($input_field == 'service_charge'): ?>
                                                            <?php $d_none = $row->service_charge == 0 ? 'd-none' : ''; ?>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <input type="checkbox" id="service_charge_<?php echo e($row->gateway_name); ?>" name="service_charge" class="common-checkbox service_charge" data-gateway_name="<?php echo e($row->gateway_name); ?>" <?php echo e($row->service_charge == 1 ? 'checked' : ''); ?>>
                                                                    <label for="service_charge_<?php echo e($row->gateway_name); ?>"><?php echo app('translator')->get('common.service_charge'); ?></label>
                                                                </div>
                                                            </div>
                                                            <div class="row <?php echo e($d_none); ?>" id="charge_type_<?php echo e($row->gateway_name); ?>">
                                                                <div class="col-lg-6">
                                                                    <input type="radio" name="charge_type" value="P" class="common-radio type_<?php echo e($row->gateway_name); ?>" <?php echo e($row->charge_type == 'P' ? 'checked' : ''); ?>> <?php echo app('translator')->get('common.Percentage'); ?>
                                                                    <input type="radio" name="charge_type" value="F" class="common-radio type_<?php echo e($row->gateway_name); ?>" <?php echo e($row->charge_type == 'F' ? 'checked' : ''); ?>> <?php echo app('translator')->get('common.Flat'); ?>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="number" name="charge" class="form-control chargeValue" data-gateway_name="<?php echo e($row->gateway_name); ?>" value="<?php echo e($row->charge); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php $count++; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div></div>

                                            <div class="row">
                                                <div class="col-md-7 text-center">
                                                    <?php if(!empty($row->logo)): ?>
                                                        <img src="<?php echo e(asset($row->logo)); ?>" style="height:100px">
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if($row->gateway_name != 'Bank'): ?>
                                                <div class="row mt-40"><div class="col-lg-12 text-center">
                                                        <button class="primary-btn fix-gr-bg"><?php echo app('translator')->get('common.update'); ?></button>
                                                    </div></div>
                                            <?php endif; ?>

                                            <?php if(userPermission('update-payment-gateway')): ?>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
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
                toastr.error("<?php echo app('translator')->get('common.percentage_max_error'); ?>");
                $(this).val('');
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/resources/views/backEnd/systemSettings/paymentMethodSettings.blade.php ENDPATH**/ ?>