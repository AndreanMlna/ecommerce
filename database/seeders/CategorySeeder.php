<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // NONAKTIFKAN FOREIGN KEY CONSTRAINT SAAT TRUNCATE
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('categories')->truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        $now = now();

        $departments = [
            1 => [
                'name' => 'Electronics',
                'children' => [
                    'Computers' => ['Laptops', 'Desktops'],
                    'Smartphones' => ['Android', 'Iphone'],
                ]
            ],
            2 => [
                'name' => 'Fashion',
                'children' => [
                    'Men Clothing' => ['Shirts', 'Pants'],
                    'Women Clothing' => ['Dresses', 'Skirts'],
                ]
            ],
            3 => [
                'name' => 'Book & Audible',
                'children' => [
                    'Fiction' => ['Novels'],
                    'Non-fiction' => ['Science'],
                ]
            ],
            4 => [
                'name' => 'Health & Beauty',
                'children' => [
                    'Makeup' => ['Foundation'],
                    'Skincare' => ['Moisturizer'],
                ]
            ],
            5 => [
                'name' => 'Home, Garden & Tools',
                'children' => [
                    'Furniture' => ['Chairs'],
                    'Tools' => ['Hand Tools'],
                ]
            ],
        ];

        foreach ($departments as $departmentId => $data) {
            // Level 1: kategori utama
            $parentId = DB::table('categories')->insertGetId([
                'name' => $data['name'],
                'department_id' => $departmentId,
                'parent_id' => null,
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            foreach ($data['children'] as $childName => $subChildren) {
                // Level 2: kategori anak
                $childId = DB::table('categories')->insertGetId([
                    'name' => $childName,
                    'department_id' => $departmentId,
                    'parent_id' => $parentId,
                    'active' => true,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                // Level 3: subkategori
                foreach ($subChildren as $subName) {
                    DB::table('categories')->insert([
                        'name' => $subName,
                        'department_id' => $departmentId,
                        'parent_id' => $childId,
                        'active' => true,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }
        }
    }
}
