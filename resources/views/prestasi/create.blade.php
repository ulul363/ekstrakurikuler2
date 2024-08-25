@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Prestasi</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('prestasi.index') }}">Prestasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('prestasi.create') }}">Tambah Prestasi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- <pre>{{ print_r($daftaranggota, true) }}</pre> --}}

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Tambah Prestasi</div>
                    <div class="card-body">
                        <form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="prestasi">Prestasi</label>
                                <input type="text" name="prestasi" id="prestasi"
                                    class="form-control @error('prestasi') is-invalid @enderror"
                                    value="{{ old('prestasi') }}" required>
                                @error('prestasi')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>
                                <select name="nama_siswa[]" id="nama_siswa" class="form-control" multiple required>
                                    @foreach($daftaranggota as $anggota)
                                        <option value="{{ $anggota->nama }}">{{ $anggota->nama }} - {{ $anggota->kelas }}</option>
                                    @endforeach
                                </select>
                                {{-- <select name="nama_siswa[]" class="form-control select2" multiple="multiple">
                                    @foreach($daftaranggota as $anggota)
                                        <option value="{{ $anggota->nama }}">{{ $anggota->nama }}</option>
                                    @endforeach
                                </select>                                 --}}
                            </div>

                            <div class="form-group">
                                <label for="tahun_ajaran">Tahun Ajaran</label>
                                <input type="number" name="tahun_ajaran" id="tahun_ajaran"
                                    class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                    value="{{ old('tahun_ajaran') }}" required max="9999">
                                @error('tahun_ajaran')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="berkas">Berkas</label>
                                <input type="file" name="berkas" id="berkas"
                                    class="form-control @error('berkas') is-invalid @enderror" required>
                                @error('berkas')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function() {
            // Initialize Select2 on the siswa select box
            $('#nama_siswa').select2({
                placeholder: "Pilih nama siswa",
                allowClear: true
            });

            $('#tahun_ajaran').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
        });
    </script>
@endsection
