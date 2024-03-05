<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class cms_pagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cms_pages_record = [
            ['id' => 1, 'title' => 'About Us', 'description' => 'Cooming Soon', 'url' => 'about-us', 'meta_title' => 'about us', 'meta_description' => 'About us content', 'mata_keywords' => 'about us', 'ststus' => 1],
            ['id' => 2, 'title' => 'Privacy Policy', 'description' => 'Cooming Soon', 'url' => 'privacy-policy', 'meta_title' => 'privacy policy', 'meta_description' => 'privacy policy content', 'mata_keywords' => 'privacy policy', 'ststus' => 1],
            ['id' => 3, 'title' => 'Terms & Conitions', 'description' => 'Cooming Soon', 'url' => 'terms-condition', 'meta_title' => 'Terms Condition', 'meta_description' => 'Terms Condition content', 'mata_keywords' => 'Terms Condition', 'ststus' => 1],
        ];
        CmsPage::insert($cms_pages_record);
    }
}
