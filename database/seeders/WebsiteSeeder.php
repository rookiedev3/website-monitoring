<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = [
            // 1. Uji Website ONLINE (Normal Status 200)
            [
                'customer_name' => 'PT Google Indonesia',
                'website_name' => 'Google Search',
                'domain' => 'google.com',
                'url' => 'https://google.com',
                'category' => 'Search Engine',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 5,
                'notes' => 'Target pengujian status Online 200 OK',
            ],

            // 2. Uji Website MATI / DOWN TOTAL (Domain/Port Tidak Ditemukan)
            [
                'customer_name' => 'PT Testing Down',
                'website_name' => 'Domain Dummy Mati',
                'domain' => 'this-domain-should-never-exist-12345.com',
                'url' => 'https://this-domain-should-never-exist-12345.com',
                'category' => 'Testing',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 3,
                'notes' => 'Target pengujian Connection Failed / Down Total',
            ],

            // 3. Uji Website HTTP ERROR (Server merespons 404 / 500)
            [
                'customer_name' => 'Client Mock Server',
                'website_name' => 'HTTP Status Error 500',
                'domain' => 'httpstat.us',
                'url' => 'https://httpstat.us/500',
                'category' => 'Testing',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 5,
                'notes' => 'Target pengujian HTTP Server Error 500',
            ],

            // 4. Uji Website SSL INVALID / EXPIRED
            [
                'customer_name' => 'BadSSL Test',
                'website_name' => 'Expired SSL Test',
                'domain' => 'expired.badssl.com',
                'url' => 'https://expired.badssl.com',
                'category' => 'Testing',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 5,
                'notes' => 'Target pengujian Sertifikat SSL Kadaluwarsa',
            ],

            // 5. Uji Website SLOW / TIMEOUT (Respons Lambat > 3 Detik)
            [
                'customer_name' => 'Client Response Slow',
                'website_name' => 'Delay Response 4s',
                'domain' => 'httpstat.us',
                'url' => 'https://httpstat.us/200?sleep=4000',
                'category' => 'Testing',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 10,
                'notes' => 'Target pengujian status Slow / Warning (> 3000ms)',
            ],

            // Alternatif Seeder untuk Uji SLOW / WARNING (Delay 4 Detik)
            [
                'customer_name' => 'Client Response Slow',
                'website_name' => 'Delay Response 4s',
                'domain' => 'hub.dummyjson.com',
                'url' => 'https://hub.dummyjson.com/delay?ms=4000',
                'category' => 'Testing',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 10,
                'notes' => 'Target pengujian status Slow / Warning (> 3000ms)',
            ],

            // Alternatif Seeder untuk Uji HTTP ERROR 500
            [
                'customer_name' => 'Client Mock Server',
                'website_name' => 'HTTP Status Error 500',
                'domain' => 'httpbin.org',
                'url' => 'https://httpbin.org/status/500',
                'category' => 'Testing',
                'monitoring_status' => 'active',
                'check_interval' => 1,
                'timeout_seconds' => 5,
                'notes' => 'Target pengujian HTTP Server Error 500',
            ],
        ];

        foreach ($websites as $site) {
            Website::updateOrCreate(
                ['url' => $site['url']],
                $site
            );
        }
    }
}
