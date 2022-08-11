<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ProspekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prospek = [];
        $prospek = Pelanggan::where('status', 'prospek')->orderBy('updated_at', 'desc');

        return view('prospek.index' , [
            'prospek' => $prospek->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if there is no data in Pelanggan table then kode barang kt001
        $countp =  Pelanggan::count() ;
        if($countp == 0){
            $kode = 'KT001';
        }else{
            $kode = 'KT'.str_pad(($countp+1), 3, '0', STR_PAD_LEFT);
        }


        // validate
        $request->validate([
            'nama_toko' => 'required|String',
            'lokasi' => 'required|String',
            'no_telp' => 'required|numeric',
        ]);

        // store data
        $prospek = new Pelanggan();
        $prospek->kode_toko = $kode;
        $prospek->nama_toko = $request->nama_toko;
        $prospek->lokasi = $request->lokasi;
        $prospek->no_telp = $request->no_telp;
        $prospek->status = 'prospek';
        $prospek->save();

        if($prospek){
            return redirect()->route('prospek.index')->with('success', 'Prospek berhasil ditambahkan');
        }else{
            return redirect()->route('prospek.index')->with('error', 'Prospek gagal ditambahkan');
        }



        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        // validate data
        $request->validate([
            'nama_toko' => 'required|String',
            'lokasi' => 'required|String',
            'no_telp' => 'required|numeric',
        ]);
       
        
        // edit data

        $pelanggan = Pelanggan::find($request->id)->update([
            'nama_toko' => $request->nama_toko,
            'lokasi' => $request->lokasi,
            'no_telp' => $request->no_telp,
        ]);

        if($pelanggan){
            return redirect()->route('prospek.index')->with('success', 'Prospek berhasil diubah');
        } else {
            return redirect()->route('prospek.index')->with('error', 'Prospek gagal diubah');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan , Request $request)
    {
        //  delete data
        $pelanggan = Pelanggan::find($request->id)->delete();
        if($pelanggan){
            return redirect()->route('prospek.index')->with('success', 'Prospek berhasil dihapus');
        } else {
            return redirect()->route('prospek.index')->with('error', 'Prospek gagal dihapus');
        }
    }
}
