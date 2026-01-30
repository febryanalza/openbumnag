#!/bin/bash

echo "🔐 Password Verification Test"
echo "============================="
echo ""

EMAIL="${1:-admin@bumnag.com}"
PASSWORD="${2:-bumagbersatu24}"

echo "Testing credentials:"
echo "Email: $EMAIL"
echo "Password: $PASSWORD"
echo ""

php artisan tinker --execute="
\$user = App\Models\User::where('email', '$EMAIL')->first();
if (!\$user) {
    echo '❌ User not found!\n';
    echo 'Available users:\n';
    App\Models\User::all(['email'])->each(fn(\$u) => print('  - ' . \$u->email . PHP_EOL));
    exit(1);
}

echo '✅ User found: ' . \$user->email . PHP_EOL;
echo 'User ID: ' . \$user->id . PHP_EOL;
echo 'Roles: ' . \$user->roles->pluck('name')->implode(', ') . PHP_EOL;
echo 'Email verified: ' . (\$user->email_verified_at ? 'Yes' : 'No') . PHP_EOL;
echo PHP_EOL;

if (Hash::check('$PASSWORD', \$user->password)) {
    echo '✅ PASSWORD CORRECT!\n';
    echo PHP_EOL;
    echo '🎯 Credentials are valid. Login should work.\n';
} else {
    echo '❌ PASSWORD INCORRECT!\n';
    echo PHP_EOL;
    echo '⚠️  Try resetting password:\n';
    echo '   php artisan tinker\n';
    echo '   \$user = User::where(\"email\", \"$EMAIL\")->first();\n';
    echo '   \$user->password = Hash::make(\"bumagbersatu24\");\n';
    echo '   \$user->save();\n';
}
"
