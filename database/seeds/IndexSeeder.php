<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class IndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $superAdmin = Role::create([
            'name' => 'Super Admin',
        ]);

        $admin = Role::create([
            'name' => 'Admin',
        ]);

        $permission = Permission::create([
            'name' => 'see_Transaksi',
        ]);

        $admin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'create_Transaksi',
        ]);

        $admin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'update_Transaksi',
        ]);

        $admin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'delete_Transaksi',
        ]);

        $admin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'see_Member',
        ]);

        $admin->givePermissionTo($permission);

        $data   = [
            'name'      => 'Super Admin',
            'email'     => 'super@mail.com',
            'password'  => Hash::make('12345678')
        ];

        $user = User::create($data);

        $user->syncRoles('Super Admin');

        $data   = [
            'name'      => 'Karyawan',
            'email'     => 'karyawan@mail.com',
            'password'  => Hash::make('12345678')
        ];

        $user = User::create($data);

        $user->syncRoles('Admin');
    }
}
