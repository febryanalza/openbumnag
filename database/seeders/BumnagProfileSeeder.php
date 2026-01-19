<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BumnagProfile;

class BumnagProfileSeeder extends Seeder
{
    public function run(): void
    {
        BumnagProfile::create([
            'name' => 'BUMNag Contoh',
            'nagari_name' => 'Nagari Contoh',
            'slug' => 'bumnag-contoh',
            'tagline' => 'Membangun Nagari Bersama',
            'about' => '<p>BUMNag Contoh adalah badan usaha milik nagari yang didirikan untuk meningkatkan perekonomian masyarakat nagari.</p>',
            'vision' => '<p>Menjadi BUMNag yang mandiri, profesional, dan berkelanjutan dalam meningkatkan kesejahteraan masyarakat nagari.</p>',
            'mission' => '<ul><li>Mengelola aset nagari secara profesional</li><li>Meningkatkan pendapatan asli nagari</li><li>Memberdayakan ekonomi masyarakat</li><li>Menciptakan lapangan kerja bagi masyarakat</li></ul>',
            'values' => '<ul><li>Integritas</li><li>Profesional</li><li>Transparan</li><li>Akuntabel</li></ul>',
            'history' => '<p>BUMNag Contoh didirikan pada tahun 2020 berdasarkan Peraturan Nagari...</p>',
            'legal_entity_number' => '001/BUMNag/2020',
            'established_date' => '2020-01-15',
            'notary_name' => 'Notaris Contoh, S.H.',
            'deed_number' => '001/2020',
            'address' => 'Jl. Nagari No. 123, Nagari Contoh',
            'postal_code' => '12345',
            'phone' => '0751-123456',
            'email' => 'info@bumnagcontoh.id',
            'website' => 'https://bumnagcontoh.id',
            'facebook' => 'bumnagcontoh',
            'instagram' => '@bumnagcontoh',
            'whatsapp' => '628123456789',
            'operating_hours' => json_encode([
                'senin' => '08:00 - 16:00',
                'selasa' => '08:00 - 16:00',
                'rabu' => '08:00 - 16:00',
                'kamis' => '08:00 - 16:00',
                'jumat' => '08:00 - 16:00',
                'sabtu' => 'Tutup',
                'minggu' => 'Tutup',
            ]),
            'is_active' => true,
        ]);
    }
}
