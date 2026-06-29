@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Pengajuan Pertemuan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pertemuan.index') }}">Pertemuan</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-12">
                <div class="card card-modern">
                    <div class="card-header bg-warning">
                        <h5 class="text-white mb-0"><i class="feather icon-edit"></i> Edit Jadwal Pertemuan</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pertemuan.update', $pertemuan->id_pengajuan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Judul Pertemuan / Rapat <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="judul_pertemuan" class="form-control"
                                    value="{{ old('judul_pertemuan', $pertemuan->judul_pertemuan) }}" required>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tanggal Rencana <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_rencana" class="form-control"
                                            value="{{ old('tanggal_rencana', $pertemuan->tanggal_rencana) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Waktu Mulai <span
                                                class="text-danger">*</span></label>
                                        <input type="time" name="waktu_rencana" class="form-control"
                                            value="{{ old('waktu_rencana', \Carbon\Carbon::parse($pertemuan->waktu_rencana)->format('H:i')) }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Agenda / Deskripsi Singkat <span
                                        class="text-danger">*</span></label>
                                <textarea name="agenda_pertemuan" class="form-control" rows="4"
                                    required>{{ old('agenda_pertemuan', $pertemuan->agenda_pertemuan) }}</textarea>
                            </div>

                            <div class="text-right">
                                <a href="{{ route('pertemuan.index') }}" class="btn btn-light mr-2">Batal</a>
                                <button type="submit" class="btn btn-warning"><i class="feather icon-save"></i> Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection