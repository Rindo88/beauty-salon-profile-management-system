<?php

namespace Database\Seeders;

use App\Models\GalleryPhoto;
use App\Models\OperatingHour;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class InitialContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Service::count() === 0) {
            Service::insert([
                ['name' => 'Haircut', 'category' => 'Rambut', 'duration_minutes' => 60, 'price_cents' => 15000000, 'is_popular' => true, 'description' => 'Potong rambut profesional.'],
                ['name' => 'Hair Coloring', 'category' => 'Rambut', 'duration_minutes' => 120, 'price_cents' => 35000000, 'is_popular' => true, 'description' => 'Pewarnaan rambut premium.'],
                ['name' => 'Manicure', 'category' => 'Kuku', 'duration_minutes' => 60, 'price_cents' => 12000000, 'is_popular' => false, 'description' => 'Perawatan kuku tangan.'],
                ['name' => 'Pedicure', 'category' => 'Kuku', 'duration_minutes' => 60, 'price_cents' => 13000000, 'is_popular' => false, 'description' => 'Perawatan kuku kaki.'],
            ]);
        }
        if (Product::count() === 0) {
            Product::insert([
                ['name' => 'Shampoo Premium', 'category' => 'Hair Care', 'price_cents' => 8000000, 'description' => 'Membersihkan dan menutrisi rambut.', 'is_new' => true],
                ['name' => 'Hair Serum', 'category' => 'Hair Care', 'price_cents' => 15000000, 'description' => 'Serum penguat rambut.', 'discount_percent' => 10],
            ]);
        }
        if (Testimonial::count() === 0) {
            Testimonial::insert([
                ['customer_name' => 'Dina', 'rating' => 5, 'content' => 'Pelayanan sangat memuaskan!', 'is_featured' => true],
                ['customer_name' => 'Rudi', 'rating' => 4, 'content' => 'Stylist ramah dan profesional.', 'is_featured' => false],
            ]);
        }
        if (GalleryPhoto::count() === 0) {
            for ($i = 1; $i <= 12; $i++) {
                GalleryPhoto::create(['category' => 'Interior', 'image_path' => 'images/sample'.$i.'.jpg', 'alt_text' => 'Foto '.$i, 'sort_order' => $i]);
            }
        }
        if (OperatingHour::count() === 0) {
            $map = [1, 2, 3, 4, 5, 6, 0];
            foreach ($map as $d) {
                OperatingHour::create([
                    'day_of_week' => $d,
                    'open_time' => '09:00:00',
                    'close_time' => '18:00:00',
                    'is_closed' => $d === 0,
                ]);
            }
        }
    }
}
