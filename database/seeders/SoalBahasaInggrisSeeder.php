<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Jawaban;

class SoalBahasaInggrisSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari Mata Pelajaran Bahasa Inggris secara spesifik
        $mapel = \App\Models\MataPelajaran::where('nama_pelajaran', 'Bahasa Inggris')->first();

        if (!$mapel) {
            $this->command->error('Mata Pelajaran "Bahasa Inggris" belum ada di database! Silakan jalankan seeder mapel dulu.');
            return;
        }

        // 2. Cari Ujian yang terhubung dengan mapel Bahasa Inggris tersebut
        $ujian = \App\Models\Ujian::where('mata_pelajaran_id', $mapel->id)->first();

        if (!$ujian) {
            $this->command->error('Jadwal ujian untuk Bahasa Inggris belum dibuat!');
            return;
        }

        // $this->command->info('Menambahkan soal untuk ujian: ' . $ujian->judul_ujian);

        // ==========================================
        // 2. MEMBUAT 45 SOAL PILIHAN GANDA (PG)
        // ==========================================

        // 5 Soal PG Manual (Realistis)
        $soalPGManual = [
            [
                'teks' => 'What is the synonym of the word "Diligent"?',
                'opsi' => ['Lazy', 'Hardworking', 'Careless', 'Dumb', 'Slow'],
                'kunci' => 1 // Hardworking (Index 1)
            ],
            [
                'teks' => 'Complete the sentence: "If I _____ enough money, I would buy a new laptop."',
                'opsi' => ['have', 'has', 'had', 'having', 'am having'],
                'kunci' => 2 // had (Index 2)
            ],
            [
                'teks' => 'The announcement is mainly about...',
                'opsi' => ['School holiday', 'Meeting cancellation', 'New student registration', 'Extracurricular activity', 'Lost item'],
                'kunci' => 1 // Meeting cancellation
            ],
            [
                'teks' => 'Which of the following sentences is grammatically correct?',
                'opsi' => ['She don\'t like apples.', 'He are going to the market.', 'They has finished their homework.', 'I am reading a book now.', 'We was at the park yesterday.'],
                'kunci' => 3 // I am reading a book now.
            ],
            [
                'teks' => 'Arrange these words into a good sentence: (1) studying - (2) am - (3) English - (4) I - (5) now',
                'opsi' => ['4-2-1-3-5', '4-1-2-3-5', '1-2-3-4-5', '2-4-1-3-5', '4-3-2-1-5'],
                'kunci' => 0 // 4-2-1-3-5
            ],
        ];

        // Memasukkan 5 Soal PG Manual ke database
        foreach ($soalPGManual as $item) {
            $soal = Soal::create([
                'ujian_id'  => $ujian->id,
                'teks_soal' => $item['teks'],
                'tipe_soal' => 'pg',
            ]);

            foreach ($item['opsi'] as $index => $teksOpsi) {
                Jawaban::create([
                    'soal_id'      => $soal->id,
                    'teks_jawaban' => $teksOpsi,
                    'is_benar'     => ($index === $item['kunci']),
                ]);
            }
        }

        // Memasukkan 10 Soal PG Dummy (Auto-Generate menggunakan perulangan)
        for ($i = 6; $i <= 10; $i++) {
            $soal = Soal::create([
                'ujian_id'  => $ujian->id,
                'teks_soal' => "Read the following text to answer question number $i. According to the passage, what is the main idea of paragraph 2?",
                'tipe_soal' => 'pg',
            ]);

            $kunciRandom = rand(0, 4); // Acak kunci jawaban antara opsi A sampai E (index 0 - 4)

            $opsiDummy = [
                'The importance of reading.',
                'How to improve speaking skills.',
                'The negative impact of social media.',
                'Steps to write a good essay.',
                'The history of the English language.'
            ];

            foreach ($opsiDummy as $index => $teksOpsi) {
                Jawaban::create([
                    'soal_id'      => $soal->id,
                    'teks_jawaban' => $teksOpsi . " (Option variation $i)",
                    'is_benar'     => ($index === $kunciRandom),
                ]);
            }
        }

        // ==========================================
        // 3. MEMBUAT 5 SOAL ESSAY
        // ==========================================

        $soalEssay = [
            'Write a short paragraph describing your unforgettable holiday experience. Ensure you use the Simple Past Tense.',
            'Explain the difference between "Skimming" and "Scanning" in reading techniques. Provide an example for each.',
            'Read the following statement: "Technology has made human communication less personal." Do you agree or disagree? Support your answer with two arguments.',
            'Translate the following paragraph into correct and natural English: "Kemarin, saya pergi ke pasar tradisional bersama ibu saya. Kami membeli banyak sayuran segar dan buah-buahan untuk persiapan pesta keluarga besok."',
            'Write a formal invitation letter to the school principal, inviting him/her to attend the annual English Speech Contest as a guest of honor.'
        ];

        foreach ($soalEssay as $teksEssay) {
            Soal::create([
                'ujian_id'  => $ujian->id,
                'teks_soal' => $teksEssay,
                'tipe_soal' => 'essay', // Status tipe soal essay agar terbaca oleh Livewire
            ]);
            // Soal essay tidak memerlukan insert data ke tabel jawabans
        }

        // $this->command->info('Sukses: 45 Soal PG dan 5 Soal Essay berhasil ditambahkan!');
    }
}
