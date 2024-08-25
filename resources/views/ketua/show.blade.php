@extends('layouts.master')
@section('content')

<div class="pcoded-content">

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Selamat Datang <span>{{ Auth::user()->name }}</span></h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">Detail Ketua</div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>NIS Ketua:</strong>
                        {{ $ketua->nis }}
                    </div>

                    <div class="form-group">
                        <strong>Nama:</strong>
                        {{ $ketua->nama }}
                    </div>

                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $ketua->email }}
                    </div>

                    <div class="form-group">
                        <strong>No HP:</strong>
                        {{ $ketua->no_hp }}
                    </div>

                    <div class="form-group">
                        <strong>Alamat:</strong>
                        {{ $ketua->alamat }}
                    </div>

                    <div class="form-group">
                        <strong>Jenis Kelamin:</strong>
                        {{ $ketua->jk }}
                    </div>

                    {{-- <div class="form-group">
                        <strong>Ekstrakurikuler:</strong>
                        {{ $ketua->ekstrakurikuler->nama }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>
@endsection
