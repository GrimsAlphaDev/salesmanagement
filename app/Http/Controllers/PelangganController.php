<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = [];
        $pelanggan = Pelanggan::where('status', 'pelanggan')->orderBy('updated_at', 'desc');
        return view('pelanggan.index' , [
            'pelanggan' => $pelanggan->get(),
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
     * @param  \App\Http\Requests\StorePelangganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePelangganRequest $request)
    {
        // if there is no data in Pelanggan table then kode barang kt001
        $countp =  Pelanggan::count() ;
        if($countp == 0){
            $kode = 'KT001';
        }else{
            $kode = 'KT'.str_pad(($countp+1), 3, '0', STR_PAD_LEFT);
        }
        // store data
        $pelanggan = new Pelanggan();
        $pelanggan->kode_toko = $kode;
        $pelanggan->nama_toko = $request->nama_toko;
        $pelanggan->lokasi = $request->lokasi;
        $pelanggan->no_telp = $request->no_telp;
        $pelanggan->status = 'pelanggan';
        $pelanggan->save();
        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil ditambahkan');
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
        // dd($pelanggan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePelangganRequest  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        // dd($request);
        // request
        $request->validate([
            'nama_toko' => 'required|String',
            'lokasi' => 'required|String',
            'no_telp' => 'required|numeric',
        ]);

        // store data
        $pelanggan = Pelanggan::find($pelanggan->id)->update([
            'nama_toko' => $request->nama_toko,
            'lokasi' => $request->lokasi,
            'no_telp' => $request->no_telp,
        ]);

        if($pelanggan){
            return redirect()->route('pelanggan.index')->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->route('pelanggan.index')->with('error', 'Data gagal diubah');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        // dd($pelanggan);
        $pelanggan = Pelanggan::find($pelanggan->id)->delete();

        if($pelanggan){
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}
