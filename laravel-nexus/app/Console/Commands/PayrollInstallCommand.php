<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * One command for a working demo: schema, Nexus modules and permissions, an admin login and the demo employees.
 * Safe to re-run (migrations are incremental, the admin and the seed data are only created when missing).
 */
class PayrollInstallCommand extends Command
{
    protected $signature = 'payroll:install
        {--admin-email=admin@example.com : superadmin login}
        {--admin-password=password : superadmin password (local demo only)}
        {--fresh : drop every table first (migrate:fresh)}';

    protected $description = 'Migrate, register the Nexus modules and permissions, create the admin and seed demo employees';

    /** Dependency order: Permission adds the column the permission seeding of the other modules needs. */
    private const MODULES = ['Permission', 'Role', 'User', 'Employee', 'PayrollLine', 'PayrollAudit', 'PayrollAdjustment'];

    public function handle(): int
    {
        $this->components->info('Database');
        $this->call($this->option('fresh') ? 'migrate:fresh' : 'migrate', ['--force' => true]);

        foreach (self::MODULES as $module) {
            $this->call('migrate', ['--path' => "app/Nexus/Modules/{$module}/database/migrations", '--force' => true]);
        }

        $this->components->info('Nexus modules and permissions');
        $this->call('nexus:module:install');
        $this->call('nexus:permission:init');

        $email = (string) $this->option('admin-email');
        if (User::query()->where('email', $email)->doesntExist()) {
            $this->call('nexus:create:superadmin', ['name' => 'Admin', 'email' => $email, 'password' => (string) $this->option('admin-password')]);
        } else {
            // The users table may be shared with another project on the same database: still make this user an admin here.
            $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
            $role->syncPermissions(Permission::query()->where('guard_name', 'web')->get());
            User::query()->where('email', $email)->firstOrFail()->assignRole($role);
            $this->line("Admin {$email} already exists; granted the super-admin role.");
        }

        $this->components->info('Demo employees');
        $this->call('db:seed', ['--force' => true]);

        $this->newLine();
        $this->components->info("Ready: log in at /admin as {$email}.");

        return self::SUCCESS;
    }
}
