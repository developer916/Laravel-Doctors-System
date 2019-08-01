<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <!-- Style -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet">
    <!-- Sripts -->

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-ui-1.12.1/external/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="flex-container">
    <div class="nav-upper">
        <div class="container">
            <div class="col-md-8">
                <div class="row sdg_flex">
                    <div class="col-md-4 sdg_stretch">
                        <a href="/dash"><h2 class="sdg-nav-h2">Lake Doctors Inc</h2></a>
                    </div>
                    <div class="col-md-8 sdg_stretch sdg_flex sdg_bot_bumper_5">
                        <div class="col-md-11 col-md-offset-1 sdg_flex _flex_end">
                            <div class="navbar-right sdg_flex _flex_v_end">
                                <span class="nav-bump"><strong>Welcome, John Santo</strong></span>
                                <span class="nav-bump"><a><strong>Who's Online(0)</strong></a></span>
                                <span><a href='/'>Sign Out</a></span>
                            </div>
                        </div>
                        <!--                    <div class="col-md-4 sdg_bottom sdg_stretch">
                                                <strong>
                                                    Welcome, John Santo
                                                </strong>
                                            </div>

                                            <div class="col-md-4 sdg_bottom sdg_stretch">
                                                <strong>
                                                    <a>
                                                        Who's Online (0)
                                                    </a>
                                                </strong>
                                            </div>

                                            <div class="col-md-4 sdg_bottom sdg_stretch">
                                                <a>
                                                    Sign Out
                                                </a>
                                            </div>-->

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-right sdg_bumper_3">

                    <div class="menu-tool-btn">
                   <span class="act_tools act_tool_search" title="Look up another account">
                        <i class="fa fa-lg fa-search" style="color:#fff;"></i>
                    </span>
                    </div>

                    <div class="menu-tool-btn">
                    <span class="act_tools act_tool_edit" title="Edit this report">
                        <i class="fa fa-lg fa-edit" style="color:#fff;"></i>
                    </span></a>
                    </div>

                    <a onclick="window.print()">
                        <div class="menu-tool-btn">
                            <span class="act_tools act_tool_edit" title="Print Report">
                                <i class="fa fa-lg fa-print" style="color:#fff;"></i>
                            </span>
                        </div>
                    </a>

                    <div class="menu-tool-btn">
                        <a href="/account/add">
                    <span class="act_tools act_tool_add" title="Add Field Activity"
                          style="color:white;">
                        <i class="fa fa-lg fa-plus" style="color:#fff;"></i> Add Account
                    </span>
                            </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container sdg_bumper_60">

</div>
@yield('content')

<footer>
    @yield('footer')
</footer>
<!-- Scripts -->
@yield('scripts')
</body>
</html>