@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Kehadiran</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kehadiran.index') }}">Kehadiran</a></li>
                            <li class="breadcrumb-item">Tambah Kehadiran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tambah Kehadiran</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('kehadiran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="nama_kegiatan">Nama Kegiatan</label>
                                <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                    class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                    value="{{ old('nama_kegiatan') }}" required>
                                @error('nama_kegiatan')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
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
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                @error('tanggal')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" required style="width: 100%; height: 150px;">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="berkas">Berkas (Gambar atau PDF)</label>
                                <input type="file" class="form-control-file" id="berkas" name="berkas"
                                    accept="image/*,application/pdf" onchange="previewFile()">
                                @error('berkas')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div id="preview" class="mb-3"></div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('kehadiran.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewFile() {
            const preview = document.getElementById('preview');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                const fileType = file.type;
                if (fileType.startsWith('image')) {
                    preview.innerHTML =
                        `<img src="${reader.result}" class="img-fluid" style="max-height: 400px;" alt="Preview Gambar">`;
                } else if (fileType === 'application/pdf') {
                    preview.innerHTML =
                        `<embed src="${reader.result}" type="application/pdf" style="width: 100%; height: 600px;" />`;
                }
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#tahun_ajaran').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        #preview {
            text-align: center;
            margin-bottom: 10px;
        }

        #preview img {
            max-width: 100%;
            height: 400px;
        }

        #preview embed {
            max-width: 100%;
            height: 600px;
        }
    </style>
@endsection
