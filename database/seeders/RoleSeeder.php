<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar modul dan aksi yang dimiliki
        $modules = [
            'users' => [
                'actions' => [
                    'index'   => 'user.index',
                    'create'  => 'user.create',
                    'edit'    => 'user.edit',
                    'destroy' => 'user.destroy',
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'destroy'],
                ],
            ],
            'roles' => [
                'actions' => [
                    'index'   => 'role.index',
                    'create'  => 'role.create',
                    'edit'    => 'role.edit',
                    'destroy' => 'role.destroy',
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'destroy'],
                ],
            ],
            'settings' => [
                'actions' => [
                    'index' => 'setting.index',
                    'edit'  => 'setting.edit',
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'edit'],
                ],
            ],
        ];

        // Reset cache permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Generate permissions & roles
        foreach ($modules as $moduleName => $moduleData) {
            Module::updateOrCreate(['name' => $moduleName], [
                'name'    => $moduleName,
                'actions' => $moduleData['actions'],
            ]);

            foreach ($moduleData['actions'] as $action => $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
            }
        }

        // Buat role ADMIN dan USER
        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN]);
        $userRole  = Role::firstOrCreate(['name' => RoleEnum::USER]);

        // Beri semua izin ke admin
        $adminRole->givePermissionTo(Permission::all());

        // Buat user admin
        $admin = User::create([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('123456789'),
            'gender'   => 'male',
            'location' => 'Rome',
            'address'  => 'Rome',
            'about_me' => 'Administrator utama sistem',
            'bio'      => 'Developer dan pengelola utama sistem.',
            'system_reserve' => true,
        ]);
        $admin->assignRole($adminRole);

        // Buat user biasa
        $user = User::create([
            'username' => 'user1',
            'email'    => 'user@example.com',
            'password' => Hash::make('123456789'),
            'gender'   => 'female',
            'location' => 'Tokyo',
            'address'  => 'Shibuya',
            'about_me' => 'Pengguna biasa yang suka eksplor fitur.',
            'bio'      => 'Suka mencoba berbagai fitur di platform ini.',
        ]);
        $user->assignRole($userRole);
    }
}