<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentOrDeductionTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['uuid' => Str::uuid(), 'payment_code' => 'PBASIC101', 'pay_or_ded' => 1, 'description' => 'Basic Pay', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PHRENT102', 'pay_or_ded' => 1, 'description' => 'House Rent', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PUTILITY103', 'pay_or_ded' => 1, 'description' => 'Utility Allowances', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PLFA104', 'pay_or_ded' => 1, 'description' => 'L.F.A', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PHMAINT105', 'pay_or_ded' => 1, 'description' => 'House Maintenance', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PMEDICL106', 'pay_or_ded' => 1, 'description' => 'Medical Allowances', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PCONVNC107', 'pay_or_ded' => 1, 'description' => 'Conveyance Allowances', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'PPFOWN108', 'pay_or_ded' => 1, 'description' => 'PF Own', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'DPFBANK101', 'pay_or_ded' => 2, 'description' => 'PF Bank', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'DINCTAX102', 'pay_or_ded' => 2, 'description' => 'Income Tax', 'status' => 101],
            ['uuid' => Str::uuid(), 'payment_code' => 'DWELFARE103', 'pay_or_ded' => 2, 'description' => 'Employees Welfare Fund', 'status' => 101],
        ];

        DB::table('payment_or_deduction_types')->insert($data);
    }
}