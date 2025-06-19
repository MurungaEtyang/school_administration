<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmPaymentGatewaySettingsTable extends Migration
{
    public function up()
    {
        Schema::create('sm_payment_gateway_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gateway_name')->nullable();
            $table->string('gateway_username')->nullable();
            $table->string('gateway_password')->nullable();
            $table->string('gateway_signature')->nullable();
            $table->string('gateway_client_id')->nullable();
            $table->string('gateway_mode')->nullable();
            $table->string('gateway_secret_key')->nullable();
            $table->string('gateway_secret_word')->nullable();
            $table->string('gateway_publisher_key')->nullable();
            $table->string('gateway_private_key')->nullable();
            $table->tinyInteger('active_status')->default(0);
            $table->timestamps();

            $table->text('bank_details')->nullable();
            $table->text('cheque_details')->nullable();

            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');

            $table->boolean('service_charge')->nullable()->default(false);
            $table->string('charge_type', 2)->nullable()->comment('P=percentage, F=Flat');
            $table->float('charge')->nullable()->default(0.00);
        });

        // PayPal
        DB::table('sm_payment_gateway_settings')->insert([
            'gateway_name'       => 'PayPal',
            'gateway_username'   => 'demo@paypal.com',
            'gateway_password'   => '12334589',
            'gateway_client_id'  => 'AaCPtpoUHZEXCa3v006nbYhYfD0HIX-dlgYWlsb0fdoFqpVToATuUbT43VuUE6pAxgvSbPTspKBqAF0x',
            'gateway_secret_key' => 'EJ6q4h8w0OanYO1WKtNbo9o8suDg6PKUkHNKv-T6F4APDiq2e19OZf7DfpL5uOlEzJ_AMgeE0L2PtTEj',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // Stripe
        DB::table('sm_payment_gateway_settings')->insert([
            'gateway_name'       => 'Stripe',
            'gateway_username'   => 'demo@stripe.com',
            'gateway_password'   => '12334589',
            'gateway_secret_key' => 'AVZdghanegaOjiL6DPXd0XwjMGEQ2aXc58z1-isWmBFnw1h2j',
            'gateway_secret_word'=> 'AVZdghanegaOjiL6DPXd0XwjMGEQ2aXc58z1',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // Paystack
        DB::table('sm_payment_gateway_settings')->insert([
            'gateway_name'         => 'Paystack',
            'gateway_username'     => 'demo@gmail.com',
            'gateway_password'     => '12334589',
            'gateway_secret_key'   => 'sk_live_2679322872013c265e161bc8ea11efc1e822bce1',
            'gateway_publisher_key'=> 'pk_live_e5738ce9aade963387204f1f19bee599176e7a71',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // Bank
        DB::table('sm_payment_gateway_settings')->insert([
            'gateway_name' => 'Bank',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // Cheque
        DB::table('sm_payment_gateway_settings')->insert([
            'gateway_name' => 'Cheque',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // M-PESA (NEW)
        DB::table('sm_payment_gateway_settings')->insert([
            'gateway_name'       => 'M-PESA',
            'gateway_username'   => 'demo@safaricom.com',
            'gateway_password'   => 'saf@12345',
            'gateway_client_id'  => env('MPESA_CONSUMER_KEY'),
            'gateway_secret_key' => env('MPESA_CONSUMER_SECRET'),
            'gateway_signature'  => env('MPESA_PASSKEY'),
            'gateway_mode'       => env('MPESA_ENV', 'sandbox'),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('sm_payment_gateway_settings');
    }
}
