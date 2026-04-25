<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CertificateType;

class CertificateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Certificate of Fit to Work',
                'slug' => 'fit_to_work',
                'description' => 'Certifies that the patient is physically and medically fit to perform work duties.',
            ],
            [
                'name' => 'Medical Certificate',
                'slug' => 'medical_certificate',
                'description' => 'General medical certificate confirming patient examination and health status.',
            ],
            [
                'name' => 'Medical Abstract',
                'slug' => 'medical_abstract',
                'description' => 'Summary of patient\'s medical history, treatments, and current condition.',
            ],
            [
                'name' => 'Sanitary Permit',
                'slug' => 'sanitary_permit',
                'description' => 'Certifies compliance with health and sanitation requirements.',
            ],
            [
                'name' => 'Sick Leave Certificate',
                'slug' => 'sick_leave',
                'description' => 'Certificate recommending a period of rest due to illness or medical condition.',
            ],
            [
                'name' => 'Clearance Certificate',
                'slug' => 'clearance',
                'description' => 'Medical clearance for specific activities, events, or requirements.',
            ],
        ];

        foreach ($types as $type) {
            CertificateType::updateOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}
