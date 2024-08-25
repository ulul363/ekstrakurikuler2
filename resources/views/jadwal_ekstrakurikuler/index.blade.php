@extends('layouts.master')
@section('content')
    <div class="pcoded-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Jadwal Ekstrakurikuler</span></h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jadwal_ekstrakurikuler.index') }}">Jadwal Ekstrakurikuler</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Jadwal Ekstrakurikuler</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <a href="{{ route('jadwal_ekstrakurikuler.create') }}" class="btn btn-primary mb-3">
                            <i class="fa fa-plus"></i> Tambah Jadwal Ekstrakurikuler
                        </a>

                        <table class="table table-bordered" id="tableJadwalEkstra">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ekstrakurikuler</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalEkstrakurikuler as $jadwal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwal->ekstrakurikuler->nama }}</td>
                                        <td>{{ $jadwal->hari }}</td>
                                        <td>{{ $jadwal->waktu }}</td>
                                        <td>{{ $jadwal->lokasi }}</td>
                                        <td>
                                            <form id="delete-jadwal-{{ $jadwal->id_jadwal_ekstrakurikuler }}" action="{{ route('jadwal_ekstrakurikuler.destroy', $jadwal->id_jadwal_ekstrakurikuler) }}" method="POST">
                                                @can('jadwal_ekstrakurikuler.edit')
                                                    <a href="{{ route('jadwal_ekstrakurikuler.edit', $jadwal->id_jadwal_ekstrakurikuler) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('jadwal_ekstrakurikuler.destroy')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-jadwal-{{ $jadwal->id_jadwal_ekstrakurikuler }}')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
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
        <!-- [ Main Content ] end -->
    </div>
@endsection

{{-- <script>
    function confirmDelete(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.getElementById(formId).submit();
        }
    }
</script> --}}
