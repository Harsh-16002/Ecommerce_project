<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's categories table.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Home Decor',
            'Kitchen',
            'Beauty',
            'Fitness',
            'Accessories',
            'Office',
            'Gaming',
            'Travel',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['category_name' => $name],
                ['category_name' => $name]
            );
        }
    }
}
