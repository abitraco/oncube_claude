<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\FeaturedProduct;

class FeaturedProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 9 more products (assuming 1 already exists)
        $products = [
            [
                'title' => 'Premium Industrial Gearbox',
                'subtitle' => 'Heavy-duty performance',
                'category' => 'Parts & Components',
                'price' => 299.99,
                'product_url' => 'https://example.com/product-2',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Advanced Hydraulic Pump System',
                'subtitle' => 'High-efficiency hydraulics',
                'category' => 'Hydraulics',
                'price' => 449.99,
                'product_url' => 'https://example.com/product-3',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Professional Motor Controller',
                'subtitle' => 'Precision control technology',
                'category' => 'Electronics',
                'price' => 199.99,
                'product_url' => 'https://example.com/product-4',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Industrial Bearing Set',
                'subtitle' => 'Long-lasting durability',
                'category' => 'Parts & Components',
                'price' => 89.99,
                'product_url' => 'https://example.com/product-5',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'High-Performance Drive Belt',
                'subtitle' => 'Maximum torque transfer',
                'category' => 'Parts & Components',
                'price' => 34.99,
                'product_url' => 'https://example.com/product-6',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Precision Valve Assembly',
                'subtitle' => 'Flow control excellence',
                'category' => 'Hydraulics',
                'price' => 159.99,
                'product_url' => 'https://example.com/product-7',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Smart Sensor Module',
                'subtitle' => 'Real-time monitoring',
                'category' => 'Electronics',
                'price' => 124.99,
                'product_url' => 'https://example.com/product-8',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Heavy-Duty Coupling System',
                'subtitle' => 'Reliable power transmission',
                'category' => 'Parts & Components',
                'price' => 179.99,
                'product_url' => 'https://example.com/product-9',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'title' => 'Industrial Pressure Gauge',
                'subtitle' => 'Accurate pressure readings',
                'category' => 'Instruments',
                'price' => 64.99,
                'product_url' => 'https://example.com/product-10',
                'order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            FeaturedProduct::create($product);
        }
    }
}
