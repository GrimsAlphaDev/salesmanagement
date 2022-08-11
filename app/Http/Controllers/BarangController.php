<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = [];
        $barang = Barang::orderBy('updated_at', 'desc');
        return view('barang.index' , [
            'barang' => $barang->get(),
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
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        $barang =  Barang::count() ;
        if($barang == 0){
            $kode = 'KD001';
        }else{
            $kode = 'KD'.str_pad(($barang+1), 3, '0', STR_PAD_LEFT);
        }

        // validate request
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:1',
        ]);

        // store data
        $barang = new Barang();
        $barang->kode_barang = $kode;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga;
        $barang->stok_barang = $request->stok;
        $barang->save();

        if($barang){
            return redirect()->route('barang.index')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->route('barang.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        // validate request
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:1',
        ]);

        // store data
        $barang = Barang::find($barang->id)->update([
            'nama_barang' => $request->nama_barang,
            'harga_barang' => $request->harga,
            'stok_barang' => $request->stok,
        ]);

        if($barang){
            return redirect()->route('barang.index')->with('success', 'Data berhasil diubah');
        }else{
            return redirect()->route('barang.index')->with('error', 'Data gagal diubah');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang = Barang::find($barang->id)->delete();
        if($barang){
            return redirect()->route('barang.index')->with('success', 'Data berhasil dihapus');
        }else{
            return redirect()->route('barang.index')->with('error', 'Data gagal dihapus');
        }
    }
}
