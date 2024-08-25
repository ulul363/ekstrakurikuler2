@extends('layouts.master')

@section('content')
    <div class="pcoded-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Ekstrakurikuler</h5>
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
                    <div class="card-header">Tambah Ekstrakurikuler</div>

                    <div class="card-body">
                        <form action="{{ route('ekstrakurikuler.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama Ekstrakurikuler</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Ekstrakurikuler</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ketua_nama">Nama Ketua</label>
                                <input type="text" class="form-control" id="ketua_nama" name="ketua_nama">
                            </div>
                            <div class="form-group">
                                <label for="ketua_nis">NIS Ketua</label>
                                <input type="text" class="form-control" id="ketua_nis" name="ketua_nis">
                            </div>
                            <div class="form-group">
                                <label for="pembina_nama">Nama Pembina</label>
                                <input type="text" class="form-control" id="pembina_nama" name="pembina_nama">
                            </div>
                            <div class="form-group">
                                <label for="pembina_nip">NIP Pembina</label>
                                <input type="text" class="form-control" id="pembina_nip" name="pembina_nip">
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
