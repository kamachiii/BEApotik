<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use App\Helpers\formatAPI;
use App\Traits\ApotekTrait; //Import data return dari file ApotekTrait
use Illuminate\Http\Request;
use Exception;

class ApotekController extends Controller
{
    use ApotekTrait; //Menggunakan ApotekTrait

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
            $obat = $request->obat; // untuk param1 ApotekTrait
            $harga_satuan = $request->harga_satuan; // untuk param2 ApotekTrait

            $data = $this->apotekTrait($obat, $harga_satuan);// membuat var untuk mempersingkat sintaks

            $obat = $data['obat']; // Mendefinisikan var obat
            $harga_satuan = $data['harga_satuan']; // Mendefinisikan var harga_satuan
            $total_harga = $data['total_harga']; // Mendefinisikan var totasl_harga

            $apotek = Apotek::create([
                'nama' => $request->nama,
                'rujukan' => $request->rujukan,
                'rumah_sakit' => $request->rumah_sakit,
                'obat' => $obat,
                'harga_satuan' => $harga_satuan,
                'total_harga' => $total_harga,
                'apoteker' => $request->apoteker
            ]);

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
                'apoteker' => 'required',
            ]);

            $obat = $request->obat;
            $harga_satuan = $request->harga_satuan;

            $data = $this->apotekTrait($obat, $harga_satuan);

            $obat = $data['obat'];
            $harga_satuan = $data['harga_satuan'];
            $total_harga = $data['total_harga'];

            $apotek = Apotek::findorfail($id);

            $apotek->update([
                'nama' => $request->nama,
                'rujukan' => $request->rujukan,
                'rumah_sakit' => $request->rumah_sakit,
                'obat' => $obat,
                'harga_satuan' => $harga_satuan,
                'total_harga' => $total_harga,
                'apoteker' => $request->apoteker,
            ]);

            $getDataSaved = Apotek::where('id', '=', $apotek->id)->get();

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
