<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    /** @var array<string> */
    private array $categories  = [
        'Electronics',
        'Clothing',
        'Books',
        'Home & Kitchen',
        'Beauty & Health',
        'Sports & Outdoors',
        'Toys & Games',
        'Automotive',
        'Grocery',
        'Movies & TV Shows',
    ];

    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
