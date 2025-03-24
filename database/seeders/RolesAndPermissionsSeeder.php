<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    //lets create the permissions first (we put them inside a table in order to )

    $permissions = [
        "create_course",
        "edit_course",
        "delete_course",
        "view_course",
        "create_category",
        "edit_category",
        "delete_category",
        "create_tag",
        "edit_tag",
        "delete_tag",
        "enroll_course"
    ];

    //now lets loop throu the table in order to seed the table of the permissions
    foreach($permissions as $permission){
        Permission::create(["name"=>$permission]);
    }

    //now we create roles
    $adminRole = Role::create(['name' => 'admin']);
    $mentorRole = Role::create(['name' => 'mentor']);
    $studentRole = Role::create(['name' => 'student']);

    //here we will assign the permissions into the roles

    $adminRole->givePermissionTo(Permission::all());
    $mentorRole->givePermissionTo([
        "create_course",
        "edit_course",
        "delete_course",
        "view_course",
    ]);
    $studentRole->givePermissionTo([
        "view_course",
        "enroll_course"
    ]);


    }
}
