#!/bin/bash

################################################################################
# Script Verifikasi PHP 8.1 dan Laravel Requirements
# Project: BUMNag
# Author: Auto-generated
# Date: 2026-02-06
################################################################################

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Symbols
SUCCESS="✅"
FAIL="❌"
WARNING="⚠️ "
INFO="ℹ️ "

echo -e "${BLUE}======================================================================"
echo -e "  🔍 Verifikasi Requirements BUMNag Laravel Project"
echo -e "======================================================================${NC}\n"

# Function to check command exists
command_exists() {
    command -v "$1" &> /dev/null
}

# Counter
PASSED=0
FAILED=0

################################################################################
# 1. CEK VERSI PHP
################################################################################
echo -e "${BLUE}[1/10] Checking PHP Version...${NC}"

if command_exists php; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
    PHP_MINOR=$(php -r "echo PHP_MINOR_VERSION;")
    
    echo -e "   Current PHP Version: ${GREEN}${PHP_VERSION}${NC}"
    
    if [ "$PHP_MAJOR" -eq 8 ] && [ "$PHP_MINOR" -ge 1 ]; then
        echo -e "   ${SUCCESS} PHP Version Compatible (>= 8.1)"
        ((PASSED++))
    else
        echo -e "   ${FAIL} PHP Version NOT Compatible (Required: >= 8.1, Current: ${PHP_VERSION})"
        echo -e "   ${INFO} Run: sudo apt-get install php8.1"
        ((FAILED++))
    fi
else
    echo -e "   ${FAIL} PHP not found in PATH"
    echo -e "   ${INFO} Install PHP 8.1 first"
    ((FAILED++))
fi
echo ""

################################################################################
# 2. CEK PHP CLI vs FPM
################################################################################
echo -e "${BLUE}[2/10] Checking PHP CLI vs PHP-FPM...${NC}"

if command_exists php-fpm8.1; then
    FPM_VERSION=$(php-fpm8.1 -v | head -n1 | cut -d' ' -f2)
    echo -e "   PHP-FPM Version: ${GREEN}${FPM_VERSION}${NC}"
    
    if [ "$PHP_VERSION" == "$FPM_VERSION" ]; then
        echo -e "   ${SUCCESS} PHP CLI and FPM versions match"
        ((PASSED++))
    else
        echo -e "   ${WARNING} PHP CLI (${PHP_VERSION}) and FPM (${FPM_VERSION}) versions differ"
        echo -e "   ${INFO} Consider using same version for consistency"
        ((PASSED++))
    fi
elif command_exists php-fpm; then
    echo -e "   ${SUCCESS} PHP-FPM detected (generic)"
    ((PASSED++))
else
    echo -e "   ${WARNING} PHP-FPM not found (OK for CLI-only environments)"
    ((PASSED++))
fi
echo ""

################################################################################
# 3. CEK PHP EXTENSIONS
################################################################################
echo -e "${BLUE}[3/10] Checking PHP Extensions...${NC}"

REQUIRED_EXTENSIONS=(
    "mbstring"
    "xml"
    "curl"
    "zip"
    "gd"
    "pdo"
    "pdo_mysql"
    "openssl"
    "tokenizer"
    "json"
    "bcmath"
    "ctype"
    "fileinfo"
)

MISSING_EXTENSIONS=()
for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if php -m | grep -i "^${ext}$" > /dev/null; then
        echo -e "   ${SUCCESS} ${ext}"
    else
        echo -e "   ${FAIL} ${ext} - NOT INSTALLED"
        MISSING_EXTENSIONS+=("$ext")
    fi
done

