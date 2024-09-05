<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Software Access Management</title>

    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

<<<<<<< HEAD
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include FontAwesome CSS (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Font Style By --}}

=======
    <!-- Custom Khmer Fonts -->
>>>>>>> bc0498dfa73999e5613696a664f5ef6fcd73b499
    <link href="https://fonts.googleapis.com/css2?family=Siemreap&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Khmer+OS+Muol+Light&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css">

    @yield('styles')
</head>
<<<<<<< HEAD
=======


>>>>>>> bc0498dfa73999e5613696a664f5ef6fcd73b499
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <div style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1030; background-color: rgb(202, 59, 59);">
                    @include('layouts.navigation.navigation')
                </div>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid"  style="padding-top: 90px;">

                    {{-- Component Button --}}
                    @yield('dashboardui')

                    @yield('programs')
                    @yield('card_certificate')
                    @yield('total_card')

                    @yield('result')
                    @yield('result-total-table')
                    @yield('result-total-general-table')




                    @yield('result-success')
                    @yield('result-general-pay')
                    @yield('result-administrative-plan')
                    @yield('result-total-summaries')

                    @yield('content-mission')
                    @yield('content-table-mission-cambodia')



                    {{-- key form --}}
                    @yield('content-key')
                    @yield('form-key-upload')
                    @yield('form-key-edit')

                    {{-- account form --}}
                    @yield('content-account')
                    @yield('form-account-upload')
                    @yield('form-account-edit')

                    {{-- sub-account form --}}
                    @yield('content-sub-account')
                    @yield('form-sub-account-upload')
                    @yield('form-sub-account-edit')

                    {{-- report form --}}
                    @yield('content-report')
                    @yield('form-report-upload')
                    @yield('form-report-edit')

                    @yield('form-form-mission')

                    <div class="container-fluid">

                        @yield('user-data')
                        @yield('user-create')
                        @yield('location-index')
                        @yield('location-update')
                        @yield('form-location-upload')

                    </div>

                    {{--                        Start Certificate                          --}}
                    @yield('content-certificate')
                    @yield('form-certificate-upload')
                    @yield('form-certificate-edit')
                    @yield('content-certificate-data')
                    @yield('form-certificate-data-upload')
                    @yield('form-certificate-data-edit')
                    @yield('content-certificate-amount')
                    {{--                        End Certificate                          --}}

                    {{--                        Start Loans Total                         --}}

                    @yield(' loan-total')
                    @yield('result-new-loan')
                    @yield('result-remain')
                    @yield('result-sum-refer')
                    {{--                        End Loans Total                         --}}

                    {{--                        Start Import Data                         --}}

                    @yield('content-import-data')
                    {{--                        End Import Data                         --}}


                </div>

            </div>
            <!-- /.container-fluid -->
<<<<<<< HEAD

=======
>>>>>>> bc0498dfa73999e5613696a664f5ef6fcd73b499
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    {{-- <main class="py-4 bg-light">
        <div class="container">
            @yield('table')
        </div>
    </main> --}}

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    @yield('scripts')

    {{-- <script src="{{ asset('js/custom.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>

</html>
