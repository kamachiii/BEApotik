<?php

namespace App\Http\Controllers;

use App\Models\apotek;
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
            $apotek = apotek::create($request->all());

            $data = apotek::where('id','=',$apotek->id)->get();
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
            $data = apotek::where('id', '=',$id)->first();
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
            $apotek = apotek::findorfail($id);
            $apotek->update($request->all());

            $data = apotek::where('id','=',$apotek->id)->get();
            if($data){
                return formatAPI::createAPI(200, 'berhasil', $data);
             }else{
                return formatAPI::createAPI(400, 'Failed');
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
