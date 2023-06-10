<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apotek extends Model
{
    use HasFactory;

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
}
