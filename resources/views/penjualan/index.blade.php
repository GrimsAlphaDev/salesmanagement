@extends('../layouts/main')

@section('currentpage', 'Data Penjualan')

@section('content')
    <div class="row">
        {{-- show alert --}}
        @if (session('success'))
            <div class="alert alert-success">
                <p class="text-white">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <p class="text-white">{{ session('error') }}</p>
            </div>
        @endif

        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Data Penjualan</h3>
                </div>
                <div class="card-body">
                    {{-- add barang with modal --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Penjualan
                    </button>
                    {{-- table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Penjualan</th>
                                    <th>Nama Toko</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Sales</th>
                                    <th>Barang Keluar</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>KP00{{ $item->id }}</td>
                                        <td>{{ $item->pelanggan->nama_toko}}</td>
                                        <td>{{ $item->barang->nama_barang }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->barang_keluar }}</td>
                                        <td>{{ $item->barang->harga_barang }}</td>
                                        <td>Rp. <?= number_format($item->total_harga) ?></td>
                                        <td>
                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $item->id }} ">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form> 
                                            {{-- show penjualan --}}
                                            <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-primary btn-sm">
                                                Print Faktur
                                            </a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- cetak laporan --}}
                        <div class="text-center">
                        <button onclick="window.print()" class="btn btn-primary">Print laporan</button>
                    </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- modal for tambah penjualan --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penjualan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('penjualan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="roles" value="penjualan">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                {{-- select from barang table --}}
                                <select name="nama_barang" id="nama_barang" class="form-control">
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_barang }}  - Rp. <?= number_format($item->harga_barang) ?></option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- pelanggan --}}
                            <div class="form-group">
                                <label for="nama_pelanggan">Nama Pelanggan</label>
                                {{-- select from pelanggan table --}}
                                <select name="nama_pelanggan" id="nama_pelanggan" class="form-control">
                                    @foreach ($pelanggan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_toko }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- select user --}}
                            <div class="form-group">
                                <label for="nama_user">Nama User</label>
                                {{-- select from user table --}}
                                <select name="nama_user" id="nama_user" class="form-control">
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- barang keluar --}}
                            <div class="form-group">
                                <label for="barang_keluar">Barang Keluar</label>
                                <input type="number" name="barang_keluar" id="barang_keluar" class="form-control"
                                    placeholder="Barang Keluar">
                            </div>
                           {{-- status --}}
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="lunas">Lunas</option>
                                    <option value="belum lunas">Belum Lunas</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of modal for tambah penjualan --}}
        {{-- modal for edit penjualan --}}


    @endsection
