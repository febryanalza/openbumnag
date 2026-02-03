<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk settings umum (kontak dan sosial media).
 * 
 * NOTE: Settings untuk homepage (hero, about, news, reports, catalog, cta)
 *       dikelola oleh HomepageSettingSeeder dengan group 'homepage'.
 */
class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Contact Information
            [
                'key' => 'contact_address',
                'value' => 'Desa Lubas, Kecamatan Lubuk Alung, Kabupaten Padang Pariaman',
                'type' => 'textarea',
                'group' => 'contact',
                'description' => 'Alamat lengkap',
                'order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '0751-1234567',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor telepon',
                'order' => 2,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@lubasmandiri.id',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Email',
                'order' => 3,
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6281234567890',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor WhatsApp (dengan kode negara)',
                'order' => 4,
            ],
            
            // Social Media
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Facebook',
                'order' => 1,
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Instagram',
                'order' => 2,
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Twitter/X',
                'order' => 3,
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@lubasmandiri',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL YouTube',
                'order' => 4,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
