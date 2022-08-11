@extends('../layouts/main')

@section('currentpage', 'Data Prospek')

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
                    <h3>Data Prospek</h3>
                </div>
                <div class="card-body">
                    {{-- add prospek with modal --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Prospek
                    </button>
                    {{-- table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Toko</th>
                                    <th>Nama Toko</th>
                                    <th>Lokasi</th>
                                    <th>No. HP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prospek as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_toko }}</td>
                                        <td>{{ $item->nama_toko }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ $item->no_telp }}</td>
                                        <td>
                                            {{-- edit using modal --}}
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('prospek.destroy', $item->id) }}" method="POST"
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Prospek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('prospek.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_toko">Nama Toko</label>
                                <input type="text" class="form-control" id="nama_toko" name="nama_toko"
                                    placeholder="Nama Toko">
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <textarea class="form-control" id="lokasi" name="lokasi">{{ old('lokasi') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">No. Telp</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp"
                                    placeholder="No. Telp">
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

        {{-- modal for edit --}}
        @foreach ($prospek as $item)
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Prospek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('prospek.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" value="{{ $item->id }}">

                                <div class="form-group">
                                    <label for="nama_toko">Nama Toko</label>
                                    <input type="text" class="form-control" id="nama_toko" name="nama_toko"
                                        placeholder="Nama Toko" value="{{ $item->nama_toko }}">
                                </div>
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <textarea class="form-control" id="lokasi" name="lokasi">{{ $item->lokasi }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No. Telp</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp"
                                        placeholder="No. Telp" value="{{ $item->no_telp }}">
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
    </div>
    {{-- end modal --}}

    @endsection
