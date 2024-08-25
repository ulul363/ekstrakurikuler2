@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Ekstrakurikuler</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Ekstrakurikuler</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Ekstrakurikuler</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @can('ekstrakurikuler.create')
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">
                                <i class="fas fa-plus"></i> Tambah Ekstrakurikuler Baru
                            </button>
                        @endcan

                        <table class="table table-bordered" id="tableEkstrakurikuler">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ekstrakurikuler</th>
                                    <th>Deskripsi</th>
                                    <th>Ketua</th>
                                    <th>Pembina</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ekstrakurikuler as $ekstra)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ekstra->nama }}</td>
                                        <td>{{ $ekstra->deskripsi }}</td>
                                        <td>{{ $ekstra->ketua->nama ?? 'Tidak ada ketua' }}</td>
                                        <td>
                                            @foreach ($ekstra->pembina as $pembina)
                                                {{ $pembina->nama }}<br>
                                            @endforeach
                                            @if ($ekstra->pembina->isEmpty())
                                                Tidak ada pembina
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <form id="delete-ekstra-{{ $ekstra->id_ekstrakurikuler }}" action="{{ route('ekstrakurikuler.destroy', $ekstra->id_ekstrakurikuler) }}" method="POST">
                                                @can('ekstrakurikuler.edit')
                                                    <a href="{{ route('ekstrakurikuler.edit', $ekstra->id_ekstrakurikuler) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('ekstrakurikuler.destroy')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-ekstra-{{ $ekstra->id_ekstrakurikuler }}')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </form> --}}
                                            
                                            @can('ekstrakurikuler.edit')
                                                <a href="{{ route('ekstrakurikuler.edit', $ekstra->id_ekstrakurikuler) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
                                            @endcan
                                            @can('ekstrakurikuler.destroy')
                                                <form
                                                    action="{{ route('ekstrakurikuler.destroy', $ekstra->id_ekstrakurikuler) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i> 
                                                    </button>
                                                </form>
                                            @endcan  
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

    <!-- Modal Tambah Ekstrakurikuler Baru -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Ekstrakurikuler Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createEkstrakurikulerForm" method="POST" action="{{ route('ekstrakurikuler.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Ekstrakurikuler</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Ekstrakurikuler</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                        </div>
                        <!-- Ketua Details -->
                        <h5>Data Ketua</h5>
                        <div class="form-group">
                            <label for="ketua_nama">Nama Ketua</label>
                            <input type="text" class="form-control" id="ketua_nama" name="ketua_nama" required>
                        </div>
                        <div class="form-group">
                            <label for="ketua_nis">NIS Ketua</label>
                            <input type="number" class="form-control" id="ketua_nis" name="ketua_nis" required>
                        </div>
                        <div class="form-group">
                            <label for="ketua_email">Email</label>
                            <input type="email" class="form-control" id="ketua_email" name="ketua_email" required>
                        </div>

                        <!-- Pembina Details -->
                        <h5>Data Pembina</h5>
                        <div id="pembina-fields">
                            <div class="form-group">
                                <label for="pembina_nama">Nama Pembina</label>
                                <input type="text" class="form-control" id="pembina_nama" name="pembina_nama[]" required>
                            </div>
                            <div class="form-group">
                                <label for="pembina_nip">NIP Pembina</label>
                                <input type="number" class="form-control" id="pembina_nip" name="pembina_nip[]" required>
                            </div>
                            <div class="form-group">
                                <label for="pembina_email">Email</label>
                                <input type="email" class="form-control" id="pembina_email" name="pembina_email[]"
                                    required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" id="add-pembina">Tambah Pembina</button>
                        <!-- Add more Pembina fields as needed -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Pembina",
                allowClear: true,
                width: '100%' // Sesuaikan lebar dropdown agar sesuai dengan form-control
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#add-pembina').click(function() {
                console.log('Button clicked!');
                $('#pembina-fields').append(`
                    <div class="form-group">
                        <label for="pembina_nama">Nama Pembina</label>
                        <input type="text" class="form-control" name="pembina_nama[]" required>
                    </div>
                    <div class="form-group">
                        <label for="pembina_nip">NIP Pembina</label>
                        <input type="number" class="form-control" name="pembina_nip[]" required>
                    </div>
                    <div class="form-group">
                        <label for="pembina_email">Email</label>
                        <input type="email" class="form-control" name="pembina_email[]" required>
                    </div>
                `);
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .modal {
            z-index: 1050;
            /* Modal z-index lebih tinggi dari elemen lainnya */
        }

        .select2-container--default .select2-selection--multiple {
            z-index: 1040;
            /* Sesuaikan z-index jika diperlukan */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            /* Warna latar belakang biru */
            color: #ffffff;
            /* Warna teks putih */
            border: none;
            /* Menghilangkan border */
            padding: 0.25rem 0.5rem;
            /* Mengatur padding */
            font-weight: bold;
            /* Membuat teks lebih tebal */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff;
            /* Warna "X" putih */
        }

        .select2-results__option {
            color: #000000;
            /* Warna teks pada dropdown */
        }

        .select2-container--default .select2-selection--multiple {
            background-color: #ffffff;
            /* Warna latar belakang dropdown putih */
            border: 1px solid #ced4da;
            /* Warna border dropdown */
        }
    </style>
    
@endsection
