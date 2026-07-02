<?php

namespace Database\Seeders;

use App\Models\ClientTag;
use Illuminate\Database\Seeder;

class ClientTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [

            /*
            |--------------------------------------------------------------------------
            | Client Type
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'VIP',
                'color' => '#dc3545',
                'description' => 'High priority client',
            ],

            [
                'name' => 'Premium',
                'color' => '#0d6efd',
                'description' => 'Premium service client',
            ],

            [
                'name' => 'Regular',
                'color' => '#198754',
                'description' => 'Regular client',
            ],

            [
                'name' => 'Startup',
                'color' => '#6f42c1',
                'description' => 'Startup company',
            ],

            [
                'name' => 'MSME',
                'color' => '#fd7e14',
                'description' => 'Micro, Small & Medium Enterprise',
            ],

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Payment Due',
                'color' => '#ffc107',
                'description' => 'Payment pending',
            ],

            [
                'name' => 'Defaulter',
                'color' => '#dc3545',
                'description' => 'Outstanding payment',
            ],

            /*
            |--------------------------------------------------------------------------
            | Compliance
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'GST',
                'color' => '#20c997',
                'description' => 'GST Client',
            ],

            [
                'name' => 'Income Tax',
                'color' => '#0dcaf0',
                'description' => 'Income Tax Client',
            ],

            [
                'name' => 'Payroll',
                'color' => '#198754',
                'description' => 'Payroll Client',
            ],

            [
                'name' => 'EPF',
                'color' => '#6610f2',
                'description' => 'EPF Compliance',
            ],

            [
                'name' => 'ESIC',
                'color' => '#6c757d',
                'description' => 'ESIC Compliance',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'New Client',
                'color' => '#0d6efd',
                'description' => 'Recently onboarded',
            ],

            [
                'name' => 'Important',
                'color' => '#d63384',
                'description' => 'Important client',
            ],

            [
                'name' => 'Follow Up',
                'color' => '#ffc107',
                'description' => 'Needs follow-up',
            ],

            [
                'name' => 'Inactive',
                'color' => '#6c757d',
                'description' => 'Inactive client',
            ],

        ];

        foreach ($tags as $tag) {

            ClientTag::updateOrCreate(

                [
                    'name' => $tag['name'],
                ],

                [
                    'color' => $tag['color'],
                    'description' => $tag['description'],
                    'is_active' => true,
                ]

            );

        }
    }
}