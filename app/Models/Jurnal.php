<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';
    protected $primaryKey = 'id_jurnal';

    protected $fillable = [
        'id_user',
        'id_bidang_ilmu',
        'nama_jurnal',
        'singkatan',
        'link',
        'issn',
        'e_issn',
        'bidang',
        'industri',
        'akreditasi_sinta',
        'masa_aktif_sinta',
        'scopus_index',
        'masa_aktif_scopus',
        'penerbit',
        'kota_terbit',
    ];

    public function bidangIlmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'id_bidang_ilmu');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
