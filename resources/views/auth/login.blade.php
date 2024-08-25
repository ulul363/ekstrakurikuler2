<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sistem Informasi Ekstrakurikuler</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('dist/assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
</head>

<body>
    <!-- [ auth-signin ] start -->
    <div class="auth-wrapper" style="background-image: url({{ asset('/assets/images/bg-man.jpg') }})">
        <div class="auth-content text-center">
            <div class="card borderless">
                <div class="row align-items-center ">
                    <div class="col-md-12">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/logo-man3.png') }}" alt="bg-man" class="img-fluid mb-4">
                            <h5 class="mb-3 f-w-400"> <b>Sistem Informasi Ekstrakurikuler</b> </h5>
                            <h5> <b>MA Negeri Demak</b> </h5>
                            <hr>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="email" id="Email"
                                        placeholder="Email address" required>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" class="form-control" name="password" id="Password"
                                        placeholder="Password" required>
                                </div>
                                {{-- <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1"
                                        name="remember">
                                    <label class="custom-control-label" for="customCheck1">Save credentials.</label>
                                </div> --}}
                                <button type="submit" class="btn btn-block btn-primary mb-4">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signin ] end -->

    <!-- Required Js -->
    <script src="{{ asset('dist/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/assets/js/pcoded.min.js') }}"></script>
</body>

</html>
