@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Pengajuan Pertemuan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Manajemen Pertemuan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-modern">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Daftar Pengajuan Pertemuan Rutin</h5>
                        @hasrole('Ketua')
                        <a href="{{ route('pertemuan.create') }}" class="btn btn-primary btn-sm shadow-sm">
                            <i class="feather icon-plus"></i> Ajukan Pertemuan
                        </a>
                        @endhasrole
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="tabelPertemuan" class="table table-striped table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        @hasrole('Admin')
                                        <th>Ekskul</th> @endhasrole
                                        <th>Judul Rapat</th>
                                        <th>Jadwal Pelaksanaan</th>
                                        <th>Agenda</th>
                                        <th>Status</th>
                                        <th>Keterangan Pembina</th> <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pertemuan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @hasrole('Admin')
                                            <td>{{ $item->ekstrakurikuler->nama }}</td> @endhasrole
                                            <td class="font-weight-bold">{{ $item->judul_pertemuan }}</td>
                                            <td>
                                                <span class="d-block"><i class="feather icon-calendar text-primary"></i>
                                                    {{ date('d M Y', strtotime($item->tanggal_rencana)) }}</span>
                                                <span class="d-block"><i class="feather icon-clock text-warning"></i>
                                                    {{ \Carbon\Carbon::parse($item->waktu_rencana)->format('H:i') }} WIB</span>
                                            </td>
                                            <td>{{ Str::limit($item->agenda_pertemuan, 50) }}</td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="badge badge-warning px-2 py-1">Pending</span>
                                                @elseif ($item->status == 'disetujui')
                                                    <span class="badge badge-success px-2 py-1">Disetujui</span>
                                                @else
                                                    <span class="badge badge-danger px-2 py-1">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->keterangan_pembina ?? 'Tidak ada keterangan' }}
                                            </td>
                                            <td>
                                                {{-- AKSI UNTUK PEMBINA --}}
                                                @hasrole('Pembina')
                                                @if ($item->status == 'pending')
                                                    <button type="button" class="btn btn-success btn-sm mb-1"
                                                        onclick="confirmVerification('{{ route('pertemuan.verifikasi', $item->id_pengajuan) }}', 'disetujui')">
                                                        <i class="feather icon-check"></i> Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                                        onclick="confirmVerification('{{ route('pertemuan.verifikasi', $item->id_pengajuan) }}', 'ditolak')">
                                                        <i class="feather icon-x"></i> Tolak
                                                    </button>
                                                @else
                                                    <span class="text-muted"><i class="feather icon-check-circle"></i>
                                                        Selesai</span>
                                                @endif
                                                @endhasrole

                                                {{-- AKSI UNTUK KETUA --}}
                                                @hasrole('Ketua')
                                                @if ($item->status == 'pending')
                                                    <a href="{{ route('pertemuan.edit', $item->id_pengajuan) }}"
                                                        class="btn btn-warning btn-sm mb-1">
                                                        <i class="feather icon-edit"></i>
                                                    </a>
                                                    <form id="delete-pertemuan-{{ $item->id_pengajuan }}"
                                                        action="{{ route('pertemuan.destroy', $item->id_pengajuan) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm mb-1"
                                                            onclick="confirmDelete('delete-pertemuan-{{ $item->id_pengajuan }}')">
                                                            <i class="feather icon-trash-2"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted"><i class="feather icon-lock"></i> Terkunci</span>
                                                @endif
                                                @endhasrole
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
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#tabelPertemuan').DataTable();
        });
    </script>
@endsection