if [ ${#MISSING_EXTENSIONS[@]} -eq 0 ]; then
    echo -e "   ${SUCCESS} All required extensions installed"
    ((PASSED++))
else
    echo -e "   ${FAIL} Missing extensions: ${MISSING_EXTENSIONS[*]}"
    echo -e "   ${INFO} Install with: sudo apt-get install $(printf 'php8.1-%s ' "${MISSING_EXTENSIONS[@]}")"
    ((FAILED++))
fi
echo ""

################################################################################
# 4. CEK COMPOSER
################################################################################
echo -e "${BLUE}[4/10] Checking Composer...${NC}"

if command_exists composer; then
    COMPOSER_VERSION=$(composer --version 2>/dev/null | grep -oP 'Composer version \K[0-9.]+')
    echo -e "   Composer Version: ${GREEN}${COMPOSER_VERSION}${NC}"
    
    # Check if composer uses correct PHP
    COMPOSER_PHP=$(composer --version 2>/dev/null | grep -oP 'PHP version \K[0-9.]+')
    echo -e "   Composer PHP Version: ${GREEN}${COMPOSER_PHP}${NC}"
    
    if [[ "$COMPOSER_PHP" == 8.1.* ]]; then
        echo -e "   ${SUCCESS} Composer using PHP 8.1"
        ((PASSED++))
    else
        echo -e "   ${WARNING} Composer using PHP ${COMPOSER_PHP} (Project requires 8.1)"
        echo -e "   ${INFO} Set PHP_PATH or reinstall composer with PHP 8.1"
        ((PASSED++))
    fi
else
    echo -e "   ${FAIL} Composer not found"
    echo -e "   ${INFO} Install from: https://getcomposer.org/download/"
    ((FAILED++))
fi
echo ""

################################################################################
# 5. CEK LARAVEL PROJECT
################################################################################
echo -e "${BLUE}[5/10] Checking Laravel Project...${NC}"

if [ -f "artisan" ]; then
    echo -e "   ${SUCCESS} Laravel artisan found"
    
    if [ -f "composer.json" ]; then
        LARAVEL_VERSION=$(php artisan --version 2>/dev/null | grep -oP 'Laravel Framework \K[0-9.]+')
        if [ -n "$LARAVEL_VERSION" ]; then
            echo -e "   Laravel Version: ${GREEN}${LARAVEL_VERSION}${NC}"
            echo -e "   ${SUCCESS} Laravel is bootable"
            ((PASSED++))
        else
            echo -e "   ${WARNING} Cannot detect Laravel version"
            ((PASSED++))
        fi
    else
        echo -e "   ${FAIL} composer.json not found"
        ((FAILED++))
    fi
else
    echo -e "   ${FAIL} Not in Laravel project root (artisan not found)"
    echo -e "   ${INFO} Run this script from Laravel project root"
    ((FAILED++))
fi
echo ""

################################################################################
# 6. CEK VENDOR DEPENDENCIES
################################################################################
echo -e "${BLUE}[6/10] Checking Vendor Dependencies...${NC}"

if [ -d "vendor" ]; then
    echo -e "   ${SUCCESS} Vendor folder exists"
    
    if [ -f "vendor/autoload.php" ]; then
        echo -e "   ${SUCCESS} Autoload file exists"
        ((PASSED++))
    else
        echo -e "   ${FAIL} Autoload file missing"
        echo -e "   ${INFO} Run: composer install"
        ((FAILED++))
    fi
else
    echo -e "   ${FAIL} Vendor folder not found"
    echo -e "   ${INFO} Run: composer install --no-dev --optimize-autoloader"
    ((FAILED++))
fi
echo ""

################################################################################
# 7. CEK .ENV FILE
################################################################################
echo -e "${BLUE}[7/10] Checking Environment Configuration...${NC}"

if [ -f ".env" ]; then
    echo -e "   ${SUCCESS} .env file exists"
    
    # Check APP_KEY
    if grep -q "APP_KEY=base64:" .env; then
        echo -e "   ${SUCCESS} APP_KEY is set"
        ((PASSED++))
    else
        echo -e "   ${WARNING} APP_KEY not set or invalid"
        echo -e "   ${INFO} Run: php artisan key:generate"
        ((PASSED++))
    fi
else
    echo -e "   ${FAIL} .env file not found"
    echo -e "   ${INFO} Copy .env.example to .env and configure"
    ((FAILED++))
fi
echo ""

################################################################################
# 8. CEK PERMISSIONS
################################################################################
echo -e "${BLUE}[8/10] Checking Directory Permissions...${NC}"

PERM_OK=true

if [ -d "storage" ]; then
    if [ -w "storage" ]; then
        echo -e "   ${SUCCESS} storage/ is writable"
    else
        echo -e "   ${FAIL} storage/ is not writable"
        echo -e "   ${INFO} Run: chmod -R 775 storage"
        PERM_OK=false
    fi
else
    echo -e "   ${FAIL} storage/ not found"
    PERM_OK=false
fi

if [ -d "bootstrap/cache" ]; then
    if [ -w "bootstrap/cache" ]; then
        echo -e "   ${SUCCESS} bootstrap/cache/ is writable"
    else
        echo -e "   ${FAIL} bootstrap/cache/ is not writable"
        echo -e "   ${INFO} Run: chmod -R 775 bootstrap/cache"
        PERM_OK=false
    fi
else
    echo -e "   ${FAIL} bootstrap/cache/ not found"
    PERM_OK=false
fi

if [ "$PERM_OK" = true ]; then
    ((PASSED++))
else
    ((FAILED++))
fi
echo ""

################################################################################
# 9. CEK DATABASE CONNECTION (Optional)
################################################################################
echo -e "${BLUE}[9/10] Checking Database Connection...${NC}"

if [ -f ".env" ]; then
    DB_TEST=$(php artisan db:show 2>&1)
    if echo "$DB_TEST" | grep -q "Connection"; then
        echo -e "   ${SUCCESS} Database connection successful"
        ((PASSED++))
    else
        echo -e "   ${WARNING} Cannot verify database connection"
        echo -e "   ${INFO} Make sure database credentials are correct in .env"
        ((PASSED++))
    fi
else
    echo -e "   ${WARNING} Skipped (no .env file)"
    ((PASSED++))
fi
echo ""

################################################################################
# 10. CEK COMPOSER PLATFORM REQUIREMENTS
################################################################################
echo -e "${BLUE}[10/10] Checking Composer Platform Requirements...${NC}"

if command_exists composer && [ -f "composer.json" ]; then
    PLATFORM_CHECK=$(composer check-platform-reqs 2>&1)
    
    if echo "$PLATFORM_CHECK" | grep -q "success"; then
        echo -e "   ${SUCCESS} All platform requirements met"
        ((PASSED++))
    else
        echo -e "   ${FAIL} Some platform requirements not met:"
        echo "$PLATFORM_CHECK" | grep -v "^Checking" | grep -v "^$"
        ((FAILED++))
    fi
else
    echo -e "   ${WARNING} Skipped (composer not available)"
    ((PASSED++))
fi
echo ""

################################################################################
# SUMMARY
################################################################################
echo -e "${BLUE}======================================================================"
echo -e "  📊 VERIFICATION SUMMARY"
echo -e "======================================================================${NC}\n"

TOTAL=$((PASSED + FAILED))
echo -e "   Total Checks: ${TOTAL}"
echo -e "   ${GREEN}Passed: ${PASSED}${NC}"
echo -e "   ${RED}Failed: ${FAILED}${NC}"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}${SUCCESS} ALL CHECKS PASSED! ${SUCCESS}"
    echo -e "   Project is ready for deployment.${NC}"
    echo ""
    exit 0
else
    echo -e "${RED}${FAIL} SOME CHECKS FAILED ${FAIL}"
    echo -e "   Please fix the issues above before deployment.${NC}"
    echo ""
    exit 1
fi
