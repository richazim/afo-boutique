<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Charger les données statiques
        $products = require database_path('data/products.php');

        // Cache des catégories (optimisation importante)
        $categories = Category::pluck('id', 'name');

        foreach ($products as $data) {

            // Extraire les catégories
            $productCategories = $data['categories'] ?? [];
            unset($data['categories']);

            // Créer ou update le produit (évite doublons)
            $product = Product::updateOrCreate(
                ['SKU' => $data['SKU']], // clé unique
                $data
            );

            // Mapper noms → IDs
            $categoryIds = collect($productCategories)
                ->map(fn ($name) => $categories[$name] ?? null)
                ->filter()
                ->values()
                ->toArray();

            // Sync (propre + évite doublons pivot)
            $product->categories()->sync($categoryIds);
        }
    }
}
