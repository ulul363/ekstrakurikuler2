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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
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

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Ketua</th>
                                    <th>Pembina</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ekstrakurikuler as $ekstrakurikuler)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ekstrakurikuler->nama }}</td>
                                        <td>{{ $ekstrakurikuler->deskripsi }}</td>
                                        <td>{{ $ekstrakurikuler->ketua->nama ?? 'Tidak ada ketua' }}</td>
                                        <td>{{ $ekstrakurikuler->pembina->nama ?? 'Tidak ada ketua' }}</td>
                                        
                                        <td>
                                            {{-- @if ($ekstrakurikuler->pembina && $ekstrakurikuler->pembina->count() > 0)
                                                @foreach ($ekstrakurikuler->pembina as $pembina)
                                                    {{ $pembina->nama }}<br>
                                                @endforeach
                                            @else
                                                Tidak ada pembina
                                            @endif --}}
                                        </td>
                                        
                                        <td>
                                            <form id="delete-ekstrakurikuler-{{ $ekstrakurikuler->id_ekstrakurikuler }}"
                                                action="{{ route('ekstrakurikuler.destroy', $ekstrakurikuler->id_ekstrakurikuler) }}"
                                                method="POST">
                                                @can('ekstrakurikuler.edit')
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModal{{ $ekstrakurikuler->id_ekstrakurikuler }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                @endcan
                                                @can('ekstrakurikuler.destroy')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete('delete-ekstrakurikuler-{{ $ekstrakurikuler->id_ekstrakurikuler }}')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    {{-- <div class="modal fade" id="editModal{{ $ekstrakurikuler->id_ekstrakurikuler }}"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel{{ $ekstrakurikuler->id_ekstrakurikuler }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $ekstrakurikuler->id_ekstrakurikuler }}">
                                                        Edit Ekstrakurikuler
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ekstrakurikuler.update', $ekstrakurikuler->id_ekstrakurikuler) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="nama">Nama Ekstrakurikuler</label>
                                                            <input type="text" class="form-control" id="nama" name="nama"
                                                                value="{{ $ekstrakurikuler->nama }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="deskripsi">Deskripsi Ekstrakurikuler</label>
                                                            <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                                                value="{{ $ekstrakurikuler->deskripsi }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ketua_id">Ketua</label>
                                                            <select name="ketua_id" class="form-control" required>
                                                                @foreach ($ketua as $item)
                                                                    <option value="{{ $item->id_ketua }}" {{ $item->id_ketua == $ekstrakurikuler->ketua_id ? 'selected' : '' }}>
                                                                        {{ $item->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pembina_ids">Pembina</label>
                                                            <select name="pembina_ids[]" class="form-control" multiple required>
                                                                @foreach ($pembina as $item)
                                                                    <option value="{{ $item->id_pembina }}">{{ $item->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
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
                    <form action="{{ route('ekstrakurikuler.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Ekstrakurikuler</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Ekstrakurikuler</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                        </div>
                        <div class="form-group">
                            <label for="ketua_id">Ketua</label>
                            <select namekstrae="ketua_id" class="form-control" required>
                                @foreach ($ketua as $item)
                                    <option value="{{ $item->id_ketua }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pembina_ids">Pembina</label>
                            <select name="pembina_ids[]" class="form-control" multiple required>
                                @foreach ($pembina as $item)
                                    <option value="{{ $item->id_pembina }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
