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
        'Electronica',
        'Hogar',
        'Deportes',
        'Moda',
        'Juguetes',
        'Mascotas',
        'Libros',
        'Salud',
        'Belleza',
        'Jardineria',
        'Automoviles',
        'Musica',
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
