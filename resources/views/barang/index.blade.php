@extends('../layouts/main')

@section('currentpage', 'Data Barang')

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
                    <h3>Data Barang</h3>
                </div>
                <div class="card-body">
                    {{-- add barang with modal --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Barang
                    </button>
                    {{-- table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>Rp. <?= number_format($item->harga_barang) ?></td>
                                        <td>{{ $item->stok_barang }}</td>
                                        <td>
                                            {{-- edit using modal --}}
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal for tambah barang --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Nama Barang" value="{{ old('nama_barang') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga">harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukan Harga" value="{{ old('harga') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukan Stok" value="{{ old('stok') }}">
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
    {{-- end of modal --}}

    {{-- edit modal --}}
    @foreach ($barang as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('barang.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                    placeholder="Nama Barang" value="{{ $item->nama_barang }}">
                            </div>
                            <div class="form-group">
                                <label for="harga">harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukan Harga" value="{{ $item->harga_barang }}">
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukan Stok" value="{{ $item->stok_barang }}">
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
    @endforeach
    {{-- end of edit modal --}}

@endsection