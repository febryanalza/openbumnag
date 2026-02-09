<?php

namespace App\Helpers;

class WhatsAppHelper
{
    /**
     * Format nomor telepon ke format WhatsApp wa.me
     * 
     * @param string|null $phoneNumber
     * @return string
     */
    public static function formatWhatsAppNumber(?string $phoneNumber): string
    {
        if (empty($phoneNumber)) {
            return '';
        }

        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Handle empty result
        if (empty($cleaned)) {
            return '';
        }

        // Convert to international format
        // If starts with 0, replace with 62 (Indonesia)
        if (substr($cleaned, 0, 1) === '0') {
            $cleaned = '62' . substr($cleaned, 1);
        }
        
        // If doesn't start with country code, add 62
        if (substr($cleaned, 0, 2) !== '62') {
            $cleaned = '62' . $cleaned;
        }

        return $cleaned;
    }

    /**
     * Generate WhatsApp chat link (wa.me)
     * 
     * @param string|null $phoneNumber
     * @param string|null $message
     * @return string
     */
    public static function generateWhatsAppLink(?string $phoneNumber, ?string $message = null): string
    {
        $formatted = self::formatWhatsAppNumber($phoneNumber);
        
        if (empty($formatted)) {
            return '#';
        }

        $url = "https://wa.me/{$formatted}";

        if (!empty($message)) {
            $url .= '?text=' . urlencode($message);
        }

        return $url;
    }

    /**
     * Generate WhatsApp API link (api.whatsapp.com)
     * 
     * @param string|null $phoneNumber
     * @param string|null $message
     * @return string
     */
    public static function generateWhatsAppApiLink(?string $phoneNumber, ?string $message = null): string
    {
        $formatted = self::formatWhatsAppNumber($phoneNumber);
        
        if (empty($formatted)) {
            return '#';
        }

        $url = "https://api.whatsapp.com/send?phone={$formatted}";

        if (!empty($message)) {
            $url .= '&text=' . urlencode($message);
        }

        return $url;
    }

    /**
     * Validate if number is valid WhatsApp format
     * 
     * @param string|null $phoneNumber
     * @return bool
     */
    public static function isValidWhatsAppNumber(?string $phoneNumber): bool
    {
        if (empty($phoneNumber)) {
            return false;
        }

        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Must have at least 10 digits
        return strlen($cleaned) >= 10;
    }

    /**
     * Display format (for showing to users)
     * 
     * @param string|null $phoneNumber
     * @return string
     */
    public static function displayFormat(?string $phoneNumber): string
    {
        if (empty($phoneNumber)) {
            return '';
        }

        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Format: 0812-3456-7890
        if (substr($cleaned, 0, 1) === '0' && strlen($cleaned) >= 10) {
            return substr($cleaned, 0, 4) . '-' . 
                   substr($cleaned, 4, 4) . '-' . 
                   substr($cleaned, 8);
        }

        // Format: +62 812-3456-7890
        if (substr($cleaned, 0, 2) === '62' && strlen($cleaned) >= 11) {
            return '+62 ' . 
                   substr($cleaned, 2, 3) . '-' . 
                   substr($cleaned, 5, 4) . '-' . 
                   substr($cleaned, 9);
        }

        return $phoneNumber;
    }
}
