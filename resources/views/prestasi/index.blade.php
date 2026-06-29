@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">
                                @if (auth()->user()->hasRole('Ketua'))
                                    Pengajuan Prestasi
                                @else
                                    Daftar Prestasi
                                @endif
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('prestasi.index') }}">
                                    @if (auth()->user()->hasRole('Ketua'))
                                        Pengajuan Prestasi
                                    @else
                                        Daftar Prestasi
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        @if (auth()->user()->hasRole('Ketua'))
                            <h5>Data Pengajuan Prestasi</h5>
                        @else
                            <h5>Daftar Prestasi Ekstrakurikuler</h5>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (auth()->user()->hasRole('Ketua'))
                            @can('prestasi.create')
                                <a href="{{ route('prestasi.create') }}" class="btn btn-primary mb-3">
                                    <i class="fa fa-plus"></i> Tambah Prestasi
                                </a>
                            @endcan
                        @endif

                        <div class="table-responsive">
                            <table id="tabelPrestasi" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Prestasi</th>
                                        <th>Nama Siswa</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Berkas</th>
                                        <th>Diverifikasi Oleh</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prestasis as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->prestasi }}</td>

                                            {{-- Kolom Nama Siswa --}}
                                            <td>
                                                @php
                                                    // Detektor cerdas: jika string maka decode, jika array biarkan
                                                    $siswaRaw = is_string($item->nama_siswa) ? json_decode($item->nama_siswa, true) : $item->nama_siswa;
                                                    $siswaList = is_array($siswaRaw) ? $siswaRaw : [];
                                                @endphp
                                                @foreach ($siswaList as $index => $siswa)
                                                    <div>{{ count($siswaList) > 1 ? ($loop->iteration . '. ') : '' }}{{ $siswa }}
                                                    </div>
                                                @endforeach
                                            </td>

                                            <td>{{ $item->tahun_ajaran }}</td>

                                            {{-- Kolom Berkas --}}
                                            <td>
                                                @if ($item->berkas)
                                                    <a href="{{ asset('storage/' . $item->berkas) }}" target="_blank"
                                                        class="badge badge-info">Lihat Berkas</a>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            {{-- Kolom Pembina --}}
                                            <td>
                                                {{ $item->pembina->nama ?? 'Belum diverifikasi' }}
                                            </td>

                                            {{-- Kolom Status --}}
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($item->status == 'disetujui')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif ($item->status == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $item->status }}</span>
                                                @endif
                                            </td>

                                            {{-- Kolom Aksi --}}
                                            <td>
                                                {{-- Aksi Pembina --}}
                                                @if (auth()->user()->hasRole('Pembina'))
                                                    @if ($item->status == 'pending')
                                                        @can('prestasi.verifikasi')
                                                            <form id="form-verifikasi-disetujui-{{ $item->id_prestasi }}"
                                                                action="{{ route('prestasi.verifikasi', $item->id_prestasi) }}" method="POST"
                                                                style="display: none;">
                                                                @csrf
                                                                <input type="hidden" name="status" value="disetujui">
                                                            </form>
                                                            <button type="button" class="btn btn-success btn-sm mb-1"
                                                                onclick="confirmVerification('form-verifikasi-disetujui-{{ $item->id_prestasi }}', 'disetujui')">Setujui</button>

                                                            <form id="form-verifikasi-ditolak-{{ $item->id_prestasi }}"
                                                                action="{{ route('prestasi.verifikasi', $item->id_prestasi) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                <input type="hidden" name="status" value="ditolak">
                                                            </form>
                                                            <button type="button" class="btn btn-danger btn-sm mb-1"
                                                                onclick="confirmVerification('form-verifikasi-ditolak-{{ $item->id_prestasi }}', 'ditolak')">Tolak</button>
                                                        @endcan
                                                    @else
                                                        <button class="btn btn-secondary btn-sm" disabled>Telah Diverifikasi</button>
                                                    @endif

                                                {{-- Aksi Ketua --}}
                                                @elseif (auth()->user()->hasRole('Ketua'))
                                                    @if ($item->status == 'pending')
                                                        @can('prestasi.edit')
                                                            <a href="{{ route('prestasi.edit', $item->id_prestasi) }}"
                                                                class="btn btn-warning btn-sm mb-1"><i class="fa fa-edit"></i></a>
                                                        @endcan
                                                        @can('prestasi.destroy')
                                                            <form id="delete-prestasi-{{ $item->id_prestasi }}"
                                                                action="{{ route('prestasi.destroy', $item->id_prestasi) }}" method="POST"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger btn-sm mb-1"
                                                                    onclick="confirmDelete('delete-prestasi-{{ $item->id_prestasi }}')"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endcan
                                                    @endif
                                                @endif
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#tabelPrestasi').DataTable();
        });

        function confirmVerification(formId, action) {
            let title = action === 'disetujui' ? 'Setujui Prestasi?' : 'Tolak Prestasi?';