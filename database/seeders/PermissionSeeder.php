<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()->state([
            'name' => 'user_read',
            'display_name' => 'User Read',
        ])->create();

        Permission::factory()->state([
            'name' => 'user_create',
            'display_name' => 'User Create',
        ])->create();

        Permission::factory()->state([
            'name' => 'user_update',
            'display_name' => 'User Update',
        ])->create();

        Permission::factory()->state([
            'name' => 'user_delete',
            'display_name' => 'User Delete',
        ])->create();

        Permission::factory()->state([
            'name' => 'role_read',
            'display_name' => 'Role Read',
        ])->create();

        Permission::factory()->state([
            'name' => 'role_create',
            'display_name' => 'Role Create',
        ])->create();

        Permission::factory()->state([
            'name' => 'role_update',
            'display_name' => 'Role Update',
        ])->create();

        Permission::factory()->state([
            'name' => 'role_delete',
            'display_name' => 'Role Delete',
        ])->create();

        Permission::factory()->state([
            'name' => 'category_read',
            'display_name' => 'Category Read',
        ])->create();

        Permission::factory()->state([
            'name' => 'category_create',
            'display_name' => 'Category Create',
        ])->create();

        Permission::factory()->state([
            'name' => 'category_update',
            'display_name' => 'Category Update',
        ])->create();

        Permission::factory()->state([
            'name' => 'category_delete',
            'display_name' => 'Category Delete',
        ])->create();

        Permission::factory()->state([
            'name' => 'article_read',
            'display_name' => 'Article Read',
        ])->create();

        Permission::factory()->state([
            'name' => 'article_create',
            'display_name' => 'Article Create',
        ])->create();

        Permission::factory()->state([
            'name' => 'article_update',
            'display_name' => 'Article Update',
        ])->create();

        Permission::factory()->state([
            'name' => 'article_delete',
            'display_name' => 'Article Delete',
        ])->create();

        Permission::factory()->state([
            'name' => 'comment_approve',
            'display_name' => 'Comment Approve',
        ])->create();

        Permission::factory()->state([
            'name' => 'comment_pending',
            'display_name' => 'Comment Pending',
        ])->create();

        Permission::factory()->state([
            'name' => 'comment_delete',
            'display_name' => 'Comment Delete',
        ])->create();


    }
}
