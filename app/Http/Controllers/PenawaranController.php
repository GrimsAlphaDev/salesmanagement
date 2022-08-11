<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Http\Requests\StorePenawaranRequest;
use App\Http\Requests\UpdatePenawaranRequest;
use Illuminate\Http\Request;

class PenawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penawaran = [];
        $penawaran = Penawaran::orderBy('updated_at', 'desc');
        $barang = \App\Models\Barang::all();
        return view('penawaran.index' , [
            'penawaran' => $penawaran->get(),
            'barang' => $barang,
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
     * @param  \App\Http\Requests\StorePenawaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenawaranRequest $request)
    {
        // validate
        $request->validate(
            [
                'kode_barang' => 'required',
                'harga_penawaran' => 'required',
                'stok_barang' => 'required',
            ]
        );

        // store
        $penawaran = new Penawaran();
        $penawaran->id_barang = $request->kode_barang;
        $penawaran->harga_penawaran = $request->harga_penawaran;
        $penawaran->stok_barang = $request->stok_barang;
        $penawaran->save();

        if($penawaran) {
            return redirect()->route('penawaran.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('penawaran.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penawaran  $penawaran
     * @return \Illuminate\Http\Response
     */
    public function show(Penawaran $penawaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penawaran  $penawaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Penawaran $penawaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenawaranRequest  $request
     * @param  \App\Models\Penawaran  $penawaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penawaran $penawaran)
    {
        // validate
        $request->validate(
            [
                'kode_barang' => 'required',
                'harga_penawaran' => 'required',
                'stok_barang' => 'required',
            ]
        );

        // update
        $penawaran = Penawaran::find($request->id)->update([
            'id_barang' => $request->kode_barang,
            'harga_penawaran' => $request->harga_penawaran,
            'stok_barang' => $request->stok_barang,
        ]);

        if($penawaran) {
            return redirect()->route('penawaran.index')->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->route('penawaran.index')->with('error', 'Data gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penawaran  $penawaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penawaran $penawaran, Request $request)
    {
        // delete
        $penawaran = Penawaran::find($request->id)->delete();
        if($penawaran) {
            return redirect()->route('penawaran.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('penawaran.index')->with('error', 'Data gagal dihapus');
        }
    }
}
