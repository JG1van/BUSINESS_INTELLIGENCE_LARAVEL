<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangIlmu extends Model
{
    use HasFactory;

    protected $table = 'bidang_ilmu';
    protected $primaryKey = 'id_bidang_ilmu';
    protected $fillable = ['nama_bidang_ilmu'];
    public $timestamps = false;
}
