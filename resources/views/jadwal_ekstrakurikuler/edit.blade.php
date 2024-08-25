@extends('layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Jadwal Ekstrakurikuler</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jadwal_ekstrakurikuler.index') }}">Jadwal
                                    Ekstrakurikuler</a></li>
                            <li class="breadcrumb-item"><a href="#">Edit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Edit Jadwal Ekstrakurikuler</div>

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

                        <form
                            action="{{ route('jadwal_ekstrakurikuler.update', $jadwalEkstrakurikuler->id_jadwal_ekstrakurikuler) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="ekstrakurikuler_id">Ekstrakurikuler</label>
                                <select name="ekstrakurikuler_id" id="ekstrakurikuler_id" class="form-control">
                                    @foreach ($ekstrakurikuler as $item)
                                        <option value="{{ $item->id_ekstrakurikuler }}"
                                            {{ $item->id_ekstrakurikuler == $jadwalEkstrakurikuler->ekstrakurikuler_id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hari">Hari</label>
                                <select name="hari" id="hari" class="form-control">
                                    <option value="Senin" {{ $jadwalEkstrakurikuler->hari == 'Senin' ? 'selected' : '' }}>
                                        Senin</option>
                                    <option value="Selasa" {{ $jadwalEkstrakurikuler->hari == 'Selasa' ? 'selected' : '' }}>
                                        Selasa</option>
                                    <option value="Rabu" {{ $jadwalEkstrakurikuler->hari == 'Rabu' ? 'selected' : '' }}>
                                        Rabu</option>
                                    <option value="Kamis" {{ $jadwalEkstrakurikuler->hari == 'Kamis' ? 'selected' : '' }}>
                                        Kamis</option>
                                    <option value="Jumat" {{ $jadwalEkstrakurikuler->hari == 'Jumat' ? 'selected' : '' }}>
                                        Jumat</option>
                                    <option value="Sabtu" {{ $jadwalEkstrakurikuler->hari == 'Sabtu' ? 'selected' : '' }}>
                                        Sabtu</option>
                                    <option value="Minggu"
                                        {{ $jadwalEkstrakurikuler->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="waktu">Waktu</label>
                                <input type="time" name="waktu" id="waktu" class="form-control"
                                    value="{{ $jadwalEkstrakurikuler->waktu }}" required>
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control"
                                    value="{{ $jadwalEkstrakurikuler->lokasi }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
