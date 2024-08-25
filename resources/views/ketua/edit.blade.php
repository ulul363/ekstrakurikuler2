@extends('layouts.master')

@section('template_title')
    Edit Ketua
@endsection

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Ketua</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('ketua.index') }}">Ketua</a></li>
                            <li class="breadcrumb-item">Edit Ketua</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="edit-ketua-tab" data-toggle="tab" href="#edit-ketua"
                                    role="tab" aria-controls="edit-ketua" aria-selected="true">Edit Ketua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="reset-password-tab" data-toggle="tab" href="#reset-password"
                                    role="tab" aria-controls="reset-password" aria-selected="false">Reset Password</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="edit-ketua" role="tabpanel"
                                aria-labelledby="edit-ketua-tab">
                                <form method="POST" action="{{ route('ketua.update', $ketua->id_ketua) }}" role="form">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="user_id">User</label>
                                                <input type="text" name="user_id" class="form-control" id="user_id" value="{{ $ketua->user_id }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nis">NIS</label>
                                                <input type="number" name="nis" class="form-control" id="nis" value="{{ $ketua->nis }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" name="nama" class="form-control" id="nama" value="{{ $ketua->nama }}" required>
                                            </div>
                                            <!-- Menghapus alamat, jenis_kelamin, dan no_hp -->
                                        </div>
                                        
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <!-- ... -->
                            <div class="tab-pane fade" id="reset-password" role="tabpanel"
                                aria-labelledby="reset-password-tab">
                                <form method="POST" action="{{ route('ketua.updateUser', $ketua->user_id) }}"
                                    role="form">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                    value="{{ $ketua->user->name }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control" id="email"
                                                    value="{{ $ketua->user->email }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password Baru</label>
                                                <input type="password" name="password" class="form-control"
                                                    id="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    id="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                            <!-- ... -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
