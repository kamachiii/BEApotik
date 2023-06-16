<?php

namespace App\Http\Controllers;

use App\Helpers\formatApi;
use App\Models\Rental;
use Exception;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data= Rental::orderBy('id')->get(); // mengambil semua data

        if ($request->query('search_supir')){// membuat pencarian berdasarkan Supir
            $search = $request->query('search_supir');

            $data = Rental::where('supir', $search)->orderBy('id')->get();
            if($request->query('limit')) {
                $limit = $request->query('limit');

                $data = Rental::where('supir', $search)->limit($limit)->get();
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
            $total_harga = $request->waktu_jam * 150000;
            $rental = Rental::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'type' => $request->type,
                'waktu_jam' => $request->waktu_jam,
                'total_harga' => $total_harga,
                'jam_mulai' => $request->jam_mulai,
                'supir' => $request->supir,
                'status' => 'proses'
            ]);

            $data = Rental::where('id','=',$rental->id)->get();
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
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Rental::where('id', '=',$id)->first();
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
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rental = Rental::findorfail($id);
        $riwayat = "Dimulai pada jam $rental->jam_mulai dengan titik penjemputan di $rental->alamat. dan selesai pada jam $request->jam_selesai dengan titik akhir di $request->tempat_tujuan.";

            $rental->update([
                'jam_selesai' => $request->jam_selesai,
                'tempat_tujuan' => $request->tempat_tujuan,
                'riwayat_perjalanan' => $riwayat,
                'status' => 'selesai'
            ]);

            $rental = Rental::where('id', $id)->get();

            if($rental) {
                return formatApi::createAPI(200, 'Berhasil', $rental);
            }else{
                return formatApi::createAPI(400, 'Gagal', );
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $rental = Rental::findOrFail($id);
            $data = $rental->delete();
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
            $data = Rental::onlyTrashed()->get(); // mengambil semua data

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
            $data = Rental::onlyTrashed()->findorfail($id);
            $data = $data->restore();
            $data = Rental::where('id', $id)->get();

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
            $data = Rental::onlyTrashed()->findorfail($id);
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
