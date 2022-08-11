@extends('../layouts/main')

@section('currentpage', 'Data Penawaran')
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
                    <h3>Data Penawaran</h3>
                </div>
                <div class="card-body">
                    {{-- add Pelanggan with modal --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Penawaran
                    </button>
                    {{-- table --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Penawaran</th>
                                    <th>Stok Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penawaran as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->barang->kode_barang }}</td>
                                        <td>{{ $item->barang->nama_barang }}</td>
                                        <td>{{ $item->harga_penawaran }}</td>
                                        <td>{{ $item->stok_barang }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('penawaran.destroy', $item->id) }}" method="POST"
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

    {{-- modal edit --}}
    @foreach ($penawaran as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Penawaran</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- insert data with modal --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah Penawaran
                        </button>
                        <form action="{{ route('penawaran.update', $item->id) }}" method="POST">
                            @csrf
                            @method('put')

                            <input type="hidden" name="id" value="{{ $item->id }}">

                            <div class="form-group">
                                <label for="kode_barang">Kode Barang</label>
                                {{-- select --}}
                                <select name="kode_barang" id="kode_barang" class="form-control">
                                    @foreach ($barang as $items)
                                        <option value="{{ $items->id }}"
                                            {{ $items->kode_barang == $items->kode_barang ? 'selected' : '' }}>
                                            {{ $items->kode_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_penawaran">Harga Penawaran</label>
                                <input type="number" class="form-control" name="harga_penawaran" id="harga_penawaran"
                                    value={{ $item->harga_penawaran }}>
                            </div>
                            <div class="form-group">
                                <label for="stok_barang">Stok Barang</label>
                                <input type="number" class="form-control" name="stok_barang" id="stok_barang"
                                    value="{{ $item->stok_barang }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal --}}

    {{-- modal insert --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Penawaran</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penawaran.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            {{-- select from --}}
                            <select name="kode_barang" id="kode_barang" class="form-control">
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->kode_barang == $item->kode_barang ? 'selected' : '' }}>
                                        {{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga_penawaran">Harga Penawaran</label>
                            <input type="number" class="form-control" name="harga_penawaran" id="harga_penawaran"
                                value="{{ old('harga_penawaran') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok_barang">Stok Barang</label>
                            <input type="number" class="form-control" name="stok_barang" id="stok_barang"
                                value="{{ old('stok_barang') }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal --}}


@endsection
