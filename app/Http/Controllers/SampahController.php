<?php

namespace App\Http\Controllers;

use App\Helpers\formatApi;
use App\Models\Sampah;
use Exception;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data= Sampah::orderBy('id')->get(); // mengambil semua data

        if ($request->query('search_no_rumah')){// membuat pencarian berdasarkan Nomor Rumah
            $search = $request->query('search_no_rumah');

            $data = Sampah::where('no_rumah', $search)->orderBy('id')->get();
            if($request->query('limit')) {
                $limit = $request->query('limit');

                $data = Sampah::where('no_rumah', $search)->limit($limit)->get();
            }
        }

        if($data){
            return formatApi::createAPI(200, 'berhasil', $data);
            // return dd($data);
         }else{
            return formatApi::createAPI(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $kriteria = $request->total_karung_sampah > 3 ? 'collapse' : 'standar';
            $sampah = Sampah::create([
                'kepala_keluarga' => $request->kepala_keluarga,
                'no_rumah' => $request->no_rumah,
                'rt_rw' => $request->rt_rw,
                'total_karung_sampah' => $request->total_karung_sampah,
                'tanggal_pengangkutan' => $request->tanggal_pengangkutan,
                'kriteria' => $kriteria
            ]);

            $data = Sampah::where('id','=',$sampah->id)->get();
            if($data){
                return formatApi::createAPI(200, 'berhasil', $data);
             }else{
                return formatApi::createAPI(400, 'Failed');
            }

        }catch(Exception $error){
            // dd($error);
            return formatApi::createAPI(400, 'Gagal', $error);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sampah  $sampah
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Sampah::where('id', '=',$id)->first();
            if($data){
                return formatApi::createAPI(200, 'berhasil', $data);
             }else{
                return formatApi::createAPI(400, 'Failed');
            }

        }catch(Exception $error){
            return formatApi::createAPI(400, 'Failed',$error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sampah  $sampah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sampah $sampah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sampah  $sampah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sampah = Sampah::findorfail($id);
        $kriteria = $request->total_karung_sampah > 3 ? 'collapse' : 'standar';
        $sampah->update([
            'kepala_keluarga' => $request->kepala_keluarga,
            'no_rumah' => $request->no_rumah,
            'rt_rw' => $request->rt_rw,
            'total_karung_sampah' => $request->total_karung_sampah,
            'tanggal_pengangkutan' => $request->tanggal_pengangkutan,
            'kriteria' => $kriteria
        ]);

            $sampah = Sampah::where('id', $id)->get();

            if($sampah) {
                return formatApi::createAPI(200, 'Berhasil', $sampah);
            }else{
                return formatApi::createAPI(400, 'Gagal', );
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sampah  $sampah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $sampah = Sampah::findOrFail($id);
            $data = $sampah->delete();
            if($data){
                return formatApi::createAPI(200, 'berhasil');
            }else{
                return formatApi::createAPI(400, 'gagal');
            }

        }catch(Exception $error){
            return formatApi::createAPI(400, 'gagal', $error);

        }
    }

    //? Trash function

    public function getTrash()
    {
        try {
            $data = Sampah::onlyTrashed()->get(); // mengambil semua data

            if($data){
                return formatApi::createAPI(200, 'berhasil', $data);
            }else{
                return formatApi::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatApi::createAPI(400, 'gagal', $error);

        }
    }

    public function restore($id)
    {
        try{
            $data = Sampah::onlyTrashed()->findorfail($id);
            $data->restore();
            $data = Sampah::where('id', $id)->get();

            if($data){
                return formatApi::createAPI(200, 'berhasil', $data);
            }else{
                return formatApi::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatApi::createAPI(400, 'gagal', $error);

        }
    }

    public function deleteTrash($id)
    {
        try{
            $data = Sampah::onlyTrashed()->findorfail($id);
            $data = $data->forceDelete();

            if($data){
                return formatApi::createAPI(200, 'berhasil', $data);
            }else{
                return formatApi::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatApi::createAPI(400, 'gagal', $error);

        }
    }
}
