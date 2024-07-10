<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config = config('laratrust_seeder.roles_structure');

        if ($config === null) {
            $this->command->error("The configuration has not been published. Did you run `php artisan vendor:publish --tag=\"laratrust-seeder\"`");
            $this->command->line('');
            return false;
        }

        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {
            $this->command->info('Creating Role '. strtoupper($key));

            $role = $this->createRole($key);

            $permissions = [];

            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {
                    $permissionValue = $mapPermission->get($perm);

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);

                    $permissions[] = $this->createPermission($module, $permissionValue);
                }
            }

            $role->permissions()->sync($permissions);
        }
    }

    protected function createRole($roleName)
    {
        $role = Role::create();

        $role->translations()->create([
            'locale' => config('app.fallback_locale'),
            'name' => ucwords(str_replace('_', ' ', $roleName)),
            'description' => ucwords(str_replace('_', ' ', $roleName))
        ]);

        return $role;
    }

    protected function createPermission($module, $permissionValue)
    {
        return Permission::firstOrCreate([
            'name' => $module . '-' . $permissionValue,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
        ])->id;
    }

    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');

        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
    }
}
