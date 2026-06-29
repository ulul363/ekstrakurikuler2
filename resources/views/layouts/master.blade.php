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
    <link rel="icon" href="{{ URL::to('assets/images/logo-man3.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body class="">
    @include('layouts.sidebar')

    @include('layouts.header')

    @include('chatbot_ui')

    <div class="pcoded-main-container">
        @yield('content')
    </div>

    <script src="{{ URL::to('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/pcoded.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ URL::to('assets/js/plugins/apexcharts.min.js') }}"></script>

    <script src="{{ URL::to('assets/js/pages/dashboard-main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.js"></script>

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
            $('#tabelPembina').DataTable();

            $('#tabelPembinaProgramKegiatan').DataTable();
            $('#tabelPembinaKehadiran').DataTable();
            $('#tabelPembinaPrestasi').DataTable();
            $('#tabelPembinaPertemuan').DataTable();
            $('#tabelRanking').DataTable();
        });
    </script>

    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Fungsi Konfirmasi Penghapusan
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
                    form.submit();
                }
            });
        }

        // Fungsi Konfirmasi Verifikasi (Approve/Reject)
        function confirmVerification(url, status) {
            const actionText = status === 'disetujui' ? 'Menyetujui' : 'Menolak';
            const actionColor = status === 'disetujui' ? '#28a745' : '#d33';
            
            Swal.fire({
                title: `Konfirmasi Verifikasi`,
                text: `Apakah Anda yakin ingin ${actionText} data ini?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Ya, ${actionText}!`,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}'; 
                    form.appendChild(csrfToken);

                    const statusField = document.createElement('input');
                    statusField.type = 'hidden';
                    statusField.name = 'status';
                    statusField.value = status;
                    form.appendChild(statusField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    @yield('scripts')
</body>

</html>