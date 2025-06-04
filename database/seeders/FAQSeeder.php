<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FAQ::create([
            'question' => 'چگونه می‌توانم ثبت‌نام کنم؟',
            'answer' => 'برای ثبت‌نام، به صفحه اصلی بروید و روی دکمه "ثبت‌نام" کلیک کنید. سپس اطلاعات خود را وارد کنید.',
            'is_active' => true,
        ]);

        FAQ::create([
            'question' => 'چگونه می‌توانم با پشتیبانی تماس بگیرم؟',
            'answer' => 'می‌توانید از طریق فرم تماس در صفحه "تماس با ما" با پشتیبانی تماس بگیرید.',
            'is_active' => true,
        ]);

        FAQ::create([
            'question' => 'آیا خدمات شما رایگان است؟',
            'answer' => 'برخی از خدمات ما رایگان هستند، اما برای دسترسی به امکانات پیشرفته باید اشتراک خریداری کنید.',
            'is_active' => true,
        ]);
    }
}
