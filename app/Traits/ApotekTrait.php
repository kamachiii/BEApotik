<?php

namespace App\Traits;

trait ApotekTrait
{
    public function apotekTrait($obat, $harga_satuan)
    {
        $obat = explode(", ", $obat);
        $obat = array_map('trim', $obat);

        $harga_satuan = explode(", ", $harga_satuan);
        $harga_satuan = array_map('trim', $harga_satuan);

        if (is_array($harga_satuan)) {
            $total_harga = array_sum($harga_satuan);
        }

        return [
            'obat' => $obat,
            'harga_satuan' => $harga_satuan,
            'total_harga' => $total_harga,
        ];
    }
}
