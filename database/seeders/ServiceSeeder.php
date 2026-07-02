<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [

            /*
            |--------------------------------------------------------------------------
            | Company Registration
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV001',
                'name' => 'Private Limited Company Registration',
                'category' => 'Registration',
                'frequency' => 'One Time',
                'default_price' => 12000,
            ],

            [
                'service_code' => 'SRV002',
                'name' => 'LLP Registration',
                'category' => 'Registration',
                'frequency' => 'One Time',
                'default_price' => 10000,
            ],

            [
                'service_code' => 'SRV003',
                'name' => 'Partnership Firm Registration',
                'category' => 'Registration',
                'frequency' => 'One Time',
                'default_price' => 5000,
            ],

            /*
            |--------------------------------------------------------------------------
            | GST
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV004',
                'name' => 'GST Registration',
                'category' => 'Taxation',
                'frequency' => 'One Time',
                'default_price' => 3000,
            ],

            [
                'service_code' => 'SRV005',
                'name' => 'GST Return Filing',
                'category' => 'Taxation',
                'frequency' => 'Monthly',
                'default_price' => 2500,
            ],

            /*
            |--------------------------------------------------------------------------
            | Income Tax
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV006',
                'name' => 'Income Tax Return Filing',
                'category' => 'Taxation',
                'frequency' => 'Yearly',
                'default_price' => 3500,
            ],

            /*
            |--------------------------------------------------------------------------
            | Payroll
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV007',
                'name' => 'Payroll Management',
                'category' => 'Payroll',
                'frequency' => 'Monthly',
                'default_price' => 5000,
            ],

            /*
            |--------------------------------------------------------------------------
            | EPF
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV008',
                'name' => 'EPF Compliance',
                'category' => 'Compliance',
                'frequency' => 'Monthly',
                'default_price' => 2500,
            ],

            /*
            |--------------------------------------------------------------------------
            | ESIC
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV009',
                'name' => 'ESIC Compliance',
                'category' => 'Compliance',
                'frequency' => 'Monthly',
                'default_price' => 2500,
            ],

            /*
            |--------------------------------------------------------------------------
            | TDS
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV010',
                'name' => 'TDS Return Filing',
                'category' => 'Taxation',
                'frequency' => 'Quarterly',
                'default_price' => 3500,
            ],

            /*
            |--------------------------------------------------------------------------
            | Accounting
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV011',
                'name' => 'Bookkeeping & Accounting',
                'category' => 'Accounting',
                'frequency' => 'Monthly',
                'default_price' => 8000,
            ],

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV012',
                'name' => 'Statutory Audit',
                'category' => 'Consultancy',
                'frequency' => 'Yearly',
                'default_price' => 25000,
            ],

            /*
            |--------------------------------------------------------------------------
            | FSSAI
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV013',
                'name' => 'FSSAI Registration',
                'category' => 'Licensing',
                'frequency' => 'One Time',
                'default_price' => 4000,
            ],

            /*
            |--------------------------------------------------------------------------
            | UDYAM
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV014',
                'name' => 'UDYAM Registration',
                'category' => 'Registration',
                'frequency' => 'One Time',
                'default_price' => 2500,
            ],

            /*
            |--------------------------------------------------------------------------
            | IEC
            |--------------------------------------------------------------------------
            */

            [
                'service_code' => 'SRV015',
                'name' => 'Import Export Code (IEC)',
                'category' => 'Licensing',
                'frequency' => 'One Time',
                'default_price' => 5000,
            ],

        ];

        foreach ($services as $service) {

            Service::updateOrCreate(

                [
                    'service_code' => $service['service_code'],
                ],

                array_merge($service, [

                    'is_recurring' => $service['frequency'] !== 'One Time',

                    'due_day' => 10,

                    'icon' => 'mdi-briefcase',

                    'color' => '#0d6efd',

                    'sort_order' => 0,

                    'is_active' => true,

                ])

            );

        }
    }
}