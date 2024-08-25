@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Pertemuan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pertemuan.index') }}">Pertemuan</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('pertemuan.edit', $pertemuan->id_pengajuan_pertemuan) }}">Edit
                                    Pertemuan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Edit Pertemuan</div>
                    <div class="card-body">
                        <form action="{{ route('pertemuan.update', $pertemuan->id_pengajuan_pertemuan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="hari">Hari</label>
                                <select class="form-control" id="hari" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="senin" {{ old('hari', $pertemuan->hari) == 'senin' ? 'selected' : '' }}>
                                        Senin</option>
                                    <option value="selasa"
                                        {{ old('hari', $pertemuan->hari) == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="rabu" {{ old('hari', $pertemuan->hari) == 'rabu' ? 'selected' : '' }}>
                                        Rabu</option>
                                    <option value="kamis" {{ old('hari', $pertemuan->hari) == 'kamis' ? 'selected' : '' }}>
                                        Kamis</option>
                                    <option value="jumat" {{ old('hari', $pertemuan->hari) == 'jumat' ? 'selected' : '' }}>
                                        Jumat</option>
                                    <option value="sabtu" {{ old('hari', $pertemuan->hari) == 'sabtu' ? 'selected' : '' }}>
                                        Sabtu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', $pertemuan->tanggal->format('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="waktu">Waktu</label>
                                <input type="time" class="form-control @error('waktu') is-invalid @enderror"
                                    id="waktu" name="waktu"
                                    value="{{ old('waktu', $pertemuan->waktu->format('H:i')) }}" required>
                                @error('waktu')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
