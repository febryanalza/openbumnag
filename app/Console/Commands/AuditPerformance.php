<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class AuditPerformance extends Command
{
    protected $signature = 'audit:performance';
    protected $description = 'Audit performa aplikasi secara menyeluruh';

    public function handle()
    {
        $this->info('🔍 AUDIT PERFORMA APLIKASI BUMNAG');
        $this->info('=====================================');
        $this->newLine();

        $issues = [];
        $recommendations = [];

        // 1. Cek Konfigurasi Environment
        $this->info('📋 1. KONFIGURASI ENVIRONMENT');
        $this->line('   APP_ENV: ' . config('app.env'));
        $this->line('   APP_DEBUG: ' . (config('app.debug') ? 'true' : 'false'));
        
        if (config('app.env') === 'local' && config('app.debug')) {
            $this->warn('   ⚠️  Debug mode aktif di local (OK untuk development)');
        }
        $this->newLine();

        // 2. Cek Session Driver
        $this->info('🔐 2. SESSION CONFIGURATION');
        $sessionDriver = config('session.driver');
        $this->line('   Driver: ' . $sessionDriver);
        
        if ($sessionDriver === 'database') {
            $issues[] = '❌ SESSION menggunakan DATABASE (SANGAT LAMBAT)';
            $recommendations[] = '✅ Ubah SESSION_DRIVER=file di .env untuk development';
            $recommendations[] = '✅ Atau gunakan SESSION_DRIVER=redis untuk production';
            $this->error('   ❌ MASALAH: Session driver menggunakan database!');
            $this->warn('   Setiap request harus query database untuk session.');
        } else {
            $this->info('   ✅ Session driver optimal: ' . $sessionDriver);
        }
        $this->newLine();

        // 3. Cek Cache Driver
        $this->info('💾 3. CACHE CONFIGURATION');
        $cacheDriver = config('cache.default');
        $this->line('   Driver: ' . $cacheDriver);
        
        if ($cacheDriver === 'database') {
            $issues[] = '❌ CACHE menggunakan DATABASE (LAMBAT)';
            $recommendations[] = '✅ Ubah CACHE_STORE=file di .env untuk development';
            $recommendations[] = '✅ Atau gunakan CACHE_STORE=redis untuk production';
            $this->error('   ❌ MASALAH: Cache driver menggunakan database!');
            $this->warn('   Setiap cache operation harus query database.');
        } else {
            $this->info('   ✅ Cache driver optimal: ' . $cacheDriver);
        }
        $this->newLine();

        // 4. Cek Queue Driver
        $this->info('📨 4. QUEUE CONFIGURATION');
        $queueDriver = config('queue.default');
        $this->line('   Driver: ' . $queueDriver);
        
        if ($queueDriver === 'database') {
            $this->warn('   ⚠️  Queue menggunakan database (OK untuk development)');
        } else {
            $this->info('   ✅ Queue driver: ' . $queueDriver);
        }
        $this->newLine();

        // 5. Cek Database Connection
        $this->info('🗄️  5. DATABASE CONNECTION');
        try {
            $start = microtime(true);
            DB::connection()->getPdo();
            $end = microtime(true);
            $time = round(($end - $start) * 1000, 2);
            
            $this->line('   Connection: ' . config('database.default'));
            $this->line('   Host: ' . config('database.connections.mysql.host'));
            $this->line('   Database: ' . config('database.connections.mysql.database'));
            $this->info('   ✅ Database connected: ' . $time . 'ms');
            
            if ($time > 100) {
                $issues[] = '⚠️  Database connection lambat: ' . $time . 'ms';
                $recommendations[] = '✅ Periksa koneksi database atau gunakan localhost';
            }
        } catch (\Exception $e) {
            $this->error('   ❌ Database connection failed: ' . $e->getMessage());
            $issues[] = '❌ Database tidak bisa diakses';
        }
        $this->newLine();

        // 6. Test Database Query Performance
        $this->info('⚡ 6. DATABASE QUERY PERFORMANCE');
        try {
            $start = microtime(true);
            DB::table('users')->count();
            $end = microtime(true);
            $time = round(($end - $start) * 1000, 2);
            
            $this->line('   Simple query (COUNT users): ' . $time . 'ms');
            
            if ($time > 50) {
                $issues[] = '⚠️  Query performance lambat: ' . $time . 'ms';
            } else {
                $this->info('   ✅ Query performance bagus');
            }
        } catch (\Exception $e) {
            $this->error('   ❌ Query failed: ' . $e->getMessage());
        }
        $this->newLine();

        // 7. Cek Storage Permissions
        $this->info('📁 7. STORAGE & PERMISSIONS');
        $storagePath = storage_path();
        $bootstrapCache = base_path('bootstrap/cache');
        
        $this->line('   Storage path: ' . $storagePath);
        $this->line('   Writable: ' . (is_writable($storagePath) ? '✅ Yes' : '❌ No'));
        
        if (!is_writable($storagePath)) {
            $issues[] = '❌ Storage tidak writable';
            $recommendations[] = '✅ Jalankan: chmod -R 775 storage bootstrap/cache';
        }
        
        $this->line('   Bootstrap cache: ' . $bootstrapCache);
        $this->line('   Writable: ' . (is_writable($bootstrapCache) ? '✅ Yes' : '❌ No'));
        $this->newLine();

        // 8. Cek Cached Config
        $this->info('⚙️  8. LARAVEL OPTIMIZATION');
        $configCached = File::exists(base_path('bootstrap/cache/config.php'));
        $routesCached = File::exists(base_path('bootstrap/cache/routes-v7.php'));
        $viewsCached = count(File::files(storage_path('framework/views'))) > 0;
        
        $this->line('   Config cached: ' . ($configCached ? '✅ Yes' : '❌ No'));
        $this->line('   Routes cached: ' . ($routesCached ? '✅ Yes' : '❌ No'));
        $this->line('   Views compiled: ' . ($viewsCached ? '✅ Yes' : '❌ No'));
        
        if (!$configCached && config('app.env') === 'production') {
            $recommendations[] = '✅ Jalankan: php artisan config:cache (untuk production)';
        }
        
        if (!$routesCached && config('app.env') === 'production') {
            $recommendations[] = '✅ Jalankan: php artisan route:cache (untuk production)';
        }
        $this->newLine();

        // 9. Cek Composer Autoload
        $this->info('🎼 9. COMPOSER OPTIMIZATION');
        $composerAutoload = base_path('vendor/composer/autoload_classmap.php');
        $optimized = File::exists($composerAutoload) && count(require $composerAutoload) > 0;
        
        $this->line('   Autoload optimized: ' . ($optimized ? '✅ Yes' : '❌ No'));
        
        if (!$optimized) {
            $recommendations[] = '✅ Jalankan: composer dump-autoload -o';
        }
        $this->newLine();

        // 10. Memory Usage
        $this->info('💻 10. MEMORY & PERFORMANCE');
        $this->line('   Memory limit: ' . ini_get('memory_limit'));
        $this->line('   Max execution time: ' . ini_get('max_execution_time') . 's');
        $this->line('   Current memory: ' . round(memory_get_usage() / 1024 / 1024, 2) . 'MB');
        
        if (ini_get('max_execution_time') < 60) {
            $this->warn('   ⚠️  Max execution time sangat rendah');
        }
        $this->newLine();

        // Summary
        $this->info('📊 SUMMARY');
        $this->info('==========');
        
        if (count($issues) > 0) {
            $this->error('🔴 MASALAH DITEMUKAN (' . count($issues) . '):');
            foreach ($issues as $issue) {
                $this->line('   ' . $issue);
            }
            $this->newLine();
        } else {
            $this->info('✅ Tidak ada masalah kritis ditemukan!');
            $this->newLine();
        }

        if (count($recommendations) > 0) {
            $this->warn('💡 REKOMENDASI (' . count($recommendations) . '):');
            foreach ($recommendations as $rec) {
                $this->line('   ' . $rec);
            }
            $this->newLine();
        }

        // Performance Score
        $score = 100 - (count($issues) * 15);
        $score = max(0, $score);
        
        $this->newLine();
        if ($score >= 80) {
            $this->info('🎯 PERFORMANCE SCORE: ' . $score . '/100 - BAGUS');
        } elseif ($score >= 60) {
            $this->warn('🎯 PERFORMANCE SCORE: ' . $score . '/100 - PERLU PERBAIKAN');
        } else {
            $this->error('🎯 PERFORMANCE SCORE: ' . $score . '/100 - KRITIS!');
        }

        return Command::SUCCESS;
    }
}
