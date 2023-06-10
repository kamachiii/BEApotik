<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use App\Helpers\formatAPI;
use Illuminate\Http\Request;
use Exception;

class ApotekController extends Controller
{
    public function index()
    {
        $data= Apotek::all();


        if($data){
            return formatAPI::createAPI(200, 'berhasil', $data);
         }else{
            return formatAPI::createAPI(400, 'Failed');
        }
    }

    public function store(Request $request)
    {
        try{
            $apotek = Apotek::create($request->all());

            $data = Apotek::where('id','=',$apotek->id)->get();
            if($data){
                return formatAPI::createAPI(200, 'berhasil', $data);
             }else{
                return formatAPI::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'Gagal',$error);
        }
    }

    public function show($id)
    {
        try{
            $data = Apotek::where('id', '=',$id)->first();
            if($data){
                return formatAPI::createAPI(200, 'berhasil', $data);
             }else{
                return formatAPI::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'Failed',$error);
        }
    }
    public function update(Request $request, $id)
    {
        try{

            $request->validate([
                'nama' => 'required',
                'rujukan' => 'required',
                'rumah_sakit' => 'required',
                'obat' => 'required',
                'harga_satuan' => 'required',
                'total_harga' => 'required',
                'apoteker' => 'required',
            ]);

            $obat = preg_split("/[,]", $request->obat);
            $harga = array_map('intval', explode(',', $request->harga_satuan));

            $apotek = Apotek::create([
                'nama' => $request->nama,
                'rujukan' => $request->rujukan,
                'rumah_sakit' => $request->rumah_sakit,
                'obat' => $obat,
                'harga_Satuan' => $harga,
                'total_harga' => $request->total_harga,
                'apoteker' => $request->apoteker,
            ]);

            $getDataSaved = Apotek::where('id', '=', $apotek->id)->first();

            if($getDataSaved) {
                return formatAPI::createAPI(200, 'Berhasil', $getDataSaved);
            }else{
                return formatAPI::createAPI(400, 'Gagal', );
            }

            
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'Gagal',$error);
        }

        
    }
    
    public function destroy($id){
        try{
            $apotek = apotek::findOrFail($id);
            $data = $apotek->delete();
            if($data){
                return formatAPI::createAPI(200, 'berhasil');
            }else{
                return formatAPI::createAPI(400, 'gagal');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'gagal', $error);
        }
    }
}
