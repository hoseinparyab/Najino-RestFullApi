<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User permissions
        Permission::createIfNotExists('user_read', 'User Read');
        Permission::createIfNotExists('user_create', 'User Create');
        Permission::createIfNotExists('user_update', 'User Update');
        Permission::createIfNotExists('user_delete', 'User Delete');

        // Role permissions
        Permission::createIfNotExists('role_read', 'Role Read');
        Permission::createIfNotExists('role_create', 'Role Create');
        Permission::createIfNotExists('role_update', 'Role Update');
        Permission::createIfNotExists('role_delete', 'Role Delete');

        // Category permissions
        Permission::createIfNotExists('category_read', 'Category Read');
        Permission::createIfNotExists('category_create', 'Category Create');
        Permission::createIfNotExists('category_update', 'Category Update');
        Permission::createIfNotExists('category_delete', 'Category Delete');

        // Article permissions
        Permission::createIfNotExists('article_read', 'Article Read');
        Permission::createIfNotExists('article_create', 'Article Create');
        Permission::createIfNotExists('article_update', 'Article Update');
        Permission::createIfNotExists('article_delete', 'Article Delete');

        // Portfolio permissions
        Permission::createIfNotExists('portfolio_read', 'Portfolio Read');
        Permission::createIfNotExists('portfolio_create', 'Portfolio Create');
        Permission::createIfNotExists('portfolio_update', 'Portfolio Update');
        Permission::createIfNotExists('portfolio_delete', 'Portfolio Delete');

        // FAQ permissions
        Permission::createIfNotExists('faq_read', 'FAQ Read');
        Permission::createIfNotExists('faq_create', 'FAQ Create');
        Permission::createIfNotExists('faq_update', 'FAQ Update');
        Permission::createIfNotExists('faq_delete', 'FAQ Delete');

        // Comment permissions
        Permission::createIfNotExists('comment_delete', 'Comment Delete');

        $this->command->info('Created '.Permission::count().' permissions.');
    }
}
