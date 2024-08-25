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
                                    Pengajuan Program Kegiatan
                                @else
                                    Daftar Program Kegiatan
                                @endif
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    <i class="feather icon-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('program_kegiatan.index') }}">
                                    @if (auth()->user()->hasRole('Ketua'))
                                        Pengajuan Program Kegiatan
                                    @else
                                        Program Kegiatan
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
                            Pengajuan Program Kegiatan
                        @else
                            Daftar Program Kegiatan
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @can('program_kegiatan.create')
                            @if (auth()->user()->hasRole('Ketua'))
                                <a href="{{ route('program_kegiatan.create') }}" class="btn btn-primary mb-3">
                                    <i class="fa fa-plus"></i> Ajukan Program Kegiatan
                                </a>
                            @endif
                        @endcan

                        <table id="tabelPembinaProgramKegiatan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Program</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Deskripsi</th>
                                    <th>Diverifikasi oleh</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programKegiatan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
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
                                        <td>
                                            {{ $item->keterangan ?? 'Tidak ada keterangan' }}
                                        </td>
                                        <td>
                                            @if (auth()->user()->hasRole('Pembina'))
                                                @if ($item->status == 'pending')
                                                    @can('program_kegiatan.verifikasi')
                                                        <form id="form-verifikasi-disetujui-{{ $item->id_program_kegiatan }}"
                                                            action="{{ route('program_kegiatan.verifikasi', $item->id_program_kegiatan) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <input type="hidden" name="keterangan"
                                                                id="keterangan-disetujui-{{ $item->id_program_kegiatan }}">
                                                        </form>
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            onclick="confirmVerification('form-verifikasi-disetujui-{{ $item->id_program_kegiatan }}', 'disetujui')">
                                                            Disetujui
                                                        </button>

                                                        <form id="form-verifikasi-ditolak-{{ $item->id_program_kegiatan }}"
                                                            action="{{ route('program_kegiatan.verifikasi', $item->id_program_kegiatan) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <input type="hidden" name="keterangan"
                                                                id="keterangan-ditolak-{{ $item->id_program_kegiatan }}">
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmVerification('form-verifikasi-ditolak-{{ $item->id_program_kegiatan }}', 'ditolak')">
                                                            Ditolak
                                                        </button>
                                                    @endcan
                                                @else
                                                    @can('program_kegiatan.show')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#showModal{{ $item->id_program_kegiatan }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    @endcan
                                                @endif
                                            @elseif (auth()->user()->hasRole('Ketua'))
                                                @if ($item->status == 'pending')
                                                    <form id="delete-program-kegiatan-{{ $item->id_program_kegiatan }}"
                                                        action="{{ route('program_kegiatan.destroy', $item->id_program_kegiatan) }}"
                                                        method="POST" style="display:inline;">
                                                        @can('program_kegiatan.edit')
                                                            <a href="{{ route('program_kegiatan.edit', $item->id_program_kegiatan) }}"
                                                                class="btn btn-warning btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('program_kegiatan.destroy')
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete('delete-program-kegiatan-{{ $item->id_program_kegiatan }}')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endcan
                                                    </form>
                                                    @can('program_kegiatan.show')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#showModal{{ $item->id_program_kegiatan }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    @endcan
                                                @else
                                                    @can('program_kegiatan.show')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#showModal{{ $item->id_program_kegiatan }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    @endcan
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="showModal{{ $item->id_program_kegiatan }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Detail Program Kegiatan
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama Program:</strong> {{ $item->nama_program }}</p>
                                                    <p><strong>Tahun Ajaran:</strong> {{ $item->tahun_ajaran }}</p>
                                                    <p><strong>Deskripsi:</strong> {{ $item->deskripsi }}</p>
                                                    <p><strong>Diverifikasi oleh:</strong>
                                                        @if ($item->pembina && $item->pembina->nama)
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmVerification(formId, action) {
            let title, text, confirmButtonText;
            if (action === 'disetujui') {
                title = 'Konfirmasi Persetujuan';
                text = 'Apakah Anda yakin ingin menyetujui program kegiatan ini?';
                confirmButtonText = 'Setujui';
            } else if (action === 'ditolak') {
                title = 'Konfirmasi Penolakan';
                text = 'Apakah Anda yakin ingin menolak program kegiatan ini?';
                confirmButtonText = 'Tolak';
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
    </script>
@endsection
