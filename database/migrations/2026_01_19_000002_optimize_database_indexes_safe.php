<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Helper function to check if index exists
        $indexExists = function ($table, $indexName) {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        };

        // Optimasi Categories Table
        Schema::table('categories', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('categories', 'categories_type_index')) {
                $table->index('type');
            }
            if (!$indexExists('categories', 'categories_is_active_index')) {
                $table->index('is_active');
            }
            if (!$indexExists('categories', 'categories_order_index')) {
                $table->index('order');
            }
            if (!$indexExists('categories', 'categories_type_is_active_order_index')) {
                $table->index(['type', 'is_active', 'order']);
            }
        });

        // Optimasi News Table
        Schema::table('news', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('news', 'news_title_index')) {
                $table->index('title');
            }
            if (!$indexExists('news', 'news_slug_index')) {
                $table->index('slug');
            }
            if (!$indexExists('news', 'news_created_at_index')) {
                $table->index('created_at');
            }
            if (!$indexExists('news', 'news_status_is_featured_published_at_index')) {
                $table->index(['status', 'is_featured', 'published_at']);
            }
            if (!$indexExists('news', 'news_category_id_status_published_at_index')) {
                $table->index(['category_id', 'status', 'published_at']);
            }
        });

        // Full-text search index untuk News (MySQL only)
        if (config('database.default') === 'mysql' && !$indexExists('news', 'search_index')) {
            DB::statement('ALTER TABLE news ADD FULLTEXT search_index (title, excerpt, meta_keywords)');
        }

        // Optimasi Reports Table
        Schema::table('reports', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('reports', 'reports_title_index')) {
                $table->index('title');
            }
            if (!$indexExists('reports', 'reports_created_at_index')) {
                $table->index('created_at');
            }
            if (!$indexExists('reports', 'reports_category_id_type_year_index')) {
                $table->index(['category_id', 'type', 'year']);
            }
            if (!$indexExists('reports', 'reports_status_published_at_index')) {
                $table->index(['status', 'published_at']);
            }
            if (!$indexExists('reports', 'reports_year_month_index')) {
                $table->index(['year', 'month']);
            }
            if (!$indexExists('reports', 'reports_year_quarter_index')) {
                $table->index(['year', 'quarter']);
            }
        });

        // Optimasi Promotions Table
        Schema::table('promotions', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('promotions', 'promotions_title_index')) {
                $table->index('title');
            }
            if (!$indexExists('promotions', 'promotions_created_at_index')) {
                $table->index('created_at');
            }
            if (!$indexExists('promotions', 'promotions_status_is_featured_index')) {
                $table->index(['status', 'is_featured']);
            }
            if (!$indexExists('promotions', 'promotions_category_id_status_promotion_type_index')) {
                $table->index(['category_id', 'status', 'promotion_type']);
            }
            if (!$indexExists('promotions', 'promotions_discount_percentage_index')) {
                $table->index('discount_percentage');
            }
        });

        // Optimasi BumnagProfiles Table
        Schema::table('bumnag_profiles', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('bumnag_profiles', 'bumnag_profiles_is_active_index')) {
                $table->index('is_active');
            }
            if (!$indexExists('bumnag_profiles', 'bumnag_profiles_nagari_name_index')) {
                $table->index('nagari_name');
            }
        });

        // Optimasi Galleries Table
        Schema::table('galleries', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('galleries', 'galleries_file_type_index')) {
                $table->index('file_type');
            }
            if (!$indexExists('galleries', 'galleries_created_at_index')) {
                $table->index('created_at');
            }
            if (!$indexExists('galleries', 'galleries_type_album_is_featured_index')) {
                $table->index(['type', 'album', 'is_featured']);
            }
            if (!$indexExists('galleries', 'galleries_file_type_is_featured_index')) {
                $table->index(['file_type', 'is_featured']);
            }
        });

        // Optimasi TeamMembers Table
        Schema::table('team_members', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('team_members', 'team_members_division_index')) {
                $table->index('division');
            }
            if (!$indexExists('team_members', 'team_members_is_active_order_index')) {
                $table->index(['is_active', 'order']);
            }
        });

        // Optimasi Settings Table
        Schema::table('settings', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('settings', 'settings_group_index')) {
                $table->index('group');
            }
            if (!$indexExists('settings', 'settings_group_order_index')) {
                $table->index(['group', 'order']);
            }
        });

        // Optimasi Contacts Table
        Schema::table('contacts', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('contacts', 'contacts_status_index')) {
                $table->index('status');
            }
            if (!$indexExists('contacts', 'contacts_email_index')) {
                $table->index('email');
            }
            if (!$indexExists('contacts', 'contacts_created_at_index')) {
                $table->index('created_at');
            }
            if (!$indexExists('contacts', 'contacts_status_created_at_index')) {
                $table->index(['status', 'created_at']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Helper function untuk drop index jika ada
        $dropIndexIfExists = function ($table, $indexName) {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            if (count($indexes) > 0) {
                DB::statement("ALTER TABLE {$table} DROP INDEX {$indexName}");
            }
        };

        // Drop semua index yang ditambahkan
        $dropIndexIfExists('categories', 'categories_type_index');
        $dropIndexIfExists('categories', 'categories_is_active_index');
        $dropIndexIfExists('categories', 'categories_order_index');
        $dropIndexIfExists('categories', 'categories_type_is_active_order_index');

        $dropIndexIfExists('news', 'news_title_index');
        $dropIndexIfExists('news', 'news_slug_index');
        $dropIndexIfExists('news', 'news_created_at_index');
        $dropIndexIfExists('news', 'news_status_is_featured_published_at_index');
        $dropIndexIfExists('news', 'news_category_id_status_published_at_index');
        $dropIndexIfExists('news', 'search_index');

        $dropIndexIfExists('reports', 'reports_title_index');
        $dropIndexIfExists('reports', 'reports_created_at_index');
        $dropIndexIfExists('reports', 'reports_category_id_type_year_index');
        $dropIndexIfExists('reports', 'reports_status_published_at_index');
        $dropIndexIfExists('reports', 'reports_year_month_index');
        $dropIndexIfExists('reports', 'reports_year_quarter_index');

        $dropIndexIfExists('promotions', 'promotions_title_index');
        $dropIndexIfExists('promotions', 'promotions_created_at_index');
        $dropIndexIfExists('promotions', 'promotions_status_is_featured_index');
        $dropIndexIfExists('promotions', 'promotions_category_id_status_promotion_type_index');
        $dropIndexIfExists('promotions', 'promotions_discount_percentage_index');

        $dropIndexIfExists('bumnag_profiles', 'bumnag_profiles_is_active_index');
        $dropIndexIfExists('bumnag_profiles', 'bumnag_profiles_nagari_name_index');

        $dropIndexIfExists('galleries', 'galleries_file_type_index');
        $dropIndexIfExists('galleries', 'galleries_created_at_index');
        $dropIndexIfExists('galleries', 'galleries_type_album_is_featured_index');
        $dropIndexIfExists('galleries', 'galleries_file_type_is_featured_index');

        $dropIndexIfExists('team_members', 'team_members_division_index');
        $dropIndexIfExists('team_members', 'team_members_is_active_order_index');

        $dropIndexIfExists('settings', 'settings_group_index');
        $dropIndexIfExists('settings', 'settings_group_order_index');

        $dropIndexIfExists('contacts', 'contacts_status_index');
        $dropIndexIfExists('contacts', 'contacts_email_index');
        $dropIndexIfExists('contacts', 'contacts_created_at_index');
        $dropIndexIfExists('contacts', 'contacts_status_created_at_index');
    }
};
