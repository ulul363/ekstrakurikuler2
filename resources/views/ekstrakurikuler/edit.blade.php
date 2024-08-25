@extends('layouts.master')

@section('content')
    <div class="pcoded-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Ekstrakurikuler</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Edit Ekstrakurikuler</div>

                    <div class="card-body">
                        <form action="{{ route('ekstrakurikuler.update', $ekstrakurikuler->id_ekstrakurikuler) }}" method="POST">
                            @csrf
                            @method('PUT')
                        
                            <div class="form-group">
                                <label for="nama">Nama Ekstrakurikuler</label>
                                <input type="text" name="nama" class="form-control" value="{{ $ekstrakurikuler->nama }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Ekstrakurikuler</label>
                                <textarea name="deskripsi" class="form-control" required>{{ $ekstrakurikuler->deskripsi }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="ketua_nama">Nama Ketua</label>
                                <input type="text" name="ketua_nama" class="form-control" value="{{ $ekstrakurikuler->ketua->nama ?? '' }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="ketua_nis">NIS Ketua</label>
                                <input type="text" name="ketua_nis" class="form-control" value="{{ $ekstrakurikuler->ketua->nis ?? '' }}">
                            </div>
                        
                            <!-- Perbaiki bagian ini dengan loop untuk pembina -->
                            <div class="form-group">
                                <label for="pembina_nama">Nama Pembina</label>
                                @foreach($ekstrakurikuler->pembina as $pembina)
                                    <input type="text" name="pembina_nama[]" class="form-control" value="{{ $pembina->nama }}" readonly>
                                @endforeach
                            </div>
                        
                            <div class="form-group">
                                <label for="pembina_nip">NIP Pembina</label>
                                @foreach($ekstrakurikuler->pembina as $pembina)
                                    <input type="text" name="pembina_nip[]" class="form-control" value="{{ $pembina->nip }}" readonly>
                                @endforeach
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('ekstrakurikuler.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
