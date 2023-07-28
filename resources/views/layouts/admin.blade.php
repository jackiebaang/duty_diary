@include('layouts.admin-partials._header')
    
    <div id="app">

        <div id="wrapper">
            @include('layouts.admin-partials._sidebar')
            <main id="content-area">
                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        @include('layouts.admin-partials._topbar')

                        <!-- Begin Page Content -->
                        <div class="container-fluid bg-danger">

                            @yield('content')

                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

                    @include('layouts.admin-partials._footer-block')

                </div>
                <!-- End of Content Wrapper -->
            </main>
        </div>
    </div>

    @include('layouts.admin-partials._scroll-to-top')

    @include('layouts.admin-partials._logout-modal')

    @include('layouts.admin-partials._footer')
