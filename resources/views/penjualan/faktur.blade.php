@extends('../layouts/main')

@section('currentpage', 'Faktur Penjualan')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Faktur Penjualan</h3>
                </div>

                <div class="row ms-6">
                    <div class="col-6">
                        Dijual Kepada : {{ $penjualan->pelanggan->nama_toko }} <br>
                        Lokasi : {{ $penjualan->pelanggan->lokasi }}
                    </div>
                    <div class="col-6" >
                        Tanggal : {{ $penjualan->created_at }} <br>
                    </div>
                </div>

                <div class="card-body">
                    {{-- table --}}
                    <div class="table-responsive w-100">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Toko</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Sales</th>
                                    <th>Barang Keluar</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $penjualan->pelanggan->nama_toko }}</td>
                                        <td>{{ $penjualan->barang->nama_barang }}</td>
                                        <td>{{ $penjualan->user->name }}</td>
                                        <td>{{ $penjualan->barang_keluar }}</td>
                                        <td>{{ $penjualan->total_harga }}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row text-center mt-6">
                    <div class="col-6">
                        TTD<br>
                        TOKO
                    </div>
                    <div class="col-6" >
                        TTD <br>
                        Bagian Penjualan
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    window.print();
</script>
@endsection
