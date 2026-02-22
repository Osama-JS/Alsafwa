<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions
        $permissions = [
            // Pages
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete', 'pages.publish',

            // Services
            'services.view', 'services.create', 'services.edit', 'services.delete', 'services.publish',

            // Agencies
            'agencies.view', 'agencies.create', 'agencies.edit', 'agencies.delete', 'agencies.publish',

            // Activities
            'activities.view', 'activities.create', 'activities.edit', 'activities.delete', 'activities.publish',
            'activity_categories.view', 'activity_categories.create', 'activity_categories.edit', 'activity_categories.delete',

            // Branches
            'branches.view', 'branches.create', 'branches.edit', 'branches.delete',

            // Gallery
            'gallery.view', 'gallery.create', 'gallery.edit', 'gallery.delete',
            'gallery_categories.view', 'gallery_categories.create', 'gallery_categories.edit', 'gallery_categories.delete',

            // Sliders
            'sliders.view', 'sliders.create', 'sliders.edit', 'sliders.delete',

            // Messages
            'messages.view', 'messages.reply', 'messages.delete',

            // Settings
            'settings.view', 'settings.edit',

            // Users & Roles
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',

            // Reports
            'reports.view', 'reports.export',

            // Backups
            'backups.create', 'backups.download', 'backups.delete',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // 1. Super Admin - All permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin - Most permissions except user/role management
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions([
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete', 'pages.publish',
            'services.view', 'services.create', 'services.edit', 'services.delete', 'services.publish',
            'agencies.view', 'agencies.create', 'agencies.edit', 'agencies.delete', 'agencies.publish',
            'activities.view', 'activities.create', 'activities.edit', 'activities.delete', 'activities.publish',
            'activity_categories.view', 'activity_categories.create', 'activity_categories.edit', 'activity_categories.delete',
            'branches.view', 'branches.create', 'branches.edit', 'branches.delete',
            'gallery.view', 'gallery.create', 'gallery.edit', 'gallery.delete',
            'gallery_categories.view', 'gallery_categories.create', 'gallery_categories.edit', 'gallery_categories.delete',
            'sliders.view', 'sliders.create', 'sliders.edit', 'sliders.delete',
            'messages.view', 'messages.reply', 'messages.delete',
            'settings.view', 'settings.edit',
            'reports.view', 'reports.export',
            'backups.create', 'backups.download',
        ]);

        // 3. Supervisor - Can manage content but not delete
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $supervisor->syncPermissions([
            'pages.view', 'pages.create', 'pages.edit', 'pages.publish',
            'services.view', 'services.create', 'services.edit', 'services.publish',
            'agencies.view', 'agencies.create', 'agencies.edit', 'agencies.publish',
            'activities.view', 'activities.create', 'activities.edit', 'activities.publish',
            'activity_categories.view', 'activity_categories.create', 'activity_categories.edit',
            'branches.view', 'branches.create', 'branches.edit',
            'gallery.view', 'gallery.create', 'gallery.edit',
            'gallery_categories.view', 'gallery_categories.create', 'gallery_categories.edit',
            'sliders.view', 'sliders.create', 'sliders.edit',
            'messages.view', 'messages.reply',
            'reports.view',
        ]);

        // 4. Content Editor - Can create and edit content
        $contentEditor = Role::firstOrCreate(['name' => 'Content Editor']);
        $contentEditor->syncPermissions([
            'pages.view', 'pages.create', 'pages.edit',
            'services.view', 'services.create', 'services.edit',
            'agencies.view', 'agencies.create', 'agencies.edit',
            'activities.view', 'activities.create', 'activities.edit',
            'activity_categories.view',
            'branches.view',
            'gallery.view', 'gallery.create', 'gallery.edit',
            'gallery_categories.view',
            'sliders.view',
            'messages.view',
        ]);

        // 5. Employee - View only
        $employee = Role::firstOrCreate(['name' => 'Employee']);
        $employee->syncPermissions([
            'pages.view',
            'services.view',
            'agencies.view',
            'activities.view',
            'activity_categories.view',
            'branches.view',
            'gallery.view',
            'gallery_categories.view',
            'sliders.view',
            'messages.view',
        ]);

        // Create Super Admin User
        $superAdminUser = User::updateOrCreate(
            ['email' => 'admin@alsafua.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdminUser->assignRole('Super Admin');

        $this->command->info('✅ Roles and Permissions created successfully!');
        $this->command->info('📧 Super Admin: admin@alsafua.com');
        $this->command->info('🔑 Password: password');
    }
}
