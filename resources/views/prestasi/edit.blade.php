@extends('layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Prestasi</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('prestasi.index') }}">Prestasi</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('prestasi.edit', $prestasi->id_prestasi) }}">Edit
                                    Prestasi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">Edit Prestasi</div>
                    <div class="card-body">
                        <form action="{{ route('prestasi.update', $prestasi->id_prestasi) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="prestasi">Prestasi</label>
                                <input type="text" name="prestasi" id="prestasi"
                                    class="form-control @error('prestasi') is-invalid @enderror"
                                    value="{{ old('prestasi', $prestasi->prestasi) }}" required>
                                @error('prestasi')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div id="nama_siswa_wrapper">
                                @forelse ($nama_siswa as $index => $siswa)
                                    <div class="form-group form-group-wrapper">
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="nama_siswa">Nama Siswa</label>
                                                <input type="text" name="nama_siswa[]"
                                                    class="form-control @error('nama_siswa.*') is-invalid @enderror"
                                                    value="{{ old('nama_siswa.' . $index, $siswa) }}" required>
                                                @error('nama_siswa.*')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <label for="kelas">Kelas</label>
                                                <select name="kelas[]"
                                                    class="form-control @error('kelas.*') is-invalid @enderror" required>
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach (['X', 'XI', 'XII'] as $romawi)
                                                        <optgroup label="Kelas {{ $romawi }}">
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                <option value="{{ $romawi }} {{ $i }}"
                                                                    {{ old('kelas.' . $index, $kelas[$index] ?? '') == $romawi . ' ' . $i ? 'selected' : '' }}>
                                                                    {{ $romawi }} {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                @error('kelas.*')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btn btn-danger mt-1 remove-form-group">Hapus</button>
                                    </div>
                                @empty
                                    <p>Tidak ada siswa untuk ditampilkan</p>
                                @endforelse
                            </div>
                            <button type="button" id="add_nama_siswa" class="btn btn-secondary mb-3">Tambah Nama Siswa &
                                Kelas</button>

                            <div class="form-group">
                                <label for="tahun_ajaran">Tahun Ajaran</label>
                                <input type="number" name="tahun_ajaran" id="tahun_ajaran"
                                    class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                    value="{{ old('tahun_ajaran', $prestasi->tahun_ajaran) }}" required max="9999">
                                @error('tahun_ajaran')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="berkas">Berkas</label>
                                <input type="file" name="berkas" id="berkas"
                                    class="form-control @error('berkas') is-invalid @enderror">
                                @if ($prestasi->berkas)
                                    <a href="{{ asset('storage/' . $prestasi->berkas) }}" target="_blank">Lihat Berkas Saat
                                        Ini</a>
                                @endif
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
    <script>
        document.getElementById('add_nama_siswa').addEventListener('click', function() {
            var wrapper = document.getElementById('nama_siswa_wrapper');

            var newWrapper = document.createElement('div');
            newWrapper.className = 'form-group form-group-wrapper';
            newWrapper.innerHTML =
                '<div class="form-row">' +
                '    <div class="col">' +
                '        <label for="nama_siswa">Nama Siswa</label>' +
                '        <input type="text" name="nama_siswa[]" class="form-control" required>' +
                '    </div>' +
                '    <div class="col">' +
                '        <label for="kelas">Kelas</label>' +
                '        <select name="kelas[]" class="form-control" required>' +
                '            <option value="">Pilih Kelas</option>' +
                '            @foreach (['X', 'XI', 'XII'] as $romawi)' +
                '                <optgroup label="Kelas {{ $romawi }}">' +
                '                    @for ($i = 1; $i <= 10; $i++)' +
                '                        <option value="{{ $romawi }} {{ $i }}">{{ $romawi }} {{ $i }}</option>' +
                '                    @endfor' +
                '                </optgroup>' +
                '            @endforeach' +
                '        </select>' +
                '    </div>' +
                '</div>' +
                '<button type="button" class="btn btn-danger mt-1 remove-form-group">Hapus</button>';

            wrapper.appendChild(newWrapper);
        });

        document.getElementById('nama_siswa_wrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-form-group')) {
                e.target.closest('.form-group-wrapper').remove();
            }
        });
    </script>
@endsection
