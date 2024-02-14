@include('layouts.admin-partials._header')
    
<div id="app">
    <div class="container mt-3">
        <div class="row">
            <div class="col-8 col-md-6">
                <img src="{{ asset('assets/images/cdl-logo.png') }}" alt="CDL Logo" width="50%" class="cdl-logo">
            </div>
            <div class="col-8 col-md-6 text-right d-flex justify-content-end align-items-center">
                <h1>Duty Diary</h1>
                <img src="{{ asset('assets/icons/diary-icon.ico') }}" alt="Diary Logo" width="15%">
            </div>
        </div>
    </div>
    <div id="wrapper" class="mt-4">
        <main id="content-area" style="width: 100%!important">
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content" class="pb-2">

                    <!-- Begin Page Content -->
                    <div class="container pb-2 mb-2">

                        @yield('content')

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->
        </main>
    </div>
</div>
