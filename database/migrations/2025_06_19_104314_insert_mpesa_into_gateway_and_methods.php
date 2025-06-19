<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class InsertMpesaIntoGatewayAndMethods extends Migration
{
    public function up()
    {
        // Check if M-PESA already exists
        $exists = DB::table('sm_payment_gateway_settings')
            ->where('gateway_name', 'M-PESA')
            ->exists();

        if (!$exists) {
            // Insert M-PESA into gateway settings
            $gatewayId = DB::table('sm_payment_gateway_settings')->insertGetId([
                'gateway_name'       => 'M-PESA',
                'gateway_username'   => 'demo@safaricom.com',
                'gateway_password'   => 'saf@12345',
                'gateway_client_id'  => env('MPESA_CONSUMER_KEY', 'test_consumer_key'),
                'gateway_secret_key' => env('MPESA_CONSUMER_SECRET', 'test_secret_key'),
                'gateway_signature'  => env('MPESA_PASSKEY', 'test_passkey'),
                'gateway_mode'       => env('MPESA_ENV', 'sandbox'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Insert M-PESA into payment methods
            DB::table('sm_payment_methhods')->insert([
                'method'        => 'M-PESA',
                'type'          => 'System',
                'gateway_id'    => $gatewayId,
                'active_status' => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
                'created_by'    => 1,
                'updated_by'    => 1,
                'school_id'     => 1,
            ]);
        }
    }

    public function down()
    {
        DB::table('sm_payment_methhods')->where('method', 'M-PESA')->delete();
        DB::table('sm_payment_gateway_settings')->where('gateway_name', 'M-PESA')->delete();
    }
}
