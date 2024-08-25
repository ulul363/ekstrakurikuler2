<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kehadiran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .header h2,
        .header h3,
        .header p {
            margin: 0;
        }

        .header h2 {
            font-size: 12px;
            text-transform: uppercase;
        }

        .header h3 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            font-size: 11px;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0;
        }

        .content {
            margin: 20px 0;
        }

        .content h4 {
            margin: 0 0 10px;
        }

        .content p {
            font-size: 12px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('assets/images/logo-man3.png') }}" alt="Logo Sekolah">
        <h2>Kementerian Agama Republik Indonesia</h2>
        <h3>Madrasah Aliyah Negeri 1 Demak</h3>
        <p>Jl. Diponegoro No. 27 DemakJogoloyo, Kecamatan Wonosalam, Kabupaten Demak, Jawa Tengah 59571</p>
        <p>Telepon : 0291-681219 Email : mandemak1@gmail.com</p>
        <div class="line"></div>
    </div>



    <div class="content">
        <h4>Laporan Kehadiran</h4>
        <p>Ekstrakurikuler : {{ $data->first()->ekstrakurikuler->nama }}</p>
        <p>Status: {{ request()->input('status') ? request()->input('status') : 'Semua' }}</p>
        <p>Ketua : {{ $data->first()->ketua->nama }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Tahun Ajaran</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Diverifikasi oleh</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kegiatan }}</td>
                    <td>{{ $item->tahun_ajaran }}</td>
                    <td>{{ $item->tanggal }}</td>
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
                            <span>Pending</span>
                        @elseif ($item->status == 'disetujui')
                            <span>Disetujui</span>
                        @elseif ($item->status == 'ditolak')
                            <span>Ditolak</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
