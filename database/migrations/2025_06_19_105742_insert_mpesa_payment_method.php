<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class InsertMpesaPaymentMethod extends Migration
{
    public function up()
    {
        $gateway = DB::table('sm_payment_gateway_settings')
            ->where('gateway_name', 'M-PESA')
            ->first();

        if ($gateway && !DB::table('sm_payment_methhods')->where('method', 'M-PESA')->exists()) {
            DB::table('sm_payment_methhods')->insert([
                'method'        => 'M-PESA',
                'type'          => 'System',
                'gateway_id'    => $gateway->id,
                'active_status' => 1,
                'created_by'    => 1,
                'updated_by'    => 1,
                'school_id'     => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

    public function down()
    {
        DB::table('sm_payment_methhods')->where('method', 'M-PESA')->delete();
    }
}

