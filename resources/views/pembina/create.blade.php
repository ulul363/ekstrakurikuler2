@extends('layouts.master')

@section('template_title')
    Buat Pembina
@endsection

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Buat Pembina</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pembina.index') }}">Pembina</a></li>
                            <li class="breadcrumb-item">Buat Pembina</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Buat Pembina</div>

                    <form method="POST" action="{{ route('pembina.store') }}" role="form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $id_user }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="number" name="nip" class="form-control" id="nip" placeholder="NIP" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="{{ $user_name }}" required>
                                </div>
                                <!-- Menghapus alamat, jenis_kelamin, dan no_hp -->
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
