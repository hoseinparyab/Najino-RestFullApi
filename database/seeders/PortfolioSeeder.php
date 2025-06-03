<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'فروشگاه آنلاین دیجی‌کالا',
                'description' => 'طراحی و توسعه فروشگاه آنلاین با امکانات کامل فروشگاهی، سبد خرید، درگاه پرداخت و پنل مدیریت',
                'site_address' => 'https://digikala.com',
                'our_job' => 'طراحی و توسعه کامل پروژه',
                'cover_image' => 'portfolios/digikala-cover.jpg',
                'images' => [
                    'portfolios/digikala-1.jpg',
                    'portfolios/digikala-2.jpg',
                    'portfolios/digikala-3.jpg'
                ]
            ],
            [
                'title' => 'اپلیکیشن اسنپ',
                'description' => 'توسعه بخش‌های مختلف اپلیکیشن درخواست خودرو، شامل سیستم مسیریابی و پرداخت آنلاین',
                'site_address' => 'https://snapp.ir',
                'our_job' => 'توسعه بک‌اند و API',
                'cover_image' => 'portfolios/snapp-cover.jpg',
                'images' => [
                    'portfolios/snapp-1.jpg',
                    'portfolios/snapp-2.jpg'
                ]
            ],
            [
                'title' => 'سایت شرکتی ایران‌خودرو',
                'description' => 'طراحی و پیاده‌سازی وبسایت شرکتی با قابلیت نمایش محصولات، اخبار و ارتباط با مشتریان',
                'site_address' => 'https://ikco.ir',
                'our_job' => 'طراحی UI/UX و توسعه فرانت‌اند',
                'cover_image' => 'portfolios/ikco-cover.jpg',
                'images' => [
                    'portfolios/ikco-1.jpg',
                    'portfolios/ikco-2.jpg',
                    'portfolios/ikco-3.jpg',
                    'portfolios/ikco-4.jpg'
                ]
            ]
        ];

        // Create sample image files
        foreach ($portfolios as $portfolio) {
            // Create cover image
            Storage::disk('public')->put(
                $portfolio['cover_image'], 
                file_get_contents(base_path('public/sample-images/placeholder.jpg'))
            );

            // Create portfolio images
            foreach ($portfolio['images'] as $image) {
                Storage::disk('public')->put(
                    $image,
                    file_get_contents(base_path('public/sample-images/placeholder.jpg'))
                );
            }

            // Create portfolio record
            Portfolio::create($portfolio);
        }
    }
}
