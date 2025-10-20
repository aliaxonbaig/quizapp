<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MaterialPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Get student role
        $student = Role::where('name', 'student')->first();
        
        if (!$student) {
            $this->command->error('Student role not found!');
            return;
        }

        // Give students view permissions for materials
        $viewPermissions = Permission::where('name', 'like', 'view%material')->get();
        
        if ($viewPermissions->isEmpty()) {
            $this->command->warn('No view material permissions found. Run: php artisan shield:generate --resource=MaterialResource');
            return;
        }

        $student->givePermissionTo($viewPermissions);
        
        $this->command->info('✅ Student role given view material permissions!');
        $this->command->info('Permissions: ' . $viewPermissions->pluck('name')->implode(', '));
    }
}
