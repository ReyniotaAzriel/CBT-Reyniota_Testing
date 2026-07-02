<?php

namespace App\Imports;

use App\Models\Soal;
use App\Models\Jawaban;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $ujian_id;

    // Menerima ID ujian dari Controller agar soal masuk ke ujian yang tepat
    public function __construct($ujian_id)
    {
        $this->ujian_id = $ujian_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // 1. Lewati baris jika teks soalnya kosong
            if (empty($row['teks_soal'])) {
                continue;
            }

            // 2. Simpan Teks Soal ke tabel 'soals'
            $soal = Soal::create([
                'ujian_id' => $this->ujian_id,
                'teks_soal' => $row['teks_soal'],
                'tipe_soal' => strtolower($row['tipe_soal']) === 'essay' ? 'essay' : 'pg',
            ]);

            // 3. Jika tipenya PG, buatkan 5 opsi jawaban ke tabel 'jawabans'
            if ($soal->tipe_soal === 'pg') {
                // Pastikan opsi A sampai E ada, jika kosong di excel, isi dengan '-'
                $opsiA = !empty($row['opsi_a']) ? $row['opsi_a'] : '-';
                $opsiB = !empty($row['opsi_b']) ? $row['opsi_b'] : '-';
                $opsiC = !empty($row['opsi_c']) ? $row['opsi_c'] : '-';
                $opsiD = !empty($row['opsi_d']) ? $row['opsi_d'] : '-';
                $opsiE = !empty($row['opsi_e']) ? $row['opsi_e'] : '-';

                $kunci = strtoupper(trim($row['kunci_jawaban']));

                Jawaban::create(['soal_id' => $soal->id, 'teks_jawaban' => $opsiA, 'is_benar' => $kunci === 'A']);
                Jawaban::create(['soal_id' => $soal->id, 'teks_jawaban' => $opsiB, 'is_benar' => $kunci === 'B']);
                Jawaban::create(['soal_id' => $soal->id, 'teks_jawaban' => $opsiC, 'is_benar' => $kunci === 'C']);
                Jawaban::create(['soal_id' => $soal->id, 'teks_jawaban' => $opsiD, 'is_benar' => $kunci === 'D']);
                Jawaban::create(['soal_id' => $soal->id, 'teks_jawaban' => $opsiE, 'is_benar' => $kunci === 'E']);
            }
        }
    }
}
