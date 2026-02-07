#!/bin/bash

################################################################################
# Script Setup & Deploy BUMNag ke Server dengan PHP 8.1
# Author: Auto-generated
# Date: 2026-02-06
################################################################################

set -e  # Exit on error

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Functions
print_header() {
    echo -e "\n${BLUE}======================================================================"
    echo -e "  $1"
    echo -e "======================================================================${NC}\n"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Check if running as root
if [ "$EUID" -eq 0 ]; then 
    print_warning "Please do not run as root. Run as your user account."
    exit 1
fi

print_header "🚀 BUMNag Laravel Deployment Script (PHP 8.1)"

################################################################################
# 1. VERIFY PHP 8.1
################################################################################
print_header "Step 1: Verifying PHP 8.1"

PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
PHP_MINOR=$(php -r "echo PHP_MINOR_VERSION;")

echo "Current PHP Version: $PHP_VERSION"

if [ "$PHP_MAJOR" -ne 8 ] || [ "$PHP_MINOR" -lt 1 ]; then
    print_error "PHP 8.1+ is required. Current version: $PHP_VERSION"
    print_info "Please install PHP 8.1 first:"
    echo "   sudo apt-get install php8.1 php8.1-cli php8.1-fpm"
    echo "   OR follow instructions in INSTALASI_PHP_8.1.md"
    exit 1
fi

print_success "PHP version OK: $PHP_VERSION"

################################################################################
# 2. CHECK REQUIRED EXTENSIONS
################################################################################
print_header "Step 2: Checking PHP Extensions"

REQUIRED_EXTS="mbstring xml curl zip gd pdo pdo_mysql openssl tokenizer json bcmath"
MISSING=""

for ext in $REQUIRED_EXTS; do
    if php -m | grep -qi "^${ext}$"; then
        echo "✓ $ext"
    else
        echo "✗ $ext - MISSING"
        MISSING="$MISSING php8.1-$ext"
    fi
done

if [ -n "$MISSING" ]; then
    print_error "Missing extensions detected"
    print_info "Install with: sudo apt-get install $MISSING"
    exit 1
fi

print_success "All required extensions installed"

################################################################################
# 3. CHECK COMPOSER
################################################################################
print_header "Step 3: Checking Composer"

if ! command -v composer &> /dev/null; then
    print_error "Composer not found"
    print_info "Install from: https://getcomposer.org/download/"
    exit 1
fi

COMPOSER_VERSION=$(composer --version 2>&1 | grep -oP 'Composer version \K[0-9.]+' || echo "unknown")
print_success "Composer installed: $COMPOSER_VERSION"

################################################################################
# 4. BACKUP EXISTING FILES (if any)
################################################################################
print_header "Step 4: Backup (if needed)"

if [ -f ".env" ]; then
    BACKUP_DIR="backups/$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$BACKUP_DIR"
    cp .env "$BACKUP_DIR/.env.backup"
    print_success "Backed up .env to $BACKUP_DIR"
else
    print_info "No .env file to backup (first time setup)"
fi

################################################################################
# 5. CLEAN OLD DEPENDENCIES
################################################################################
print_header "Step 5: Cleaning Old Dependencies"

if [ -d "vendor" ]; then
    print_info "Removing old vendor folder..."
    rm -rf vendor
    print_success "Vendor folder removed"
fi

if [ -f "composer.lock" ]; then
    print_info "Removing composer.lock..."
    rm composer.lock
    print_success "composer.lock removed"
fi

################################################################################
# 6. INSTALL DEPENDENCIES WITH PHP 8.1
################################################################################
print_header "Step 6: Installing Dependencies (PHP 8.1)"

print_info "Running: composer install --no-dev --optimize-autoloader"
if command -v php8.1 &> /dev/null; then
    # Explicitly use PHP 8.1 if available
    /usr/bin/php8.1 $(which composer) install --no-dev --optimize-autoloader --no-interaction
else
    # Use default PHP (should be 8.1 after verification)
    composer install --no-dev --optimize-autoloader --no-interaction
fi

print_success "Dependencies installed successfully"

################################################################################
# 7. SETUP .ENV
################################################################################
print_header "Step 7: Environment Configuration"

if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        print_success ".env created from .env.example"
        print_warning "IMPORTANT: Edit .env file with your database credentials!"
        print_info "Run: nano .env"
    else
        print_error ".env.example not found"
        exit 1
    fi
else
    print_info ".env already exists (using existing)"
fi

################################################################################
# 8. GENERATE APP KEY
################################################################################
print_header "Step 8: Generating Application Key"

if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate --force
    print_success "APP_KEY generated"
else
    print_info "APP_KEY already exists"
fi

################################################################################
# 9. SET PERMISSIONS
################################################################################
print_header "Step 9: Setting Permissions"

# Detect web server user
if id "www-data" &>/dev/null; then
    WEB_USER="www-data"
elif id "apache" &>/dev/null; then
    WEB_USER="apache"
elif id "nginx" &>/dev/null; then
    WEB_USER="nginx"
else
    WEB_USER=$(whoami)
    print_warning "Web server user not detected, using current user: $WEB_USER"
fi

print_info "Setting ownership to: $WEB_USER"

# Set ownership (may require sudo)
if [ "$WEB_USER" != "$(whoami)" ]; then
    print_info "You may need to run these commands with sudo:"
    echo "   sudo chown -R $WEB_USER:$WEB_USER storage bootstrap/cache"
    echo "   sudo chmod -R 775 storage bootstrap/cache"
    print_warning "Skipping ownership change (run manually if needed)"
else
    chmod -R 775 storage bootstrap/cache
    print_success "Permissions set"
fi

################################################################################
# 10. CLEAR OLD CACHES
################################################################################
print_header "Step 10: Clearing Caches"

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

print_success "All caches cleared"

################################################################################
# 11. RUN MIGRATIONS (Optional - Ask user)
################################################################################
print_header "Step 11: Database Migration"

read -p "Do you want to run migrations? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    print_info "Running migrations..."
    php artisan migrate --force
    print_success "Migrations completed"
    
    read -p "Do you want to run seeders? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        php artisan db:seed --force
        print_success "Seeders completed"
    fi
else
    print_info "Skipped migrations"
fi

################################################################################
# 12. OPTIMIZE FOR PRODUCTION
################################################################################
print_header "Step 12: Optimizing for Production"

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

print_success "Application optimized"

################################################################################
# 13. STORAGE LINK
################################################################################
print_header "Step 13: Creating Storage Link"

if [ ! -L "public/storage" ]; then
    php artisan storage:link
    print_success "Storage link created"
else
    print_info "Storage link already exists"
fi

################################################################################
# 14. FINAL VERIFICATION
################################################################################
print_header "Step 14: Final Verification"

# Test artisan
if php artisan --version &>/dev/null; then
    LARAVEL_VERSION=$(php artisan --version | grep -oP 'Laravel Framework \K[0-9.]+')
    print_success "Laravel is working: v$LARAVEL_VERSION"
else
    print_error "Laravel artisan not working"
    exit 1
fi

# Check platform requirements
if composer check-platform-reqs &>/dev/null; then
    print_success "All platform requirements met"
else
    print_warning "Some platform requirements issues detected"
    composer check-platform-reqs
fi

################################################################################
# DEPLOYMENT COMPLETE
################################################################################
print_header "✅ DEPLOYMENT COMPLETE!"

echo -e "${GREEN}"
cat << "EOF"
   ____  _    _ __  __ _   _             
  |  _ \| |  | |  \/  | \ | |            
  | |_) | |  | | \  / |  \| | __ _  __ _ 
  |  _ <| |  | | |\/| | . ` |/ _` |/ _` |
  | |_) | |__| | |  | | |\  | (_| | (_| |
  |____/ \____/|_|  |_|_| \_|\__,_|\__, |
                                    __/ |
                                   |___/ 
EOF
echo -e "${NC}"

print_success "Project deployed successfully with PHP $PHP_VERSION"
echo ""
print_info "Next steps:"
echo "   1. Edit .env file with your configuration:"
echo "      nano .env"
echo ""
echo "   2. Configure your web server to point to public/ folder"
echo ""
echo "   3. If using Apache, ensure mod_rewrite is enabled"
echo "      sudo a2enmod rewrite"
echo ""
echo "   4. If using Nginx, use configuration from INSTALASI_PHP_8.1.md"
echo ""
echo "   5. Access your website:"
echo "      http://your-domain.com"
echo ""
print_warning "Remember to:"
echo "   - Set proper APP_URL in .env"
echo "   - Configure database credentials"
echo "   - Set APP_ENV=production for production servers"
echo "   - Review security settings"
echo ""

exit 0
