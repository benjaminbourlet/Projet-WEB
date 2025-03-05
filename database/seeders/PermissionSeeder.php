<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Liste des permissions
        $permissions = [
            'authenticate',
            'search_company',
            'create_company',
            'edit_company',
            'evaluate_company',
            'delete_company',
            'view_company_stats',
            'search_offer',
            'create_offer',
            'edit_offer',
            'delete_offer',
            'view_offer_stats',
            'search_pilot',
            'create_pilot',
            'edit_pilot',
            'delete_pilot',
            'search_student',
            'create_student',
            'edit_student',
            'delete_student',
            'view_student_stats',
            'add_offer_to_wishlist',
            'remove_offer_from_wishlist',
            'apply_for_offer',
        ];

        // Création des permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Création des rôles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $pilot = Role::firstOrCreate(['name' => 'Pilote']);
        $student = Role::firstOrCreate(['name' => 'Etudiant']);

        // Attribution des permissions aux rôles
        $admin->givePermissionTo($permissions);

        $pilot->givePermissionTo([
            'authenticate',
            'search_company',
            'create_company',
            'edit_company',
            'evaluate_company',
            'delete_company',
            'view_company_stats',
            'search_offer',
            'create_offer',
            'edit_offer',
            'delete_offer',
            'view_offer_stats',
            'search_student',
            'create_student',
            'edit_student',
            'delete_student',
            'view_student_stats',
        ]);

        $student->givePermissionTo([
            'authenticate',
            'search_company',
            'evaluate_company',
            'view_company_stats',
            'search_offer',
            'view_offer_stats',
            'add_offer_to_wishlist',
            'remove_offer_from_wishlist',
            'apply_for_offer',
        ]);
    }
}
