<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;


class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = [];
        $penjualan = Penjualan::orderBy('updated_at', 'desc');
        $barang = Barang::all();
        $pelanggan = Pelanggan::where('status', '=','pelanggan');
        $user = User::where('roles', 'sales');
        return view('penjualan.index' , [
            'penjualan' => $penjualan->get(),
            'barang' => $barang,
            'pelanggan' => $pelanggan->get(),
            'user' => $user->get(),
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
     * @param  \App\Http\Requests\StorePenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenjualanRequest $request)
    {
        // get harga from barang
        $barang = Barang::where('id', $request->nama_barang)->first();
        // count barang keluar * barang
        $total = $request->barang_keluar * $barang->harga_barang;

        // validate request
        $request->validate([
            'nama_barang' => 'required|integer|max:255',
            'nama_pelanggan' => 'required|integer',
            'nama_user' => 'required|integer',
            'barang_keluar' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        // store data
        $penjualan = new Penjualan();
        $penjualan->pelanggan_id = $request->nama_pelanggan;
        $penjualan->barang_id = $request->nama_barang;
        $penjualan->user_id = $request->nama_user;
        $penjualan->barang_keluar = $request->barang_keluar;
        $penjualan->total_harga = $total;
        $penjualan->status = $request->status;
        $penjualan->save();

        if($penjualan){
            return redirect()->route('penjualan.index')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->route('penjualan.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        return view('penjualan.faktur', [
            'penjualan' => $penjualan,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanRequest  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        // delete data
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus');

    }


}
