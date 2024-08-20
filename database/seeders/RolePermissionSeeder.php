<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $roles = [
      'super-admin',
      'admin',
      'volunteer'
    ];

    $permissions = [
      'show-article',
      'add-article',
      'update-article',
      'delete-article',
      'show-gallery',
      'add-gallery',
      'update-gallery',
      'delete-gallery',
    ];

    foreach ($permissions as $permission) {
      Permission::create([
        'name' => $permission
      ]);
    }

    foreach ($roles as $role) {
      $data = Role::create([
        'name' => $role
      ]);

      if ($data->name == 'super-admin') {
        $data->syncPermissions([
          'show-article',
          'add-article',
          'update-article',
          'delete-article',
          'show-gallery',
          'add-gallery',
          'update-gallery',
          'delete-gallery',
        ]);
      } else if ($data->name == 'admin') {
        $data->syncPermissions([
          'show-gallery',
          'add-gallery',
          'update-gallery',
          'delete-gallery',
        ]);
      }
    }
  }
}
