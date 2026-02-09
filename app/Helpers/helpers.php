<?php

use App\Helpers\WhatsAppHelper;

if (!function_exists('wa_link')) {
    /**
     * Generate WhatsApp link (wa.me)
     * 
     * @param string|null $phoneNumber
     * @param string|null $message
     * @return string
     */
    function wa_link(?string $phoneNumber, ?string $message = null): string
    {
        return WhatsAppHelper::generateWhatsAppLink($phoneNumber, $message);
    }
}

if (!function_exists('wa_number')) {
    /**
     * Format phone number to WhatsApp format (62xxx)
     * 
     * @param string|null $phoneNumber
     * @return string
     */
    function wa_number(?string $phoneNumber): string
    {
        return WhatsAppHelper::formatWhatsAppNumber($phoneNumber);
    }
}

if (!function_exists('wa_display')) {
    /**
     * Display phone number in readable format
     * 
     * @param string|null $phoneNumber
     * @return string
     */
    function wa_display(?string $phoneNumber): string
    {
        return WhatsAppHelper::displayFormat($phoneNumber);
    }
}

if (!function_exists('is_valid_wa')) {
    /**
     * Check if valid WhatsApp number
     * 
     * @param string|null $phoneNumber
     * @return bool
     */
    function is_valid_wa(?string $phoneNumber): bool
    {
        return WhatsAppHelper::isValidWhatsAppNumber($phoneNumber);
    }
}
