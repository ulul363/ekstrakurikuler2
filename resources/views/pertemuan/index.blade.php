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
                                    Pengajuan Pertemuan
                                @else
                                    Daftar Pertemuan
                                @endif
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pertemuan.index') }}">
                                    @if (auth()->user()->hasRole('Ketua'))
                                        Pengajuan Pertemuan
                                    @else
                                        Daftar Pertemuan
                                    @endif
                                </a></li>
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
                            Pengajuan Pertemuan
                        @else
                            Daftar Pertemuan
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (auth()->user()->hasRole('Ketua'))
                            @can('pertemuan.create')
                                <a href="{{ route('pertemuan.create') }}" class="btn btn-primary mb-3">
                                    <i class="fa fa-plus"></i> Tambah Pertemuan
                                </a>
                            @endcan
                        @endif

                        <table id="tabelPembinaPertemuan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Waktu Verifikasi</th>
                                    <th>Nama Pembina</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pertemuan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->hari }}</td>
                                        <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                                        <td>{{ $item->waktu->format('H:i') }}</td>
                                        <td>
                                            @if ($item->waktu_verifikasi)
                                                {{ $item->waktu_verifikasi->format('H:i') }}
                                            @else
                                                Belum diverifikasi
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->waktu_verifikasi)
                                                {{ $item->pembina ? $item->pembina->nama : 'Belum diverifikasi' }}
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
                                        <td>
                                            {{ $item->keterangan ?? 'Tidak ada keterangan' }}
                                        </td>
                                        <td>
                                            @if (auth()->user()->hasRole('Pembina'))
                                                @if ($item->status == 'pending')
                                                    @can('pertemuan.verifikasi')
                                                        <form id="approve-form-{{ $item->id_pengajuan_pertemuan }}"
                                                            action="{{ route('pertemuan.verifikasi', $item->id_pengajuan_pertemuan) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                onclick="confirmAction('approve', {{ $item->id_pengajuan_pertemuan }})">
                                                                Disetujui
                                                            </button>
                                                        </form>
                                                        <form id="reject-form-{{ $item->id_pengajuan_pertemuan }}"
                                                            action="{{ route('pertemuan.verifikasi', $item->id_pengajuan_pertemuan) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmAction('reject', {{ $item->id_pengajuan_pertemuan }})">
                                                                Ditolak
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @else
                                                    @can('pertemuan.show')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#showModal{{ $item->id_pengajuan_pertemuan }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        @if ($item->status == 'ditolak')
                                                            <form
                                                                action="{{ route('chatroom.show', $item->id_pengajuan_pertemuan) }}"
                                                                method="GET" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm">Chat</button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                @endif
                                            @elseif (auth()->user()->hasRole('Ketua'))
                                                @if ($item->status == 'pending')
                                                    @can('pertemuan.edit')
                                                        <a href="{{ route('pertemuan.edit', $item->id_pengajuan_pertemuan) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('pertemuan.destroy')
                                                        <form id="delete-form-{{ $item->id_pengajuan_pertemuan }}"
                                                            action="{{ route('pertemuan.destroy', $item->id_pengajuan_pertemuan) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete('delete-form-{{ $item->id_pengajuan_pertemuan }}')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan

                                                    @can('pertemuan.show')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#showModal{{ $item->id_pengajuan_pertemuan }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    @endcan
                                                @else
                                                    @can('pertemuan.show')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#showModal{{ $item->id_pengajuan_pertemuan }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        @if ($item->status == 'ditolak')
                                                            <form
                                                                action="{{ route('chatroom.show', $item->id_pengajuan_pertemuan) }}"
                                                                method="GET" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm">Chat</button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="showModal{{ $item->id_pengajuan_pertemuan }}"
                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Detail Pertemuan</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Ketua:</strong> {{ $item->ketua->nama }}</p>
                                                    <p><strong>Hari:</strong> {{ $item->hari }}</p>
                                                    <p><strong>Tanggal:</strong> {{ $item->tanggal->format('d-m-Y') }}</p>
                                                    <p><strong>Waktu:</strong> {{ $item->waktu->format('H:i') }}</p>
                                                    <p><strong>Waktu Verifikasi:</strong>
                                                        @if ($item->waktu_verifikasi)
                                                            {{ $item->waktu_verifikasi->format('H:i') }}
                                                        @else
                                                            Belum diverifikasi
                                                        @endif
                                                    </p>
                                                    <p><strong>Nama Pembina:</strong>
                                                        @if ($item->pembina)
                                                            {{ $item->pembina->nama }}
                                                        @else
                                                            Belum diverifikasi
                                                        @endif
                                                    </p>

                                                    <p><strong>Status:</strong>
                                                        @if ($item->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif ($item->status == 'disetujui')
                                                            <span class="badge badge-success">Disetujui</span>
                                                        @elseif ($item->status == 'ditolak')
                                                            <span class="badge badge-danger">Ditolak</span>
                                                        @endif
                                                    </p>

                                                    <p><strong>Keterangan:</strong>
                                                        {{ $item->keterangan ?? 'Tidak ada keterangan' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmAction(action, id) {
            let title, text, confirmButtonText, formId;
            if (action === 'approve') {
                title = 'Konfirmasi Persetujuan';
                text = 'Apakah Anda yakin ingin menyetujui pertemuan ini?';
                confirmButtonText = 'Setujui';
                formId = `approve-form-${id}`;
            } else if (action === 'reject') {
                title = 'Konfirmasi Penolakan';
                text = 'Apakah Anda yakin ingin menolak pertemuan ini?';
                confirmButtonText = 'Tolak';
                formId = `reject-form-${id}`;
            }

            Swal.fire({
                title: title,
                text: text,
                input: 'textarea',
                inputLabel: 'Keterangan (opsional):',
                inputPlaceholder: 'Masukkan keterangan...',
                inputAttributes: {
                    'aria-label': 'Masukkan keterangan'
                },
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the textarea value to the hidden input field
                    const form = document.getElementById(formId);
                    const keteranganInput = form.querySelector('input[name="keterangan"]');
                    if (!keteranganInput) {
                        // Create hidden input if it does not exist
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'keterangan';
                        hiddenInput.value = result.value;
                        form.appendChild(hiddenInput);
                    } else {
                        // Update existing hidden input
                        keteranganInput.value = result.value;
                    }
                    form.submit();
                }
            });
        }
    </script>
@endsection
