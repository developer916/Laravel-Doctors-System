<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf_token" content="{{ $encrypted_csrf_token }}"/>
        <title>@yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        @yield('styles')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav>
            @yield('nav')
        </nav>
        <main class="Main_Class">
            <div id="content" class="">
                @yield('content')
            </div>
        </main>
        <div class="modal fade" id="work_area">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 id="modal-header" class="modal-title">Account Menu</h4>
                    </div>
                    <div class="modal-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="account">
                                @include('partials.menu.main-accounts')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="field">
                                @include('partials.menu.main-field')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="inventory">
                                @include('partials.menu.main-materials')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="utility">
                                @include('partials.menu.main-utilities')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="technicians">
                                @include('partials.menu.main-tech')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="reports">
                                @include('partials.menu.main-reports')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="worksheets">Worksheets</div>
                            <div role="tabpanel" class="tab-pane fade" id="users">
                                @include('partials.menu.main-users')
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger alert-danger" data-dismiss="modal">Close</button>
                        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
            </div>
        </div>
        <footer>
            @yield('footer')
        </footer>
        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>