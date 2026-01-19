<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $nagari_name
 * @property string $slug
 * @property string|null $tagline
 * @property string|null $about
 * @property string|null $vision
 * @property string|null $mission
 * @property string|null $values
 * @property string|null $history
 * @property string|null $logo
 * @property string|null $banner
 * @property array<array-key, mixed>|null $images
 * @property string|null $legal_entity_number
 * @property \Illuminate\Support\Carbon|null $established_date
 * @property string|null $notary_name
 * @property string|null $deed_number
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $website
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $tiktok
 * @property string|null $whatsapp
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property array<array-key, mixed>|null $operating_hours
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereDeedNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereEstablishedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereLegalEntityNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereMission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereNagariName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereNotaryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereOperatingHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereTiktok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereVision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile whereYoutube($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BumnagProfile withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBumnagProfile {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $type
 * @property string|null $icon
 * @property string|null $color
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Promotion> $promotions
 * @property-read int|null $promotions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reports
 * @property-read int|null $reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCategory {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $subject
 * @property string $message
 * @property string $status
 * @property string|null $reply
 * @property \Illuminate\Support\Carbon|null $replied_at
 * @property int|null $replied_by
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $repliedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact new()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact read()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact recent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact replied()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereRepliedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereRepliedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperContact {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $file_path
 * @property string $file_type
 * @property string|null $mime_type
 * @property int|null $file_size
 * @property string $type
 * @property string|null $album
 * @property \Illuminate\Support\Carbon|null $taken_date
 * @property string|null $photographer
 * @property string|null $location
 * @property bool $is_featured
 * @property int $order
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery images()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery inAlbum($album)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery videos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereAlbum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery wherePhotographer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereTakenDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGallery {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $category_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $content
 * @property string|null $featured_image
 * @property array<array-key, mixed>|null $images
 * @property string $status
 * @property bool $is_featured
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read mixed $reading_time
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News draft()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNews {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $category_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $description
 * @property string|null $featured_image
 * @property array<array-key, mixed>|null $images
 * @property numeric|null $original_price
 * @property numeric|null $discount_price
 * @property int|null $discount_percentage
 * @property string $promotion_type
 * @property string|null $contact_person
 * @property string|null $contact_phone
 * @property string|null $contact_email
 * @property string|null $location
 * @property string|null $terms_conditions
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string $status
 * @property bool $is_featured
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read mixed $is_active
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion expired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPromotion {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $category_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $type
 * @property string $period
 * @property int $year
 * @property int|null $month
 * @property int|null $quarter
 * @property string|null $file_path
 * @property string|null $file_type
 * @property int|null $file_size
 * @property string|null $cover_image
 * @property string|null $content
 * @property string $status
 * @property int $downloads
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report ofYear($year)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDownloads($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereQuarter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReport {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $type
 * @property string $group
 * @property string|null $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting inGroup($group)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSetting {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $position
 * @property string|null $division
 * @property string|null $bio
 * @property string|null $photo
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $twitter
 * @property string|null $linkedin
 * @property int $order
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember byPosition($position)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamMember withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTeamMember {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

