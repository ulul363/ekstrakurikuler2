@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Hasil Evaluasi Kinerja</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Hasil SPK MARCOS</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Peringkat Ekstrakurikuler Terbaik (Metode MARCOS)</h5>
                        <span class="d-block m-t-5">Diurutkan berdasarkan nilai fungsi utilitas kompromi tertinggi.</span>
                    </div>
                    <div class="card-body table-border-style">

                        @if(isset($message))
                            <div class="alert alert-warning text-center">
                                <i class="feather icon-alert-triangle" style="font-size: 24px;"></i>
                                <h5 class="mt-2">{{ $message }}</h5>
                                <p>Pastikan minimal ada 2 ekstrakurikuler yang sudah dinilai agar SPK dapat melakukan
                                    perangkingan.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tabelRanking">
                                    <thead class="thead-light" style="background-color: #f8f9fa;">
                                        <tr class="text-center">
                                            <th>Peringkat</th>
                                            <th>Nama Ekstrakurikuler</th>
                                            <th>Nilai Preferensi $f(K)$</th>
                                            <th>Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ranking as $item)
                                            <tr class="text-center">
                                                <td>
                                                    @if($item['rank'] == 1)
                                                        <span class="badge badge-warning" style="font-size: 14px;"><i
                                                                class="fas fa-trophy"></i> {{ $item['rank'] }}</span>
                                                    @elseif($item['rank'] == 2)
                                                        <span class="badge badge-secondary"
                                                            style="font-size: 14px;">{{ $item['rank'] }}</span>
                                                    @elseif($item['rank'] == 3)
                                                        <span class="badge badge-danger"
                                                            style="font-size: 14px;">{{ $item['rank'] }}</span>
                                                    @else
                                                        <span class="badge badge-light text-dark"
                                                            style="font-size: 14px;">{{ $item['rank'] }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-left font-weight-bold">{{ $item['alternatif'] }}</td>
                                                <td>{{ $item['score'] }}</td>
                                                <td>
                                                    @if($item['rank'] <= 3)
                                                        <span class="badge badge-success">Sangat Baik</span>
                                                    @else
                                                        <span class="badge badge-info">Baik</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#tabelRanking').DataTable();
        });
    </script>
@endsection