<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            // n-10.jpg: Red & White with Heart and Flower Accents
            [
                'name' => 'Red Romance Press-On Nails',
                'category_id' => 1,
                'description' => 'Set of premium press-on nails featuring a passionate red and white theme with intricate hand-painted flower, heart, and abstract designs. Perfect for Valentine\'s or a bold statement.',
                'price' => 125000,
                'stock' => 20,
                'image_url' => 'product_images/n-10.jpg',
            ],
            // n-3.jpg: Pink Ombre with Glitter Tips
            [
                'name' => 'Pink Glitter Ombre Press-On Nails',
                'category_id' => 1,
                'description' => 'Soft pink ombre press-on nails that fade to shimmering silver glitter tips. Short, rounded shape for a cute, everyday look with a touch of sparkle.',
                'price' => 85000,
                'stock' => 45,
                'image_url' => 'product_images/n-3.jpg',
            ],
            // n-2.jpg: Brown Marble with Gold Swirls
            [
                'name' => 'Matte Brown & Gold Swirl Press-On Nails',
                'category_id' => 1,
                'description' => 'Chic set combining solid matte deep brown nails with glossy beige nails featuring delicate gold line swirls. Ideal for an elegant, earthy, and modern style.',
                'price' => 110000,
                'stock' => 35,
                'image_url' => 'product_images/n-2.jpg',
            ],
            // n-6.jpg: Nude Pink with Gold Butterfly & Crystal Accents
            [
                'name' => 'Nude Elegance Butterfly Press-On Nails',
                'category_id' => 1,
                'description' => 'Luxury almond-shaped nails in a soft nude pink base, accented with glitter, gold foil outlines, abstract butterfly/leaf patterns, and dazzling rhinestones.',
                'price' => 140000,
                'stock' => 25,
                'image_url' => 'product_images/n-6.jpg',
            ],
            // n-11.jpg: Brown & Nude Abstract with Starfish
            [
                'name' => 'Tropical Starfish Press-On Nails',
                'category_id' => 1,
                'description' => 'A beach-inspired set featuring warm brown and nude tones, marbled patterns, checkerboard designs, and 3D starfish and gold sun accents. Long, square-oval shape.',
                'price' => 120000,
                'stock' => 30,
                'image_url' => 'product_images/n-11.jpg',
            ],
            // n-8.jpg: Red Reptile/Water Effect
            [
                'name' => 'Crimson Crocodile Press-On Nails',
                'category_id' => 1,
                'description' => 'Striking set in deep red and white, mixing textured "reptile skin" or coral patterns, water droplet effects, and a detailed 3D red starfish design.',
                'price' => 135000,
                'stock' => 18,
                'image_url' => 'product_images/n-8.jpg',
            ],
            // n-7.jpg: Glittery Brown & Nude Marble
            [
                'name' => 'Dusty Glitter Marble Press-On Nails',
                'category_id' => 1,
                'description' => 'Elegant mix of solid dark brown, light nude, and stunning marble effect nails with embedded gold glitter foil and streaks. Perfect for fall/winter.',
                'price' => 115000,
                'stock' => 40,
                'image_url' => 'product_images/n-7.jpg',
            ],
            // n-9.jpg: Pink & Gold Lines/Lace
            [
                'name' => 'Baby Pink Gold Lace Press-On Nails',
                'category_id' => 1,
                'description' => 'Feminine, soft pink nails with intricate metallic gold line work, lattice patterns, and silver glitter French tips. Accented with small, subtle rhinestones.',
                'price' => 125000,
                'stock' => 28,
                'image_url' => 'product_images/n-9.jpg',
            ],
            // n-5.jpg: Simple Light Pink Glossy
            [
                'name' => 'Simple Glossy Light Pink Press-On Nails',
                'category_id' => 1,
                'description' => 'A classic, minimalist set of light rosy pink press-on nails with a flawless, high-gloss finish. Suitable for professional settings or a clean look.',
                'price' => 75000,
                'stock' => 50,
                'image_url' => 'product_images/n-5.jpg',
            ],
            // n-4.jpg: Brown Glitter Marble Swirl
            [
                'name' => 'Mocha Glitter Swirl Press-On Nails',
                'category_id' => 1,
                'description' => 'Rich, warm mocha-brown nails featuring a beautiful, subtle marbled swirl effect and heavy silver glitter placement. A cozy yet glamorous design.',
                'price' => 105000,
                'stock' => 38,
                'image_url' => 'product_images/n-4.jpg',
            ],
            // n-1.jpg: Nude Pink with White Flowers and Gold Chain
            [
                'name' => 'Nude Daisy Gold Chain Press-On Nails',
                'category_id' => 1,
                'description' => 'Sweet, almond-shaped press-on nails in a soft nude base, decorated with delicate hand-painted white daisy/flower accents and chic gold chain details. Perfect for a feminine, everyday look.',
                'price' => 115000,
                'stock' => 32,
                'image_url' => 'product_images/n-1.jpg',
            ],
             // ps-11.jpg: White & Silver Chain (Long)
            [
                'name' => 'Pure White Heart Charm Phone Strap',
                'category_id' => 2,
                'description' => 'Elegant long phone strap with silver chain accents, featuring white iridescent beads, a subtle silver bow, and a large, shimmering iridescent heart pendant.',
                'price' => 70000,
                'stock' => 40,
                'image_url' => 'product_images/ps-11.jpg',
            ],
            // ps-7.jpg: Silver & White Moon Chain (Long)
            [
                'name' => 'Silver Moon Celestial Phone Strap',
                'category_id' => 2,
                'description' => 'Sophisticated silver and white long charm strap featuring small pearls, a metallic heart, a bow charm, and a large, reflective half-moon pendant.',
                'price' => 75000,
                'stock' => 35,
                'image_url' => 'product_images/ps-7.jpg',
            ],
            // ps-9.jpg: Lavender Heart & Bow Chain (Long)
            [
                'name' => 'Pastel Purple Bow Chain Phone Strap',
                'category_id' => 2,
                'description' => 'Charming long phone strap with silver chain. Features two large iridescent purple bow charms and a matching heart pendant with pink pearl accents.',
                'price' => 72000,
                'stock' => 38,
                'image_url' => 'product_images/ps-9.jpg',
            ],
            // ps-5.jpg: Purple Dolphin & Shells Chain (Long)
            [
                'name' => 'Lavender Ocean Dolphin Phone Strap',
                'category_id' => 2,
                'description' => 'Long, cute phone strap with a dreamy ocean theme. Decorated with iridescent purple seashell beads, heart beads, and finished with a lovely purple dolphin charm.',
                'price' => 75000,
                'stock' => 30,
                'image_url' => 'product_images/ps-5.jpg',
            ],
            // ps-8.jpg: Pastel Loop (Butterfly)
            [
                'name' => 'Rainbow Pastel Butterfly Phone Strap',
                'category_id' => 2,
                'description' => 'Adorable loop-style strap featuring a mix of pastel pink, blue, and purple beads, a large lavender bow, and an iridescent butterfly charm and marble bead.',
                'price' => 65000,
                'stock' => 45,
                'image_url' => 'product_images/ps-8.jpg',
            ],
            // ps-6.jpg: Yellow & Pink Candy Loop
            [
                'name' => 'Sweet Candy Pop Phone Strap',
                'category_id' => 2,
                'description' => 'Fun and colorful loop strap featuring beads and charms in soft yellow and pink. Includes candy wrapper, flower, and heart charms, perfect for a cheerful look.',
                'price' => 60000,
                'stock' => 50,
                'image_url' => 'product_images/ps-6.jpg',
            ],
            // ps-3.jpg: Pink & Blue Under The Sea Loop
            [
                'name' => 'Kawaii Mermaid Bubble Phone Strap',
                'category_id' => 2,
                'description' => 'Vibrant loop strap with a marine theme. Features playful fish, shell, heart, and candy-shaped charms in bright pink, blue, and pastel tones.',
                'price' => 62000,
                'stock' => 48,
                'image_url' => 'product_images/ps-3.jpg',
            ],
            // ps-1.jpg: Blue Bear & Paw Print Loop
            [
                'name' => 'Baby Blue Bear Phone Strap',
                'category_id' => 2,
                'description' => 'Cute loop strap designed with an adorable baby blue theme. Charms include a teddy bear, paw prints, a large heart, and small flower accents.',
                'price' => 68000,
                'stock' => 42,
                'image_url' => 'product_images/ps-1.jpg',
            ],
            // ps-4.jpg: Black & Pink Grunge Aesthetic Loop
            [
                'name' => 'Black Pink 8-Ball Phone Strap',
                'category_id' => 2,
                'description' => 'A trendy strap combining black and soft pink beads. Features a mix of charms including an 8-ball, black bow, heart, and flower for a cute grunge or y2k aesthetic.',
                'price' => 65000,
                'stock' => 55,
                'image_url' => 'product_images/ps-4.jpg',
            ],
            // ps-2.jpg: Dark Black & Silver Stars Loop
            [
                'name' => 'Dark Star Galaxy Phone Strap',
                'category_id' => 2,
                'description' => 'Edgy loop strap primarily in black and silver. Charms include star shapes, ribbon bows, and hearts, perfect for a gothic or sleek dark style.',
                'price' => 70000,
                'stock' => 30,
                'image_url' => 'product_images/ps-2.jpg',
            ],
            // ps-10.jpg: Pink Butterfly Loop
            [
                'name' => 'Iridescent Butterfly Phone Strap',
                'category_id' => 2,
                'description' => 'Loop-style strap dengan manik-manik dan kristal berwarna pink cerah dan putih. Didesain dengan pesona kupu-kupu besar iridescent, hati, pita, dan bunga.',
                'price' => 68000,
                'stock' => 35,
                'image_url' => 'product_images/ps-10.jpg',
            ],
        ]);
    }
}