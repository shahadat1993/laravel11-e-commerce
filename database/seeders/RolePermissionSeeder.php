<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ১. সব সম্ভাব্য পারমিশন (Module wise)
        $permissions = [
            // User & Role Management
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-manage',

            // Product & Inventory
            'product-list', 'product-create', 'product-edit', 'product-delete',
            'inventory-manage', 'stock-update',

            // Order & Transaction
            'order-list', 'order-view', 'order-edit', 'order-status-update', 'order-delete',
            'payment-view', 'refund-manage',

            // Category, Brand & Attributes
            'category-manage', 'brand-manage', 'attribute-manage',

            // Marketing & Promotion
            'coupon-manage', 'banner-manage', 'campaign-manage', 'newsletter-view',

            // Customer & Support
            'customer-list', 'customer-view', 'review-manage', 'support-ticket-manage',

            // Content & Pages
            'page-manage', 'blog-manage', 'faq-manage',

            // System Settings & Reports
            'setting-manage', 'report-view', 'analytics-view'
        ];

        // পারমিশনগুলো ডাটাবেসে তৈরি করা
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // --- ২. বিভিন্ন রোল তৈরি এবং পারমিশন অ্যাসাইন ---

        // সুপার অ্যাডমিন (সব ক্ষমতা)
        $adminRole = Role::findOrCreate('Admin', 'web');
        $adminRole->syncPermissions(Permission::all());

        // ম্যানেজার (অপারেশনাল কাজ)
        $managerRole = Role::findOrCreate('Manager', 'web');
        $managerRole->syncPermissions([
            'user-list', 'product-list', 'product-create', 'product-edit', 'inventory-manage',
            'order-list', 'order-view', 'order-edit', 'order-status-update',
            'category-manage', 'brand-manage', 'customer-list', 'review-manage'
        ]);

        // ইনভেন্টরি বা স্টক ম্যানেজার
        $inventoryManager = Role::findOrCreate('Inventory-Manager', 'web');
        $inventoryManager->syncPermissions([
            'product-list', 'inventory-manage', 'stock-update', 'category-manage', 'brand-manage'
        ]);

        // মার্কেটিং ম্যানেজার (অফার এবং ক্যাম্পেইন)
        $marketingManager = Role::findOrCreate('Marketing-Manager', 'web');
        $marketingManager->syncPermissions([
            'coupon-manage', 'banner-manage', 'campaign-manage', 'newsletter-view', 'blog-manage'
        ]);

        // কাস্টমার সাপোর্ট (টিকিট এবং রিভিউ)
        $supportRole = Role::findOrCreate('Support-Staff', 'web');
        $supportRole->syncPermissions([
            'order-list', 'order-view', 'customer-list', 'customer-view', 'review-manage', 'support-ticket-manage'
        ]);

        // ডেলিভারি কোঅর্ডিনেটর (অর্ডারের শিপিং দেখাশোনা)
        $deliveryRole = Role::findOrCreate('Delivery-Coordinator', 'web');
        $deliveryRole->syncPermissions([
            'order-list', 'order-view', 'order-status-update'
        ]);

        // একাউন্ট্যান্ট (টাকা-পয়সা এবং রিপোর্ট)
        $accountantRole = Role::findOrCreate('Accountant', 'web');
        $accountantRole->syncPermissions([
            'order-list', 'payment-view', 'refund-manage', 'report-view', 'analytics-view'
        ]);
    }
}
