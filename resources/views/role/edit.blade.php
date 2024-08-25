@extends('layouts.master')
@section('content')

<div class="pcoded-content">

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Peran dan Izin</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role Akses Kontrol</a></li>
                        <li class="breadcrumb-item active">Edit Peran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">

                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title"></h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('role.getRoutesAllJson') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-undo"></i> Refresh Permissions
                                    </a>
                                    <a href="{{ route('role.getRefreshAndDeleteJson') }}" class="btn btn-warning btn-outline-warning me-2" style="color: white;">
                                        <i class="fas fa-undo"></i> Refresh & Delete Permissions
                                    </a>
                                    <button type="submit" class="btn btn-success btn-outline-success me-2" style="color: white">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-start" style="margin-top: -70px;">
                            <a href="{{ route('role.index') }}" class="btn btn-secondary me-1">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 10px;">
                            <div class="form-group">
                                <strong>Nama Role:</strong>
                                <br>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $role->name }}" placeholder="Nama Role" autofocus autocomplete="off"
                                    style="margin-top: 10px;">
                            </div>
                            <div class="form-group">
                                <strong>Guard Name:</strong>
                                <br>
                                <input type="text" name="guard_name" id="guard_name" class="form-control"
                                    value="{{ $role->guard_name }}" readonly style="margin-top: 10px;">
                            </div>
                            <strong>Permission:</strong>
                            <br> <br>
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                        class="form-check-input" id="permission{{ $permission->id }}"
                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
