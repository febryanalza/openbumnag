<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Filament\Facades\Filament;

class DebugFilamentLogin extends Command
{
    protected $signature = 'debug:filament-login {email?} {password?}';
    protected $description = 'Debug Filament login issues';

    public function handle()
    {
        $this->info('🔧 BUMNag Filament Login Debug');
        $this->info('================================');

        // Get credentials
        $email = $this->argument('email') ?? $this->ask('Email', 'admin@bumnag.com');
        $password = $this->argument('password') ?? $this->secret('Password');

        $this->newLine();
        $this->info("Testing login for: {$email}");
        $this->newLine();

        // Step 1: Check environment
        $this->checkEnvironment();
        
        // Step 2: Check database
        $this->checkDatabase();
        
        // Step 3: Check user
        $user = $this->checkUser($email, $password);
        
        if (!$user) {
            return 1;
        }
        
        // Step 4: Check Filament
        $this->checkFilament($user);
        
        // Step 5: Check permissions
        $this->checkPermissions($user);
        
        // Step 6: Test manual login
        $this->testManualLogin($email, $password);

        $this->newLine();
        $this->info('✅ Debug completed!');
        return 0;
    }

    private function checkEnvironment()
    {
        $this->warn('1. Environment Check:');
        
        $checks = [
            'App Environment' => config('app.env'),
            'App Debug' => config('app.debug') ? 'true' : 'false',
            'App URL' => config('app.url'),
            'Session Driver' => config('session.driver'),
            'Session Domain' => config('session.domain') ?? 'null',
            'Session Secure' => config('session.secure') ? 'true' : 'false',
            'Cache Store' => config('cache.default'),
        ];

        foreach ($checks as $name => $value) {
            $this->line("   {$name}: <info>{$value}</info>");
        }
        $this->newLine();
    }

    private function checkDatabase()
    {
        $this->warn('2. Database Check:');
        
        try {
            $pdo = DB::connection()->getPdo();
            $this->info('   ✅ Database connected');
            
            $tables = [
                'users' => DB::table('users')->count(),
                'sessions' => DB::table('sessions')->count(),
                'permissions' => DB::table('permissions')->count(),
                'roles' => DB::table('roles')->count(),
            ];
            
            foreach ($tables as $table => $count) {
                $this->line("   {$table}: <info>{$count} records</info>");
            }
            
        } catch (\Exception $e) {
            $this->error('   ❌ Database connection failed: ' . $e->getMessage());
        }
        $this->newLine();
    }

    private function checkUser($email, $password)
    {
        $this->warn('3. User Check:');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("   ❌ User not found: {$email}");
            
            // Suggest creating user
            if ($this->confirm('Create this user now?')) {
                $name = $this->ask('Full name', 'Administrator');
                
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                ]);
                
                $user->assignRole('super_admin');
                $this->info("   ✅ User created and assigned super_admin role");
                return $user;
            }
            return null;
        }
        
        $this->info("   ✅ User found: {$user->name} (ID: {$user->id})");
        
        if (!Hash::check($password, $user->password)) {
            $this->error('   ❌ Password incorrect');
            
            if ($this->confirm('Reset password?')) {
                $user->password = Hash::make($password);
                $user->save();
                $this->info('   ✅ Password reset successfully');
            } else {
                return null;
            }
        } else {
            $this->info('   ✅ Password correct');
        }
        
        $this->newLine();
        return $user;
    }

    private function checkFilament($user)
    {
        $this->warn('4. Filament Check:');
        
        try {
            $panel = Filament::getCurrentOrDefaultPanel();
            $this->info("   ✅ Panel found: {$panel->getId()}");
            $this->line("   Panel path: <info>{$panel->getPath()}</info>");
            $this->line("   Panel URL: <info>" . url($panel->getPath()) . "</info>");
            
            $canAccess = $user->canAccessPanel($panel);
            if ($canAccess) {
                $this->info('   ✅ User can access panel');
            } else {
                $this->error('   ❌ User cannot access panel');
            }
            
        } catch (\Exception $e) {
            $this->error('   ❌ Filament error: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function checkPermissions($user)
    {
        $this->warn('5. Permissions Check:');
        
        $roles = $user->getRoleNames();
        $this->line("   Roles: <info>" . $roles->implode(', ') . "</info>");
        
        if ($roles->isEmpty()) {
            $this->error('   ❌ User has no roles');
            
            if ($this->confirm('Assign super_admin role?')) {
                $user->assignRole('super_admin');
                $this->info('   ✅ Super admin role assigned');
            }
        } else {
            $this->info("   ✅ User has {$roles->count()} role(s)");
        }
        
        $permissions = $user->getAllPermissions();
        $this->line("   Permissions: <info>{$permissions->count()}</info>");
        
        if ($permissions->isEmpty()) {
            $this->error('   ❌ User has no permissions');
            
            if ($this->confirm('Generate Shield permissions?')) {
                $this->call('shield:generate', ['--all' => true]);
                $this->info('   ✅ Shield permissions generated');
            }
        }
        
        $this->newLine();
    }

    private function testManualLogin($email, $password)
    {
        $this->warn('6. Manual Login Test:');
        
        try {
            Auth::logout();
            
            $success = Auth::attempt(['email' => $email, 'password' => $password]);
            
            if ($success) {
                $this->info('   ✅ Manual login successful');
                $this->line("   Authenticated user: <info>" . Auth::user()->name . "</info>");
            } else {
                $this->error('   ❌ Manual login failed');
            }
            
        } catch (\Exception $e) {
            $this->error('   ❌ Login error: ' . $e->getMessage());
        }
        
        $this->newLine();
    }
}