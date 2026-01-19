<?php

/**
 * Script untuk testing performa query setelah optimasi database
 * 
 * Cara menggunakan:
 * php artisan tinker
 * include 'test_performance.php';
 */

use App\Models\News;
use App\Models\Category;
use App\Models\Report;
use App\Models\Promotion;
use App\Models\Gallery;
use App\Models\TeamMember;
use Illuminate\Support\Facades\DB;

echo "🚀 TESTING PERFORMA DATABASE SETELAH OPTIMASI\n";
echo "==============================================\n\n";

// Enable query log
DB::enableQueryLog();

// Test 1: List News dengan filter dan eager loading
echo "📰 Test 1: List Published News (dengan eager loading)\n";
$start = microtime(true);
$news = News::with('category', 'user')
    ->published()
    ->orderBy('published_at', 'desc')
    ->limit(20)
    ->get();
$end = microtime(true);
$time1 = round(($end - $start) * 1000, 2);
echo "   Hasil: {$news->count()} berita\n";
echo "   Waktu: {$time1}ms\n";
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

// Reset query log
DB::flushQueryLog();

// Test 2: Filter News by Category
echo "📂 Test 2: Filter News by Category\n";
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
    echo "   Hasil: {$news->count()} berita\n";
    echo "   Waktu: {$time2}ms\n";
} else {
    echo "   Skip - tidak ada kategori\n";
    $time2 = 0;
}
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

DB::flushQueryLog();

// Test 3: Full-text Search
echo "🔍 Test 3: Full-text Search News\n";
$start = microtime(true);
try {
    $searchResults = News::whereRaw('MATCH(title, excerpt, meta_keywords) AGAINST(? IN NATURAL LANGUAGE MODE)', ['berita'])
        ->limit(10)
        ->get();
    $end = microtime(true);
    $time3 = round(($end - $start) * 1000, 2);
    echo "   Hasil: {$searchResults->count()} berita\n";
    echo "   Waktu: {$time3}ms\n";
} catch (\Exception $e) {
    echo "   Skip - FULLTEXT index belum aktif\n";
    $time3 = 0;
}
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

DB::flushQueryLog();

// Test 4: Filter Reports by Year dan Type
echo "📊 Test 4: Filter Reports by Year & Type\n";
$start = microtime(true);
$reports = Report::where('type', 'financial')
    ->where('year', date('Y'))
    ->where('status', 'published')
    ->orderBy('published_at', 'desc')
    ->get();
$end = microtime(true);
$time4 = round(($end - $start) * 1000, 2);
echo "   Hasil: {$reports->count()} laporan\n";
echo "   Waktu: {$time4}ms\n";
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

DB::flushQueryLog();

// Test 5: Active Promotions
echo "🎁 Test 5: Active Promotions\n";
$start = microtime(true);
$promotions = Promotion::active()
    ->featured()
    ->with('category')
    ->orderBy('discount_percentage', 'desc')
    ->get();
$end = microtime(true);
$time5 = round(($end - $start) * 1000, 2);
echo "   Hasil: {$promotions->count()} promosi\n";
echo "   Waktu: {$time5}ms\n";
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

DB::flushQueryLog();

// Test 6: Gallery by Album
echo "🖼️  Test 6: Gallery by Album\n";
$start = microtime(true);
$galleries = Gallery::inAlbum('General')
    ->images()
    ->featured()
    ->orderBy('order')
    ->get();
$end = microtime(true);
$time6 = round(($end - $start) * 1000, 2);
echo "   Hasil: {$galleries->count()} gambar\n";
echo "   Waktu: {$time6}ms\n";
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

DB::flushQueryLog();

// Test 7: Active Team Members
echo "👥 Test 7: Active Team Members\n";
$start = microtime(true);
$team = TeamMember::active()
    ->ordered()
    ->get();
$end = microtime(true);
$time7 = round(($end - $start) * 1000, 2);
echo "   Hasil: {$team->count()} anggota tim\n";
echo "   Waktu: {$time7}ms\n";
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

DB::flushQueryLog();

// Test 8: Complex Query - Featured News dengan View Count
echo "🔥 Test 8: Complex Query - Top Viewed Featured News\n";
$start = microtime(true);
$topNews = News::with('category')
    ->where('status', 'published')
    ->where('is_featured', true)
    ->where('published_at', '<=', now())
    ->orderBy('views', 'desc')
    ->limit(5)
    ->get();
$end = microtime(true);
$time8 = round(($end - $start) * 1000, 2);
echo "   Hasil: {$topNews->count()} berita populer\n";
echo "   Waktu: {$time8}ms\n";
echo "   Query: " . count(DB::getQueryLog()) . " queries\n\n";

// Summary
echo "\n📈 SUMMARY PERFORMA\n";
echo "===================\n";
echo "Test 1 (List News): {$time1}ms\n";
echo "Test 2 (Filter by Category): {$time2}ms\n";
echo "Test 3 (Full-text Search): {$time3}ms\n";
echo "Test 4 (Filter Reports): {$time4}ms\n";
echo "Test 5 (Active Promotions): {$time5}ms\n";
echo "Test 6 (Gallery): {$time6}ms\n";
echo "Test 7 (Team Members): {$time7}ms\n";
echo "Test 8 (Complex Query): {$time8}ms\n";

$total = $time1 + $time2 + $time3 + $time4 + $time5 + $time6 + $time7 + $time8;
$average = round($total / 8, 2);

echo "\n✅ Total Time: {$total}ms\n";
echo "✅ Average Time: {$average}ms per query\n";

if ($average < 50) {
    echo "\n🎉 EXCELLENT! Performa sangat baik!\n";
} elseif ($average < 100) {
    echo "\n👍 GOOD! Performa sudah optimal.\n";
} elseif ($average < 200) {
    echo "\n⚠️  MODERATE! Masih bisa ditingkatkan.\n";
} else {
    echo "\n❌ SLOW! Perlu optimasi lebih lanjut.\n";
}

echo "\n💡 Tips untuk performa lebih baik:\n";
echo "   - Gunakan eager loading untuk relasi\n";
echo "   - Implementasi caching untuk data yang sering diakses\n";
echo "   - Gunakan select() untuk ambil kolom spesifik saja\n";
echo "   - Implementasi pagination untuk data banyak\n";
echo "   - Pertimbangkan Redis untuk production\n\n";
