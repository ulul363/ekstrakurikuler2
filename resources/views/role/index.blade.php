@extends('layouts.master')
@section('content')

<div class="pcoded-content">

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Managemen Role</span></h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Role Akses Kontrol</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Role Akses Kontrol</h3>
                            </div>

                            @can('role.create')
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('role.create') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-plus"></i> Tambah Role Baru
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0 border-0 star-student table-hover table-center datatable table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <form id="delete-role-{{ $role->id }}" action="{{ route('role.destroy', $role->id) }}" method="POST">
                                                @can('role.edit')
                                                    <a class="btn btn-primary me-2" style="color: white;"
                                                        href="{{ route('role.edit', $role->id) }}">Edit</a>
                                                @endcan

                                                @can('role.destroy')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="confirmDelete('delete-role-{{ $role->id }}')">Hapus</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
