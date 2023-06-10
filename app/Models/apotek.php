<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apotek extends Model
{
    use SoftDeletes; //Pemanggilan Fungsi laravel SoftDelete

    protected $table = 'apotek';

    protected $casts = [
        'obat' => 'array',
        'harga_satuan' => 'array'
    ];

    protected $fillable = [
        'nama',
        'rujukan',
        'rumah_sakit',
        'obat',
        'harga_satuan',
        'total_harga',
        'apoteker'
    ];

    protected $dates = ['deleted_at']; // mendefinisikan kepada laravel fitur softdelete
}
