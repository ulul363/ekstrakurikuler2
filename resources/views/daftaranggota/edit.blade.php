@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Daftar Anggota</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('daftaranggota.index') }}">Daftar Anggota</a></li>
                            <li class="breadcrumb-item"><a href="#">Edit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Edit Daftar Anggota</div>

                    <div class="card-body">
                        <form action="{{ route('daftaranggota.update', $daftaranggota) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group" hidden>
                                <label for="ekstrakurikuler_id">Ekstrakurikuler</label>
                                <select name="ekstrakurikuler_id" id="ekstrakurikuler_id" class="form-control">
                                    @foreach($ekstrakurikulers as $ekstrakurikuler)
                                        <option value="{{ $ekstrakurikuler->id_ekstrakurikuler }}" {{ $daftaranggota->ekstrakurikuler_id == $ekstrakurikuler->id_ekstrakurikuler ? 'selected' : '' }}>
                                            {{ $ekstrakurikuler->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ekstrakurikuler_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis', $daftaranggota->nis) }}">
                                @error('nis')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $daftaranggota->nama) }}">
                                @error('nama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control">
                                    @foreach (['X', 'XI', 'XII'] as $jurusan)
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $jurusan }} {{ $i }}" {{ old('kelas', $daftaranggota->kelas) == "$jurusan $i" ? 'selected' : '' }}>
                                                {{ $jurusan }} {{ $i }}
                                            </option>
                                        @endfor
                                    @endforeach
                                </select>
                                @error('kelas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('daftaranggota.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
