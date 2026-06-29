@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Pesan & Obrolan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Daftar Kontak</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-modern">
                    <div class="card-header">
                        <h5>Mulai Obrolan Baru</h5>
                        <span class="d-block m-t-5">Pilih kontak untuk mulai berdiskusi terkait ekstrakurikuler.</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- LOOPING DATA KONTAK --}}
                            {{-- Ganti $users dengan variabel dari Controller Anda (misal $contacts) jika error --}}
                            @forelse($users as $user)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card shadow-sm border border-light text-center summary-card h-100">
                                        <div class="card-body pt-4">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=80"
                                                class="img-radius rounded-circle mb-3 shadow-sm" alt="Profile">
                                            <h5 class="mb-1 font-weight-bold">{{ $user->name }}</h5>
                                            <p class="text-muted mb-3">{{ $user->roles->first()->name ?? 'Pengguna' }}</p>
                                            <a href="{{ route('chatroom.show', $user->id) }}"
                                                class="btn btn-primary btn-sm btn-block rounded-pill">
                                                <i class="feather icon-message-circle"></i> Chat Sekarang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <i class="feather icon-users text-muted mb-3" style="font-size: 50px;"></i>
                                    <h5 class="text-muted">Belum ada kontak yang tersedia untuk Anda.</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection