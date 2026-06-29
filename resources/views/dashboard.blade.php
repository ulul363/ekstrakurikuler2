@extends('layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Beranda</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary shadow-sm" role="alert">
                    <h4 class="alert-heading font-weight-bold mb-1">
                        <i class="feather icon-smile"></i> Selamat Datang, {{ Auth::user()->name }}!
                    </h4>
                    <p class="mb-0">
                        Anda login sebagai <strong>{{ $role_name ?? 'User' }} {{ $nama_ekskul ?? '' }}</strong>.
                        Berikut adalah ringkasan aktivitas ekstrakurikuler saat ini.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card summary-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="summary-icon bg-gradient-primary mr-3">
                            <i class="feather icon-calendar"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Jadwal Aktif</h6>
                            <h3 class="mb-0 font-weight-bold">{{ $totalJadwal }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card summary-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="summary-icon bg-gradient-success mr-3">
                            <i class="feather icon-clipboard"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Program Kerja</h6>
                            <h3 class="mb-0 font-weight-bold">{{ $totalProker }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card summary-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="summary-icon bg-gradient-warning mr-3">
                            <i class="feather icon-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Data Kehadiran</h6>
                            <h3 class="mb-0 font-weight-bold">{{ $totalKehadiran }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card summary-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="summary-icon bg-gradient-danger mr-3">
                            <i class="feather icon-award"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Prestasi</h6>
                            <h3 class="mb-0 font-weight-bold">{{ $totalPrestasi }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-12">
                <div class="card card-modern" style="height: 100%;">
                    <div class="card-header">
                        <h5>Rasio Verifikasi Berkas</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div id="statusChart" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-md-12">
                <div class="card card-modern" style="height: 100%;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Jadwal Ekstrakurikuler Terdekat</h5>
                        <a href="{{ route('jadwal_ekstrakurikuler.index') }}" class="btn btn-sm btn-outline-primary">Lihat
                            Semua</a>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Ekskul</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jadwalEkstrakurikuler->take(4) as $jadwal)
                                        <tr>
                                            <td class="font-weight-bold">{{ $jadwal->ekstrakurikuler->nama }}</td>
                                            <td><span class="badge badge-primary">{{ $jadwal->hari }}</span></td>
                                            <td><i class="feather icon-clock text-muted"></i>
                                                {{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB</td>
                                            <td>{{ $jadwal->lokasi }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada jadwal yang diatur.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card card-modern">
                    <div class="card-header">
                        <h5>Data Aktivitas Ekstrakurikuler</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase font-weight-bold" id="proker-tab" data-toggle="tab"
                                    href="#proker" role="tab"><i class="feather icon-clipboard mr-2"></i>Program Kerja</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase font-weight-bold" id="kehadiran-tab" data-toggle="tab"
                                    href="#kehadiran" role="tab"><i class="feather icon-check-circle mr-2"></i>Kehadiran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase font-weight-bold" id="prestasi-tab" data-toggle="tab"
                                    href="#prestasi" role="tab"><i class="feather icon-award mr-2"></i>Prestasi</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="proker" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tabelProgramKegiatan" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                @if (auth()->user()->hasRole('Admin'))
                                                <th>Ekskul</th> @endif
                                                <th>Nama Program</th>
                                                <th>T.A</th>
                                                <th>Status Pengajuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($programKegiatan as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    @if (auth()->user()->hasRole('Admin'))
                                                    <td>{{ $item->ekstrakurikuler->nama }}</td> @endif
                                                    <td>{{ $item->nama_program }}</td>
                                                    <td>{{ $item->tahun_ajaran }}</td>
                                                    <td>
                                                        @if ($item->status == 'pending') <span
                                                            class="badge badge-warning">Pending</span>
                                                        @elseif ($item->status == 'disetujui') <span
                                                            class="badge badge-success">Disetujui</span>
                                                        @else <span class="badge badge-danger">Ditolak</span> @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="kehadiran" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tabelKehadiran" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                @if (auth()->user()->hasRole('Admin'))
                                                <th>Ekskul</th> @endif
                                                <th>Kegiatan</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kehadiran as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    @if (auth()->user()->hasRole('Admin'))
                                                    <td>{{ $item->ekstrakurikuler->nama }}</td> @endif
                                                    <td>{{ $item->nama_kegiatan }}</td>
                                                    <td>{{ date('d M Y', strtotime($item->tanggal)) }}</td>
                                                    <td>
                                                        @if ($item->status == 'pending') <span
                                                            class="badge badge-warning">Pending</span>
                                                        @elseif ($item->status == 'disetujui') <span
                                                            class="badge badge-success">Disetujui</span>
                                                        @else <span class="badge badge-danger">Ditolak</span> @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="prestasi" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tabelPrestasi" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                @if (auth()->user()->hasRole('Admin'))
                                                <th>Ekskul</th> @endif
                                                <th>Prestasi</th>
                                                <th>Tingkat</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prestasi as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    @if (auth()->user()->hasRole('Admin'))
                                                    <td>{{ $item->ekstrakurikuler->nama }}</td> @endif
                                                    <td>{{ $item->prestasi }}</td>
                                                    <td><span
                                                            class="badge badge-info text-capitalize">{{ $item->tingkat }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'pending') <span
                                                            class="badge badge-warning">Pending</span>
                                                        @elseif ($item->status == 'disetujui') <span
                                                            class="badge badge-success">Disetujui</span>
                                                        @else <span class="badge badge-danger">Ditolak</span> @endif
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
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var options = {
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: ['Disetujui', 'Pending', 'Ditolak'],
                series: [{{ $chartData['disetujui'] }}, {{ $chartData['pending'] }}, {{ $chartData['ditolak'] }}],
                colors: ['#2ed8b6', '#FFB64D', '#FF5370'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return Math.round(val) + "%"
                    }
                },
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#statusChart"), options);
            chart.render();
        });
    </script>
@endsection