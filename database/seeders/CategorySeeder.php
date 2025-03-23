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
        'electronica',
        'hogar',
        'ropa',
        'deportes',
        'tecnologia',
        'juegos',
        'libros',
        'musica',
        'peliculas',
        'alimentos',
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
