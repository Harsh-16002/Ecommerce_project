<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's products table with a large storefront catalog.
     */
    public function run(): void
    {
        $images = [
            '1725084373.webp',
            '1725086140.webp',
            '1725089220.webp',
            '1725089328.webp',
            '1725089737.webp',
            '1725089840.webp',
            '1725089911.webp',
            '1725089994.webp',
            '1725090078.webp',
            '1725090131.webp',
            '1725202051.webp',
            '1725215563.webp',
            '1725215573.webp',
            '1776002516.webp',
            '1776002564.webp',
            '1776002602.webp',
            '1776002625.webp',
            '1776002645.webp',
            '1776002670.webp',
        ];

        $catalog = [
            'Electronics' => [
                'Aura Wireless Earbuds',
                'Pulse Smartwatch',
                'Nova Bluetooth Speaker',
                'AirBeam Neckband',
                'Volt Charging Hub',
                'PixelView Tablet Stand',
                'Stream HD Webcam',
                'Echo Noise Cancelling Headphones',
                'Orbit Power Bank',
                'Zen Home Security Camera',
            ],
            'Fashion' => [
                'Urban Cotton Shirt',
                'Classic Denim Jacket',
                'Minimal Linen Kurta',
                'Tailored Slim Trousers',
                'Weekend Oversized Tee',
                'Soft Knit Cardigan',
                'Relaxed Summer Dress',
                'Premium Polo Shirt',
                'Structured Blazer',
                'City Layered Hoodie',
            ],
            'Home Decor' => [
                'Nordic Table Lamp',
                'Textured Wall Mirror',
                'Handwoven Cushion Set',
                'Ceramic Vase Duo',
                'Oak Finish Photo Frame',
                'Boho Floor Rug',
                'Scented Candle Collection',
                'Artisan Planter Pot',
                'Marble Accent Tray',
                'Modern Wall Clock',
            ],
            'Kitchen' => [
                'Chef Stainless Cookware Set',
                'Rapid Blend Mixer',
                'Glass Storage Jar Pack',
                'Nonstick Fry Pan',
                'Electric Kettle Pro',
                'Compact Sandwich Grill',
                'Bamboo Chopping Board',
                'Silicone Kitchen Tool Kit',
                'Smart Meal Prep Box',
                'Aroma Coffee Press',
            ],
            'Beauty' => [
                'Glow Daily Face Serum',
                'Hydra Repair Moisturizer',
                'Velvet Matte Lip Kit',
                'Botanical Hair Oil',
                'Skin Balance Cleanser',
                'Fresh Mist Toner',
                'Radiance Sheet Mask Pack',
                'Soft Blend Makeup Brush Set',
                'SPF Daily Shield',
                'Overnight Renewal Cream',
            ],
            'Fitness' => [
                'Core Flex Yoga Mat',
                'Adjustable Dumbbell Pair',
                'Power Loop Resistance Bands',
                'Grip Training Gloves',
                'Sprint Jump Rope',
                'Hydro Steel Gym Bottle',
                'Compact Massage Gun',
                'Balance Fitness Ball',
                'Home Workout Bench',
                'Recovery Foam Roller',
            ],
            'Accessories' => [
                'Leather Card Holder',
                'Minimal Chain Watch',
                'Travel Utility Backpack',
                'Polarized Sunglasses',
                'Signature Tote Bag',
                'Structured Laptop Sleeve',
                'Daily Wear Cap',
                'Compact Crossbody Bag',
                'Silver Finish Bracelet',
                'Premium Wallet Set',
            ],
            'Office' => [
                'Ergo Mesh Office Chair',
                'Smart Desk Organizer',
                'Smooth Flow Gel Pen Set',
                'Premium Hardcover Notebook',
                'Portable Monitor Riser',
                'Workday Laptop Backpack',
                'Focus Desk Lamp',
                'Noise Control Desk Divider',
                'Weekly Planner Board',
                'Wireless Presentation Clicker',
            ],
            'Gaming' => [
                'RGB Mechanical Keyboard',
                'Precision Gaming Mouse',
                'UltraWide Mouse Pad',
                'Surround Sound Gaming Headset',
                'Console Cooling Stand',
                'Dual Controller Charging Dock',
                'Streamer Microphone Kit',
                'Gaming Chair Elite',
                '4K Capture Card',
                'Trigger Grip Mobile Controller',
            ],
            'Travel' => [
                'Cabin Ready Trolley Bag',
                'Neck Comfort Travel Pillow',
                'Packing Cube Organizer Set',
                'Passport Zip Wallet',
                'Foldable Duffle Bag',
                'Leakproof Travel Bottle Kit',
                'Universal Travel Adapter',
                'Portable Luggage Scale',
                'Rain Cover Backpack Shield',
                'Weekend Explorer Bag',
            ],
        ];

        foreach ($catalog as $category => $products) {
            foreach ($products as $index => $title) {
                $seedNumber = $index + 1;
                $price = 499 + (($index + 1) * 189) + (strlen($category) * 11);
                $quantity = 10 + (($index * 4) % 38);
                $image = $images[($index + crc32($category)) % count($images)];

                Product::updateOrCreate(
                    ['title' => $title],
                    [
                        'title' => $title,
                        'description' => $this->descriptionFor($title, $category, $seedNumber),
                        'image' => $image,
                        'price' => (string) $price,
                        'category' => $category,
                        'quantity' => (string) $quantity,
                    ]
                );
            }
        }
    }

    private function descriptionFor(string $title, string $category, int $seedNumber): string
    {
        return "{$title} is part of the MarketVerse {$category} collection and is designed for customers who want practical value, dependable quality, and a cleaner everyday shopping experience. Seed item {$seedNumber} is written to feel ready for homepage features, category browsing, search, and product detail previews.";
    }
}
