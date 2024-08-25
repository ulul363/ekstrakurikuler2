@extends('layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Cetak Laporan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Cetak Laporan </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Program Kegiatan -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><b>Cetak Laporan Program Kegiatan</b></div>
                    <div class="card-body">
                        @can('laporan.exportPDF')
                            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#exportProgramKegiatanModal">
                                <span class="pcoded-micon"><i class="feather icon-printer"></i></span> Cetak
                                Laporan</button>
                        @endcan
                        <table id="tabelProgramKegiatan" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ekstrakurikuler</th>
                                    <th>Ketua</th>
                                    <th>Nama Program</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Deskripsi</th>
                                    <th>Diverifikasi oleh</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programKegiatan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->ekstrakurikuler->nama }}</td>
                                        <td>{{ $item->ketua->nama }}</td>
                                        <td>{{ $item->nama_program }}</td>
                                        <td>{{ $item->tahun_ajaran }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>
                                            @if ($item->pembina && $item->pembina->nama)
                                                {{ $item->pembina->nama }}
                                            @else
                                                Belum diverifikasi
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($item->status == 'disetujui')
                                                <span class="badge badge-success">Disetujui</span>
                                            @elseif ($item->status == 'ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
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

        <!-- Kehadiran -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><b>Cetak Laporan Kehadiran</b></div>
                    <div class="card-body">
                        @can('laporan.exportPDF')
                            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#exportKehadiranModal"><span
                                    class="pcoded-micon"><i class="feather icon-printer"></i></span> Cetak
                                Laporan</button>
                        @endcan
                        <table id="tabelKehadiran" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ekstrakurikuler</th>
                                    <th>Ketua</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Tanggal</th>
                                    <th>Berkas</th>
                                    <th>Deskripsi</th>
                                    <th>Diverifikasi oleh</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kehadiran as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->ekstrakurikuler->nama }}</td>
                                        <td>{{ $item->ketua->nama }}</td>
                                        <td>{{ $item->nama_kegiatan }}</td>
                                        <td>{{ $item->tahun_ajaran }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $item->berkas) }}" target="_blank">Lihat
                                                Berkas</a>
                                        </td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>
                                            @if ($item->pembina && $item->pembina->nama)
                                                {{ $item->pembina->nama }}
                                            @else
                                                Belum diverifikasi
                                            @endif
                                        </td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><b>Cetak Laporan Prestasi</b></div>
                    <div class="card-body">
                        @can('laporan.exportPDF')
                            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#exportPrestasiModal"><span
                                    class="pcoded-micon"><i class="feather icon-printer"></i></span> Cetak
                                Laporan</button>
                        @endcan
                        <table id="tabelPrestasi" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ekstrakurikuler</th>
                                    <th>Ketua</th>
                                    <th>Prestasi</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Berkas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Diverifikasi oleh</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prestasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->ekstrakurikuler->nama }}</td>
                                        <td>{{ $item->ketua->nama }}</td>
                                        <td>{{ $item->prestasi }}</td>
                                        <td>
                                            @php
                                                $siswaList = json_decode($item->nama_siswa);
                                            @endphp
                                            @foreach ($siswaList as $index => $siswa)
                                                @if (count($siswaList) > 1)
                                                    <div>{{ $loop->iteration }}. {{ $siswa }}</div>
                                                @else
                                                    <div>{{ $siswa }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $kelasList = json_decode($item->kelas);
                                            @endphp
                                            @foreach ($kelasList as $index => $kls)
                                                @if (count($kelasList) > 1)
                                                    <div>{{ $loop->iteration }}. {{ $kls }}</div>
                                                @else
                                                    <div>{{ $kls }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $item->berkas) }}" target="_blank">Lihat
                                                Berkas</a>
                                        </td>
                                        <td>{{ $item->tahun_ajaran }}</td>
                                        <td>
                                            @if ($item->pembina && $item->pembina->nama)
                                                {{ $item->pembina->nama }}
                                            @else
                                                Belum diverifikasi
                                            @endif
                                        </td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- Modal Program Kegiatan -->
        <div class="modal fade" id="exportProgramKegiatanModal" tabindex="-1" role="dialog"
            aria-labelledby="exportProgramKegiatanModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportProgramKegiatanModalLabel">Cetak Laporan Program Kegiatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('laporan.exportPDF') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="program_kegiatan">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ekstrakurikuler_id">Pilih Ekstrakurikuler</label>
                                <select id="ekstrakurikuler_id" name="ekstrakurikuler_id" class="form-control">
                                    <option value="">Pilih Ekstrakurikuler</option>
                                    @foreach ($jadwalEkstrakurikuler as $jadwal)
                                        <option value="{{ $jadwal->ekstrakurikuler_id }}">
                                            {{ $jadwal->ekstrakurikuler->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun_ajaran">Pilih Tahun Ajaran</label>
                                <select id="tahun_ajaran_program" name="tahun_ajaran" class="form-control">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahunAjaranProgramKegiatan as $ta)
                                        <option value="{{ $ta }}">{{ $ta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="pending">Pending</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Kehadiran -->
        <div class="modal fade" id="exportKehadiranModal" tabindex="-1" role="dialog"
            aria-labelledby="exportKehadiranModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportKehadiranModalLabel">Cetak Laporan Kehadiran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('laporan.exportPDF') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="kehadiran">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ekstrakurikuler_id">Pilih Ekstrakurikuler</label>
                                <select id="ekstrakurikuler_id" name="ekstrakurikuler_id" class="form-control">
                                    <option value="">Pilih Ekstrakurikuler</option>
                                    @foreach ($jadwalEkstrakurikuler as $jadwal)
                                        <option value="{{ $jadwal->ekstrakurikuler_id }}">
                                            {{ $jadwal->ekstrakurikuler->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun_ajaran">Pilih Tahun Ajaran</label>
                                <select id="tahun_ajaran_kehadiran" name="tahun_ajaran" class="form-control">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahunAjaranKehadiran as $ta)
                                        <option value="{{ $ta }}">{{ $ta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="pending">Pending</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Prestasi -->
        <div class="modal fade" id="exportPrestasiModal" tabindex="-1" role="dialog"
            aria-labelledby="exportPrestasiModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportPrestasiModalLabel">Cetak Laporan Prestasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('laporan.exportPDF') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="prestasi">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ekstrakurikuler_id">Pilih Ekstrakurikuler</label>
                                <select id="ekstrakurikuler_id" name="ekstrakurikuler_id" class="form-control">
                                    <option value="">Pilih Ekstrakurikuler</option>
                                    @foreach ($jadwalEkstrakurikuler as $jadwal)
                                        <option value="{{ $jadwal->ekstrakurikuler_id }}">
                                            {{ $jadwal->ekstrakurikuler->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun_ajaran">Pilih Tahun Ajaran</label>
                                <select id="tahun_ajaran_prestasi" name="tahun_ajaran" class="form-control">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahunAjaranPrestasi as $ta)
                                        <option value="{{ $ta }}">{{ $ta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="pending">Pending</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
