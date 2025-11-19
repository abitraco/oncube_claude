<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\QuoteRequest;

class TestQuoteRequestSeeder extends Seeder
{
    public function run()
    {
        QuoteRequest::create([
            'company_email' => 'test@example.com',
            'company_name' => 'Test Company Ltd',
            'phone' => '+82-10-1234-5678',
            'contact_name' => 'John Doe',
            'inquiry_type' => '견적문의',
            'quantity' => '100',
            'message' => 'We need a quote for 100 units of industrial equipment. Please provide pricing for bulk order.',
            'privacy_agreed' => true,
            'locale' => 'en',
            'status' => 'pending',
        ]);

        QuoteRequest::create([
            'company_email' => 'kim@koreancompany.co.kr',
            'company_name' => '한국 반도체 주식회사',
            'phone' => '+82-2-1234-5678',
            'contact_name' => 'Kim Min-soo',
            'inquiry_type' => '대량구매',
            'quantity' => '500',
            'message' => '반도체 장비 500개 구매 희망합니다.',
            'privacy_agreed' => true,
            'locale' => 'ko',
            'status' => 'pending',
        ]);

        echo "Created 2 test quote requests\n";
    }
}
