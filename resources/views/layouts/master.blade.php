<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sistem Informasi Ekstrakurikuler MAN Demak</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ URL::to('assets/images/logo-man3.png') }}" type="image/x-icon">

    <!-- vendor css -->
<link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- DataTables Bahasa Indonesia -->
    <!-- Sertakan CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body class="">
    @include('layouts.sidebar')

    @include('layouts.header')

    <div class="pcoded-main-container">
        @yield('content')
    </div>

    <!-- Required Js -->
    <script src="{{ URL::to('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/pcoded.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Apex Chart -->
    <script src="{{ URL::to('assets/js/plugins/apexcharts.min.js') }}"></script>


    <!-- custom-chart js -->
    <script src="{{ URL::to('assets/js/pages/dashboard-main.js') }}"></script>
    <script src="{{ asset('node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Script untuk SweetAlert2 konfirmasi penghapusan -->

    <script>
        function confirmDelete(formId) {
            var form = document.getElementById(formId);
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika pengguna memilih Ya
                }
            });
        }
    </script>

    <!-- Datatables -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.js"></script>

    <!-- Atur bahasa global untuk semua DataTable -->
    <script>
        $(document).ready(function() {
            $.extend(true, $.fn.dataTable.defaults, {
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/2.1.0/i18n/id.json"
                }
            });
            
            $('#tabelKetua').DataTable();
            $('#tabelEkstrakurikuler').DataTable();
            $('#tabelPrestasi').DataTable();
            $('#tabelKehadiran').DataTable();
            $('#tabelProgramKegiatan').DataTable();
            $('#tableJadwalEkstra').DataTable();
            $('#tabelDaftarAnggota').DataTable();
            $('#tableEkstrakurikuler').DataTable();


            $('#tabelPembinaProgramKegiatan').DataTable();
            $('#tabelPembinaKehadiran').DataTable();
            $('#tabelPembinaPrestasi').DataTable();
            $('#tabelPembinaPertemuan').DataTable();

        });
    </script>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    
    {{-- <script>
        function confirmVerification(formId, status) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengubah ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ' + status + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script> --}}


    {{-- <script>
        // Fungsi Konfirmasi Penghapusan
        <script
        script >
            // Konfirmasi penghapusan
            function confirmDelete(formId) {
                var form = document.getElementById(formId);
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika pengguna memilih Ya
                    }
                });
            }

        // Konfirmasi verifikasi
        function confirmVerification(url, status) {
            const actionText = status === 'disetujui' ? 'menyetujui' : 'menolak';
            Swal.fire({
                title: `Konfirmasi ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}`,
                text: `Apakah Anda yakin ingin ${actionText} item ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: `Ya, ${actionText}`,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form to submit
                    const form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    // Add method field
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'POST';
                    form.appendChild(methodField);

                    // Add status field
                    const statusField = document.createElement('input');
                    statusField.type = 'hidden';
                    statusField.name = 'status';
                    statusField.value = status;
                    form.appendChild(statusField);

                    // Append and submit form
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script> --}}

    {{-- <script>
    function confirmVerification(url, status) {
        const actionText = status === 'disetujui' ? 'menyetujui' : 'menolak';
        Swal.fire({
            title: `Konfirmasi ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}`,
            text: `Apakah Anda yakin ingin ${actionText} item ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: `Ya, ${actionText}`,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form to submit
                const form = document.createElement('form');
                form.action = url;
                form.method = 'POST';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);

                // Add method field
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'POST';
                form.appendChild(methodField);

                // Add status field
                const statusField = document.createElement('input');
                statusField.type = 'hidden';
                statusField.name = 'status';
                statusField.value = status;
                form.appendChild(statusField);

                // Append and submit form
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function confirmDelete(formId) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Apakah Anda yakin ingin menghapus item ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script> --}}



    @yield('scripts')
</body>

</html>
