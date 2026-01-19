<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Models\Category;
use App\Models\Report;
use App\Models\Promotion;
use App\Models\Gallery;
use App\Models\TeamMember;
use Illuminate\Support\Facades\DB;

class TestDatabasePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:db-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test database performance setelah optimasi indexes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 TESTING PERFORMA DATABASE SETELAH OPTIMASI');
        $this->info('==============================================');
        $this->newLine();

        $times = [];

        // Test 1: List News dengan filter dan eager loading
        $this->info('📰 Test 1: List Published News (dengan eager loading)');
        DB::flushQueryLog();
        $start = microtime(true);
        $news = News::with('category', 'user')
            ->published()
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();
        $end = microtime(true);
        $time1 = round(($end - $start) * 1000, 2);
        $times[] = $time1;
        $this->line("   Hasil: {$news->count()} berita");
        $this->line("   Waktu: <fg=green>{$time1}ms</>");
        $this->newLine();

        // Test 2: Filter News by Category
        $this->info('📂 Test 2: Filter News by Category');
        $start = microtime(true);
        $category = Category::where('type', 'news')->first();
        if ($category) {
            $news = News::where('category_id', $category->id)
                ->where('status', 'published')
                ->orderBy('published_at', 'desc')
                ->limit(10)
                ->get();
            $end = microtime(true);
            $time2 = round(($end - $start) * 1000, 2);
            $times[] = $time2;
            $this->line("   Hasil: {$news->count()} berita");
            $this->line("   Waktu: <fg=green>{$time2}ms</>");
        } else {
            $this->line("   Skip - tidak ada kategori");
            $time2 = 0;
        }
        $this->newLine();

        // Test 3: Full-text Search
        $this->info('🔍 Test 3: Full-text Search News');
        $start = microtime(true);
        try {
            $searchResults = News::whereRaw('MATCH(title, excerpt, meta_keywords) AGAINST(? IN NATURAL LANGUAGE MODE)', ['berita'])
                ->limit(10)
                ->get();
            $end = microtime(true);
            $time3 = round(($end - $start) * 1000, 2);
            $times[] = $time3;
            $this->line("   Hasil: {$searchResults->count()} berita");
            $this->line("   Waktu: <fg=green>{$time3}ms</>");
        } catch (\Exception $e) {
            $this->line("   Skip - Error: " . $e->getMessage());
            $time3 = 0;
        }
        $this->newLine();

        // Test 4: Filter Reports by Year dan Type
        $this->info('📊 Test 4: Filter Reports by Year & Type');
        $start = microtime(true);
        $reports = Report::where('type', 'financial')
            ->where('year', date('Y'))
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();
        $end = microtime(true);
        $time4 = round(($end - $start) * 1000, 2);
        $times[] = $time4;
        $this->line("   Hasil: {$reports->count()} laporan");
        $this->line("   Waktu: <fg=green>{$time4}ms</>");
        $this->newLine();

        // Test 5: Active Promotions
        $this->info('🎁 Test 5: Active Promotions');
        $start = microtime(true);
        $promotions = Promotion::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with('category')
            ->orderBy('discount_percentage', 'desc')
            ->get();
        $end = microtime(true);
        $time5 = round(($end - $start) * 1000, 2);
        $times[] = $time5;
        $this->line("   Hasil: {$promotions->count()} promosi");
        $this->line("   Waktu: <fg=green>{$time5}ms</>");
        $this->newLine();

        // Test 6: Active Team Members
        $this->info('👥 Test 6: Active Team Members');
        $start = microtime(true);
        $team = TeamMember::where('is_active', true)
            ->orderBy('order')
            ->get();
        $end = microtime(true);
        $time6 = round(($end - $start) * 1000, 2);
        $times[] = $time6;
        $this->line("   Hasil: {$team->count()} anggota tim");
        $this->line("   Waktu: <fg=green>{$time6}ms</>");
        $this->newLine();

        // Test 7: Complex Query - Featured News dengan View Count
        $this->info('🔥 Test 7: Complex Query - Top Viewed Featured News');
        $start = microtime(true);
        $topNews = News::with('category')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->where('published_at', '<=', now())
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();
        $end = microtime(true);
        $time7 = round(($end - $start) * 1000, 2);
        $times[] = $time7;
        $this->line("   Hasil: {$topNews->count()} berita populer");
        $this->line("   Waktu: <fg=green>{$time7}ms</>");
        $this->newLine();

        // Summary
        $this->info('📈 SUMMARY PERFORMA');
        $this->info('===================');
        $this->line("Test 1 (List News): <fg=cyan>{$time1}ms</>");
        $this->line("Test 2 (Filter by Category): <fg=cyan>{$time2}ms</>");
        $this->line("Test 3 (Full-text Search): <fg=cyan>{$time3}ms</>");
        $this->line("Test 4 (Filter Reports): <fg=cyan>{$time4}ms</>");
        $this->line("Test 5 (Active Promotions): <fg=cyan>{$time5}ms</>");
        $this->line("Test 6 (Team Members): <fg=cyan>{$time6}ms</>");
        $this->line("Test 7 (Complex Query): <fg=cyan>{$time7}ms</>");

        $total = array_sum($times);
        $average = count($times) > 0 ? round($total / count($times), 2) : 0;

        $this->newLine();
        $this->line("✅ Total Time: <fg=yellow>{$total}ms</>");
        $this->line("✅ Average Time: <fg=yellow>{$average}ms</> per query");

        if ($average < 50) {
            $this->newLine();
            $this->info('🎉 EXCELLENT! Performa sangat baik!');
        } elseif ($average < 100) {
            $this->newLine();
            $this->info('👍 GOOD! Performa sudah optimal.');
        } elseif ($average < 200) {
            $this->newLine();
            $this->warn('⚠️  MODERATE! Masih bisa ditingkatkan.');
        } else {
            $this->newLine();
            $this->error('❌ SLOW! Perlu optimasi lebih lanjut.');
        }

        $this->newLine();
        $this->info('💡 Tips untuk performa lebih baik:');
        $this->line('   - Gunakan eager loading untuk relasi');
        $this->line('   - Implementasi caching untuk data yang sering diakses');
        $this->line('   - Gunakan select() untuk ambil kolom spesifik saja');
        $this->line('   - Implementasi pagination untuk data banyak');
        $this->line('   - Pertimbangkan Redis untuk production');

        return Command::SUCCESS;
    }
}
