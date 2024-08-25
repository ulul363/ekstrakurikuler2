@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Ketua</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('ketua.index') }}">Ketua</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Ketua</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @can('ketua.create')
                            <a href="{{ route('ketua.create') }}" class="btn btn-primary mb-3">
                                <i class="fa fa-plus"></i> Tambah Ketua
                            </a>
                        @endcan

                        <table id="tabelKetua" class="display" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ketua</th>
                                    <th>Nama Ekstrakurikuler</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ketua as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->ekstrakurikuler->nama ?? 'Tidak ada ekstrakurikuler' }}</td>
                                        <td>
                                            @if ($item->status === 1)
                                                Aktif
                                            @else
                                                Tidak Aktif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn ml-2 btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                  Ubah Status
                                                </button>
                                                <div class="dropdown-menu">
                                                    <form action="{{ route('ketua.status', ['id' => $item->id_ketua]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="1">
                                                        <button class="dropdown-item" type="submit">Aktif</button>
                                                    </form>
                                                    <form action="{{ route('ketua.status', ['id' => $item->id_ketua]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="2">
                                                        <button class="dropdown-item" type="submit">Tidak Aktif</button>
                                                    </form>
                                                </div>
                                              </div>
                                        </td>
                                        {{-- <td>
                                            <form id="delete-ketua-{{ $item->id }}" action="{{ route('ketua.destroy', $item->id) }}" method="POST">
                                                @can('ketua.edit')
                                                    <a href="{{ route('ketua.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('ketua.destroy')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-ketua-{{ $item->id }}')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection

{{-- @section('scripts')
    <script>
        $(document).ready(function() {
            $('#tabelKetua').DataTable({
                // Anda bisa menambahkan opsi konfigurasi DataTables di sini
            });
        });

        function confirmDelete(formId) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
@endsection --}}
