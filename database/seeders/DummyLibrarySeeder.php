<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookItem;
use App\Models\Category;
use App\Models\DdcClass;
use App\Models\StudentClass;
use Illuminate\Database\Seeder;

class DummyLibrarySeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Data Dummy Kelas
        |--------------------------------------------------------------------------
        */
        $classes = [
            ['class_name' => 'VII A', 'level' => 'VII', 'academic_year' => '2025/2026'],
            ['class_name' => 'VII B', 'level' => 'VII', 'academic_year' => '2025/2026'],
            ['class_name' => 'VIII A', 'level' => 'VIII', 'academic_year' => '2025/2026'],
            ['class_name' => 'VIII B', 'level' => 'VIII', 'academic_year' => '2025/2026'],
            ['class_name' => 'IX A', 'level' => 'IX', 'academic_year' => '2025/2026'],
            ['class_name' => 'IX B', 'level' => 'IX', 'academic_year' => '2025/2026'],
        ];

        foreach ($classes as $class) {
            StudentClass::updateOrCreate(
                ['class_name' => $class['class_name'], 'academic_year' => $class['academic_year']],
                $class
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Data Dummy Kategori
        |--------------------------------------------------------------------------
        */
        $categories = [
            'Akidah Akhlak',
            'Sejarah Kebudayaan Islam',
            'Bahasa Indonesia',
            'Matematika',
            'IPA',
            'IPS',
            'Bahasa Inggris',
            'Kamus',
            'Ensiklopedia',
            'Referensi',
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category],
                ['description' => 'Kategori buku ' . $category]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Data Dummy Klasifikasi DDC / Internal
        |--------------------------------------------------------------------------
        */
        $ddcClasses = [
            ['code' => '2X5', 'name' => 'Akidah dan Ilmu Agama', 'description' => 'Klasifikasi internal buku agama Islam'],
            ['code' => '2X9', 'name' => 'Sejarah Kebudayaan Islam', 'description' => 'Klasifikasi internal sejarah Islam'],
            ['code' => '300', 'name' => 'Ilmu-ilmu Sosial', 'description' => 'DDC 300-399'],
            ['code' => '400', 'name' => 'Bahasa', 'description' => 'DDC 400-499'],
            ['code' => '500', 'name' => 'Sains dan Matematika', 'description' => 'DDC 500-599'],
        ];

        foreach ($ddcClasses as $ddc) {
            DdcClass::updateOrCreate(
                ['code' => $ddc['code']],
                $ddc
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Data Dummy Buku
        |--------------------------------------------------------------------------
        */
        $books = [
            [
                'title' => 'Akidah dan Akhlak Jilid 1 Kelas VII',
                'author' => 'Abdullah Nashih',
                'publisher' => 'Erlangga',
                'publication_year' => 2022,
                'category' => 'Akidah Akhlak',
                'ddc' => '2X5',
                'price' => 65000,
                'is_borrowable' => true,
                'description' => 'Buku pelajaran Akidah Akhlak untuk siswa MTs kelas VII.',
                'items' => [
                    ['item_code' => '2X5-ABD-a-001', 'classification_code' => '2X5', 'author_code' => 'ABD', 'title_initial' => 'a', 'copy_number' => 1],
                    ['item_code' => '2X5-ABD-a-002', 'classification_code' => '2X5', 'author_code' => 'ABD', 'title_initial' => 'a', 'copy_number' => 2],
                    ['item_code' => '2X5-ABD-a-003', 'classification_code' => '2X5', 'author_code' => 'ABD', 'title_initial' => 'a', 'copy_number' => 3],
                ],
            ],
            [
                'title' => 'Sejarah Kebudayaan Islam Jilid 3 Kelas IX',
                'author' => 'Mahmud Yunus',
                'publisher' => 'Tiga Serangkai',
                'publication_year' => 2021,
                'category' => 'Sejarah Kebudayaan Islam',
                'ddc' => '2X9',
                'price' => 70000,
                'is_borrowable' => true,
                'description' => 'Buku pelajaran Sejarah Kebudayaan Islam untuk siswa MTs kelas IX.',
                'items' => [
                    ['item_code' => '2X9-MAH-s-001', 'classification_code' => '2X9', 'author_code' => 'MAH', 'title_initial' => 's', 'copy_number' => 1],
                    ['item_code' => '2X9-MAH-s-002', 'classification_code' => '2X9', 'author_code' => 'MAH', 'title_initial' => 's', 'copy_number' => 2],
                    ['item_code' => '2X9-MAH-s-003', 'classification_code' => '2X9', 'author_code' => 'MAH', 'title_initial' => 's', 'copy_number' => 3],
                ],
            ],
            [
                'title' => 'Bahasa Indonesia Kelas VIII',
                'author' => 'Siti Aminah',
                'publisher' => 'Kemendikbud',
                'publication_year' => 2023,
                'category' => 'Bahasa Indonesia',
                'ddc' => '400',
                'price' => 60000,
                'is_borrowable' => true,
                'description' => 'Buku Bahasa Indonesia untuk siswa kelas VIII.',
                'items' => [
                    ['item_code' => '400-SIT-b-001', 'classification_code' => '400', 'author_code' => 'SIT', 'title_initial' => 'b', 'copy_number' => 1],
                    ['item_code' => '400-SIT-b-002', 'classification_code' => '400', 'author_code' => 'SIT', 'title_initial' => 'b', 'copy_number' => 2],
                ],
            ],
            [
                'title' => 'Matematika Kelas VII',
                'author' => 'Budi Santoso',
                'publisher' => 'Erlangga',
                'publication_year' => 2022,
                'category' => 'Matematika',
                'ddc' => '500',
                'price' => 75000,
                'is_borrowable' => true,
                'description' => 'Buku Matematika untuk siswa kelas VII.',
                'items' => [
                    ['item_code' => '500-BUD-m-001', 'classification_code' => '500', 'author_code' => 'BUD', 'title_initial' => 'm', 'copy_number' => 1],
                    ['item_code' => '500-BUD-m-002', 'classification_code' => '500', 'author_code' => 'BUD', 'title_initial' => 'm', 'copy_number' => 2],
                ],
            ],
            [
                'title' => 'IPA Terpadu Kelas VIII',
                'author' => 'Andi Wijaya',
                'publisher' => 'Yudhistira',
                'publication_year' => 2021,
                'category' => 'IPA',
                'ddc' => '500',
                'price' => 80000,
                'is_borrowable' => true,
                'description' => 'Buku IPA Terpadu untuk siswa kelas VIII.',
                'items' => [
                    ['item_code' => '500-AND-i-001', 'classification_code' => '500', 'author_code' => 'AND', 'title_initial' => 'i', 'copy_number' => 1],
                    ['item_code' => '500-AND-i-002', 'classification_code' => '500', 'author_code' => 'AND', 'title_initial' => 'i', 'copy_number' => 2],
                ],
            ],
            [
                'title' => 'IPS Terpadu Kelas IX',
                'author' => 'Rina Lestari',
                'publisher' => 'Grafindo',
                'publication_year' => 2020,
                'category' => 'IPS',
                'ddc' => '300',
                'price' => 72000,
                'is_borrowable' => true,
                'description' => 'Buku IPS Terpadu untuk siswa kelas IX.',
                'items' => [
                    ['item_code' => '300-RIN-i-001', 'classification_code' => '300', 'author_code' => 'RIN', 'title_initial' => 'i', 'copy_number' => 1],
                    ['item_code' => '300-RIN-i-002', 'classification_code' => '300', 'author_code' => 'RIN', 'title_initial' => 'i', 'copy_number' => 2],
                ],
            ],
            [
                'title' => 'Bahasa Inggris Kelas VII',
                'author' => 'John Hermawan',
                'publisher' => 'Erlangga',
                'publication_year' => 2022,
                'category' => 'Bahasa Inggris',
                'ddc' => '400',
                'price' => 68000,
                'is_borrowable' => true,
                'description' => 'Buku Bahasa Inggris untuk siswa kelas VII.',
                'items' => [
                    ['item_code' => '400-JOH-b-001', 'classification_code' => '400', 'author_code' => 'JOH', 'title_initial' => 'b', 'copy_number' => 1],
                    ['item_code' => '400-JOH-b-002', 'classification_code' => '400', 'author_code' => 'JOH', 'title_initial' => 'b', 'copy_number' => 2],
                ],
            ],
            [
                'title' => 'Kamus Bahasa Indonesia',
                'author' => 'Tim Bahasa',
                'publisher' => 'Balai Pustaka',
                'publication_year' => 2019,
                'category' => 'Kamus',
                'ddc' => '400',
                'price' => 95000,
                'is_borrowable' => false,
                'description' => 'Kamus hanya boleh dibaca di tempat.',
                'items' => [
                    ['item_code' => '400-TIM-k-001', 'classification_code' => '400', 'author_code' => 'TIM', 'title_initial' => 'k', 'copy_number' => 1],
                ],
            ],
            [
                'title' => 'Ensiklopedia Sains Dasar',
                'author' => 'Tim Sains',
                'publisher' => 'Gramedia',
                'publication_year' => 2020,
                'category' => 'Ensiklopedia',
                'ddc' => '500',
                'price' => 150000,
                'is_borrowable' => false,
                'description' => 'Ensiklopedia hanya boleh dibaca di tempat.',
                'items' => [
                    ['item_code' => '500-TIM-e-001', 'classification_code' => '500', 'author_code' => 'TIM', 'title_initial' => 'e', 'copy_number' => 1],
                ],
            ],
            [
                'title' => 'Buku Referensi Guru Matematika',
                'author' => 'Suparman',
                'publisher' => 'Erlangga',
                'publication_year' => 2021,
                'category' => 'Referensi',
                'ddc' => '500',
                'price' => 120000,
                'is_borrowable' => false,
                'description' => 'Buku referensi guru, tidak untuk dipinjam pulang.',
                'items' => [
                    ['item_code' => '500-SUP-b-001', 'classification_code' => '500', 'author_code' => 'SUP', 'title_initial' => 'b', 'copy_number' => 1],
                ],
            ],
        ];

        foreach ($books as $bookData) {
            $category = Category::where('name', $bookData['category'])->first();
            $ddcClass = DdcClass::where('code', $bookData['ddc'])->first();

            $book = Book::updateOrCreate(
                [
                    'title' => $bookData['title'],
                    'author' => $bookData['author'],
                ],
                [
                    'publisher' => $bookData['publisher'],
                    'publication_year' => $bookData['publication_year'],
                    'category_id' => $category?->id,
                    'ddc_class_id' => $ddcClass?->id,
                    'price' => $bookData['price'],
                    'is_borrowable' => $bookData['is_borrowable'],
                    'description' => $bookData['description'],
                ]
            );

            foreach ($bookData['items'] as $item) {
                BookItem::updateOrCreate(
                    ['item_code' => $item['item_code']],
                    [
                        'book_id' => $book->id,
                        'classification_code' => $item['classification_code'],
                        'author_code' => $item['author_code'],
                        'title_initial' => $item['title_initial'],
                        'copy_number' => $item['copy_number'],
                        'status' => 'tersedia',
                        'condition' => 'baik',
                        'location' => 'Rak Utama',
                        'acquisition_date' => now()->toDateString(),
                    ]
                );
            }
        }
    }
}