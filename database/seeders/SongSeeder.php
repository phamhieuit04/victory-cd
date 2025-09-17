<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SongSeeder extends Seeder
{
    private $names = [
        "Em của ngày hôm qua",
        "Chúng ta của hiện tại",
        "Lạc trôi",
        "Ước gì",
        "Họa mi tóc nâu",
        "Đừng hỏi em",
        "Hai triệu năm",
        "Trốn tìm",
        "Mang tiền về cho mẹ",
        "Tháng tư là lời nói dối của em",
        "Người con gái ta thương",
        "Xuân thì",
        "Có em chờ",
        "Ghen",
        "Trên tình bạn dưới tình yêu"
    ];

    private $thumbnails = [
        "em_cua_ngay_hom_qua.png",
        "chung_ta_cua_hien_tai.png",
        "lac_troi.png",
        "uoc_gi.png",
        "hoa_mi_toc_nau.png",
        "dung_hoi_em.png",
        "hai_trieu_nam.png",
        "tron_tim.png",
        "mang_tien_ve_cho_me.png",
        "thang_tu_la_loi_noi_doi_cua_em.png",
        "nguoi_con_gai_ta_thuong.png",
        "xuan_thi.png",
        "co_em_cho.png",
        "ghen.png",
        "tren_tinh_ban_duoi_tinh_yeu.png"
    ];

    private $files = [
        "em_cua_ngay_hom_qua.mp3",
        "chung_ta_cua_hien_tai.mp3",
        "lac_troi.mp3",
        "uoc_gi.mp3",
        "hoa_mi_toc_nau.mp3",
        "dung_hoi_em.mp3",
        "hai_trieu_nam.mp3",
        "tron_tim.mp3",
        "mang_tien_ve_cho_me.mp3",
        "thang_tu_la_loi_noi_doi_cua_em.mp3",
        "nguoi_con_gai_ta_thuong.mp3",
        "xuan_thi.mp3",
        "co_em_cho.mp3",
        "ghen.mp3",
        "tren_tinh_ban_duoi_tinh_yeu.mp3"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->names as $index => $name) {
            $userId = intdiv($index, 3) + 1;
            DB::table('songs')->insert([
                'name' => $name,
                'user_id' => $userId,
                'thumbnail_url' => env('APP_URL') . '/public/uploads/thumbnails/' . $this->thumbnails[$index],
                'song_url' => env('APP_URL') . '/public/uploads/songs/' . $this->files[$index],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
