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
    <!-- Scripts -->


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
                                <span class="nav-bump"><strong>Welcome,  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></span>
                                <span class="nav-bump"><a><strong>Who's Online(0)</strong></a></span>
                                <span><a href='/auth/logout'>Sign Out</a></span>
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
                        <a data-toggle="modal" data-target="#search_account">
                   <span class="act_tools act_tool_search" title="Look up another account">
                        <i class="fa fa-lg fa-search" style="color:#fff;"></i>
                    </span></a>
                    </div>
                    @if(isset($me['15']) && $me['15'])
                        <div class="menu-tool-btn">
                            <a href="/account/edit/{{ $act->accountNumber or '' }}">
                    <span class="act_tools act_tool_edit" title="Edit this report">
                        <i class="fa fa-lg fa-edit" style="color:#fff;"></i>
                    </span></a>
                        </div>
                    @endif
                    <div class="menu-tool-btn">
                        <a onclick="window.print()">
                            <span class="act_tools act_tool_edit" title="Print Report">
                                <i class="fa fa-lg fa-print" style="color:#fff;"></i>
                            </span>
                        </a>
                    </div>
                    @if(isset($me['141']) && $me['141'] )
                        <div class="menu-tool-btn">
                            <a title="Add Field Activity"
                               data-toggle="modal" data-target="#addFaModal">
                    <span class="act_tools act_tool_add" title="Add Field Activity"
                          style="color:white;">
                        <i class="fa fa-lg fa-plus" style="color:#fff;"></i> Field Activity
                    </span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container sdg_bumper_60">
    <div class="modal fade" id="search_car">
        <div class="modal-dialog">
            <div class="modal-content sdg_bumper_60">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 id="modal-header" class="modal-title">Customer Activity Report</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form target="_blank" id="car-report" role="form" method="post" action="{{ route('car') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{--@include('partials.reports.pop-up-car')--}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger alert-danger" data-dismiss="modal">Close</button>
                    <!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="search_account">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 id="modal-header" class="modal-title">Find Another Account</h4>
                </div>
                <div class="modal-body">

                    <div>
                        <div class="input-group">
                            <input id="search_act" type="text" class="form-control act-search"
                                   placeholder="Search by Account Number or Company Name">

                                    <span class="input-group-btn">
                                        <a id='search-act-submit-btn' href='/account' class="btn btn-primary act-btn"
                                           type="button">View</a>
                                    </span>

                            <div style="position: relative" id="autoDisplay" class="autoDisplay"></div>


                        </div><!-- /input-group -->
                        <div id="searchFade" class="tooltip bottom tooltipFade" role="tooltip">
                            <div class="tooltip-arrow"></div>
                            <div id="search_display" class="tooltip-inner auto_display">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger alert-danger" data-dismiss="modal">Close</button>
                    <!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

    <div class="container sdg_bumper_60">
@yield('content')
    </div>

<!-- Modal -->
<div class="modal fade" id="addFaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top: 80px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Field Activity</h4>
            </div>
            <div class="modal-body">
                <div class="">
                @include('partials.field.field-activity')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger alert-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<footer>
    @yield('footer')
</footer>
<!-- Scripts -->
@yield('scripts')

@section('scripts')
    <script src="<?php echo asset('/js/app.backend.js'); ?>" type="text/javascript"></script>
@endsection
</body>
</html>
