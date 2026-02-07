#!/bin/bash

################################################################################
# Script untuk Switch PHP Version ke 8.1
# Untuk server dengan multiple PHP versions installed
# Author: Auto-generated
# Date: 2026-02-06
################################################################################

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m'

# Functions
print_header() {
    echo -e "\n${CYAN}======================================================================"
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

################################################################################
# DETECT CURRENT PHP VERSION
################################################################################
print_header "🔍 Detecting Installed PHP Versions"

# Current default PHP
if command -v php &> /dev/null; then
    CURRENT_PHP=$(php -v | head -n1 | cut -d' ' -f2)
    echo -e "Current default PHP: ${GREEN}$CURRENT_PHP${NC}"
else
    echo -e "Current default PHP: ${RED}Not found${NC}"
fi

echo ""
echo "Available PHP versions on system:"
echo "─────────────────────────────────"

# List all PHP versions
AVAILABLE_VERSIONS=()
for version in 8.5 8.4 8.3 8.2 8.1 8.0 7.4 7.3; do
    if command -v php${version} &> /dev/null; then
        FULL_VERSION=$(php${version} -v | head -n1 | cut -d' ' -f2)
        echo -e "  • PHP ${version}: ${GREEN}${FULL_VERSION}${NC} - $(which php${version})"
        AVAILABLE_VERSIONS+=("$version")
    fi
done

if [ ${#AVAILABLE_VERSIONS[@]} -eq 0 ]; then
    print_error "No PHP versions found!"
    print_info "Install PHP 8.1 first:"
    echo "   sudo add-apt-repository ppa:ondrej/php"
    echo "   sudo apt-get update"
    echo "   sudo apt-get install php8.1"
    exit 1
fi

echo ""

################################################################################
# CHECK IF PHP 8.1 IS AVAILABLE
################################################################################
print_header "🎯 Checking PHP 8.1 Availability"

if command -v php8.1 &> /dev/null; then
    PHP81_VERSION=$(php8.1 -v | head -n1 | cut -d' ' -f2)
    print_success "PHP 8.1 is installed: $PHP81_VERSION"
    PHP81_PATH=$(which php8.1)
    echo "   Location: $PHP81_PATH"
else
    print_error "PHP 8.1 is NOT installed"
    print_info "Install with:"
    echo ""
    echo "   # Ubuntu/Debian:"
    echo "   sudo add-apt-repository ppa:ondrej/php -y"
    echo "   sudo apt-get update"
    echo "   sudo apt-get install -y php8.1 php8.1-cli php8.1-fpm \\"
    echo "       php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl \\"
    echo "       php8.1-zip php8.1-gd php8.1-intl php8.1-bcmath"
    echo ""
    echo "   # CentOS/RHEL:"
    echo "   sudo dnf module reset php"
    echo "   sudo dnf module enable php:remi-8.1"
    echo "   sudo dnf install php php-cli php-fpm"
    echo ""
    exit 1
fi

echo ""

################################################################################
# ASK USER CONFIRMATION
################################################################################
print_header "⚙️  Switch Configuration"

echo -e "${YELLOW}WARNING:${NC} This will switch system-wide PHP default to 8.1"
echo ""
echo "Current: $CURRENT_PHP"
echo "Target:  $PHP81_VERSION"
echo ""
read -p "Do you want to continue? (y/N): " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_info "Operation cancelled"
    exit 0
fi

################################################################################
# SWITCH PHP CLI
################################################################################
print_header "🔄 Switching PHP CLI to 8.1"

if command -v update-alternatives &> /dev/null; then
    print_info "Using update-alternatives..."
    
    # Check if PHP 8.1 is in alternatives
    if update-alternatives --list php 2>/dev/null | grep -q "php8.1"; then
        sudo update-alternatives --set php /usr/bin/php8.1
        print_success "PHP CLI switched to 8.1 via update-alternatives"
    else
        # Register PHP 8.1 in alternatives
        print_info "Registering PHP 8.1 in alternatives..."
        sudo update-alternatives --install /usr/bin/php php /usr/bin/php8.1 81
        sudo update-alternatives --set php /usr/bin/php8.1
        print_success "PHP 8.1 registered and set as default"
    fi
else
    # Fallback: create symlink
    print_info "Creating symlink (update-alternatives not available)..."
    sudo ln -sf /usr/bin/php8.1 /usr/bin/php
    print_success "Symlink created: /usr/bin/php -> /usr/bin/php8.1"
fi

# Verify
NEW_PHP=$(php -v | head -n1 | cut -d' ' -f2)
if [[ $NEW_PHP == 8.1.* ]]; then
    print_success "Verification: php -v shows $NEW_PHP"
else
    print_error "Verification failed: php -v shows $NEW_PHP"
fi

echo ""

################################################################################
# SWITCH PHP-FPM
################################################################################
print_header "🔄 Switching PHP-FPM to 8.1"

# Detect if PHP-FPM 8.1 is installed
if systemctl list-unit-files | grep -q "php8.1-fpm"; then
    print_info "PHP 8.1 FPM detected"
    
    # Stop other PHP-FPM versions
    for version in "${AVAILABLE_VERSIONS[@]}"; do
        if [ "$version" != "8.1" ]; then
            if systemctl is-active --quiet php${version}-fpm; then
                print_info "Stopping php${version}-fpm..."
                sudo systemctl stop php${version}-fpm
                sudo systemctl disable php${version}-fpm
            fi
        fi
    done
    
    # Start PHP 8.1 FPM
    print_info "Starting php8.1-fpm..."
    sudo systemctl enable php8.1-fpm
    sudo systemctl start php8.1-fpm
    
    if systemctl is-active --quiet php8.1-fpm; then
        print_success "php8.1-fpm is running"
    else
        print_error "Failed to start php8.1-fpm"
        sudo systemctl status php8.1-fpm
    fi
else
    print_warning "PHP 8.1 FPM not found (OK if not using FPM)"
fi

echo ""

################################################################################
# UPDATE APACHE/NGINX CONFIGURATION (if needed)
################################################################################
print_header "🌐 Web Server Configuration"

# Check for Apache
if systemctl list-unit-files | grep -q "apache2"; then
    print_info "Apache detected"
    
    # Disable old PHP modules
    for version in "${AVAILABLE_VERSIONS[@]}"; do
        if [ "$version" != "8.1" ]; then
            if [ -f "/etc/apache2/mods-enabled/php${version}.load" ]; then
                print_info "Disabling Apache mod_php${version}..."
                sudo a2dismod php${version} 2>/dev/null || true
            fi
        fi
    done
    
    # Enable PHP 8.1 module
    if [ -f "/etc/apache2/mods-available/php8.1.load" ]; then
        print_info "Enabling Apache mod_php8.1..."
        sudo a2enmod php8.1
        print_success "mod_php8.1 enabled"
        
        # Restart Apache
        print_info "Restarting Apache..."
        sudo systemctl restart apache2
        print_success "Apache restarted"
    else
        print_warning "mod_php8.1 not found - you may need to configure proxy to PHP-FPM"
        print_info "Modern setups use PHP-FPM with proxy_fcgi module"
    fi
fi

# Check for Nginx
if systemctl list-unit-files | grep -q "nginx"; then
    print_info "Nginx detected"
    print_warning "Manual configuration may be needed!"
    echo ""
    echo "Update your Nginx config to use PHP 8.1 FPM:"
    echo "   fastcgi_pass unix:/run/php/php8.1-fpm.sock;"
    echo ""
    echo "Then restart Nginx:"
    echo "   sudo systemctl restart nginx"
fi

echo ""

################################################################################
# UPDATE COMPOSER
################################################################################
print_header "📦 Updating Composer to use PHP 8.1"

if command -v composer &> /dev/null; then
    # Composer should automatically use the new default PHP
    COMPOSER_PHP=$(composer --version 2>&1 | grep -oP 'PHP version \K[0-9.]+' || echo "unknown")
    
    if [[ $COMPOSER_PHP == 8.1.* ]]; then
        print_success "Composer is using PHP $COMPOSER_PHP"
    else
        print_warning "Composer is still using PHP $COMPOSER_PHP"
        print_info "You may need to reinstall composer or set PHP path manually"
        echo ""
        echo "Create wrapper script at /usr/local/bin/composer81:"
        echo "   #!/bin/bash"
        echo "   /usr/bin/php8.1 /usr/local/bin/composer \"\$@\""
        echo ""
    fi
else
    print_info "Composer not found (install if needed)"
fi

echo ""

################################################################################
# VERIFICATION & SUMMARY
################################################################################
print_header "✅ Verification & Summary"

echo "System Default PHP:"
echo "─────────────────────"
php -v | head -n3
echo ""

echo "PHP Extensions (important ones):"
echo "─────────────────────────────────"
for ext in mbstring xml curl zip gd pdo mysql json; do
    if php -m | grep -qi "^${ext}$"; then
        echo -e "  ${GREEN}✓${NC} $ext"
    else
        echo -e "  ${RED}✗${NC} $ext - NOT INSTALLED"
    fi
done
echo ""

echo "PHP-FPM Status:"
echo "────────────────"
if systemctl is-active --quiet php8.1-fpm; then
    echo -e "  ${GREEN}✓${NC} php8.1-fpm is running"
else
    echo -e "  ${YELLOW}•${NC} php8.1-fpm is not running (may not be needed)"
fi
echo ""

echo "Composer:"
echo "─────────"
if command -v composer &> /dev/null; then
    composer --version | head -n1
else
    echo "  Not installed"
fi
echo ""

################################################################################
# COMPLETION
################################################################################
print_header "🎉 Switch Complete!"

print_success "PHP 8.1 is now the default version"
echo ""
print_info "Next steps for your BUMNag project:"
echo ""
echo "   1. Navigate to project directory:"
echo "      cd /path/to/bumnag"
echo ""
echo "   2. Remove old dependencies:"
echo "      rm -rf vendor composer.lock"
echo ""
echo "   3. Reinstall with PHP 8.1:"
echo "      composer install --no-dev --optimize-autoloader"
echo ""
echo "   4. Verify project works:"
echo "      php artisan --version"
echo ""
echo "   5. Run deployment script:"
echo "      bash deploy.sh"
echo ""

print_warning "Important Notes:"
echo "   • Test your website after switching PHP version"
echo "   • Check application logs for any issues"
echo "   • Some extensions may need to be installed separately"
echo "   • Update your web server config if using Nginx"
echo ""

exit 0
