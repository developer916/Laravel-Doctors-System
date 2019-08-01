@extends('landing.landingapp')

@section('title')
Lake Doctors - Sign In
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="hidden-sm hidden-xs col-md-12 sdg-h-100"></div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2>My Lake Doctors ID</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body sdg_panel_body_main sdg_min_440 sdg_flex">

                    <div class="hidden-xs hidden-sm col-md-5 sdg_stretch sdg_tool_panel">
                        <div class="col-md-10">
                            <h3>Sign in to manage<br /> Lake Doctors Workflow.</h3>
                            <p>To view and edit Lake Doctors account information, run reports and manage workflow,
                                please sign in. If you dont hvae a Lake Doctors ID, you can <a href="#support" aria-controls="support" role="tab" data-toggle="tab"> request one on our support page.</a></p>
                        </div>
                        <div class="col-md-10">

                            <!-- Nav tabs -->
<!--                            <ul class="nav " role="tablist">
                                <li ><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Home</a></li>
                                <li ><a href="#recovery" aria-controls="recovery" role="tab" data-toggle="tab">Profile</a></li>
                                <li ><a href="#support" aria-controls="support" role="tab" data-toggle="tab">support</a></li>
                            </ul>-->

                        </div>
                    </div>
                    <div class="col-md-7">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="login">

                                <div class="col-md-12">
                                    <form action="auth/login">
                                        <div class="col-md-8">
                                            <h3>Sign In</h3>
                                            <div class="sdg_bumper_25"></div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" name="email" placeholder="Lake Doctors ID" required="required">
                                                <div class="sdg_bumper_5">
                                                    <a href="#support" aria-controls="support" role="tab" data-toggle="tab">Forgot your Lake Doctor's Username?</a>
                                                </div>
                                            </div>
                                            <div class="sdg_bumper_25"></div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="required">
                                                <div class="sdg_bumper_5">
                                                    <a href="#support" aria-controls="support" role="tab" data-toggle="tab">Forgot your password?</a>
                                                </div>
                                            </div>
                                            @if(session()->has('data') && session('data')[0] == 'bad_login' )
                                                <div class="col-xs-12 col-sm-12 col-md-12 error_text">
                                                    <i class="fa fa-asterisk"></i> <span>Invalid Login Credentials.</span>
                                                </div>
                                                @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="sdg_bumper_25"></div>
                                            <hr>
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-primary">Sign In </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="recovery">


                                <div class="col-md-8">
                                    <h3>Password Recover</h3>
                                    <div class="sdg_bumper_25"></div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Lake Doctors ID">
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="sdg_bumper_25"></div>
                                    <hr>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary">Recover</button>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="support">

                                <div class="col-md-12">
                                    <h3>Lake Doctors Support</h3>
                                    <p>What do you need support with?</p>
                                </div>
                                <div class="col-md-12">

                                    <div class="col-md-10">

                                        <div class="sdg_bumper_15">
                                            <a class="recover-ctrl" data-toggle="collapse" href="#getUserName"
                                               aria-expanded="false" aria-controls="getUserName">I forgot my username.</a>
                                        </div>

                                        <div class="collapse recoverPanel" id="getUserName">

                                            <div class="col-md-12 sdg_bottom_15">
                                                <h4>
                                                    Recover User Name
                                                </h4>
                                                <p>Please enter your name and the office you work out of. Your username will be sent
                                                    to the email address on file.</p>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="recoverUserName" name="name" placeholder="My Name (First Last)">
                                                </div>
                                                <div class="sdg_bumper_25"></div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="recoverOffice" name="office" placeholder="My Office">
                                                </div>
                                                <div class="pull-left">
                                                    <button class="btn btn-success">Recover Username</button>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="sdg_bumper_15"></div>

                                    <div class="col-md-10">
                                        <div class="sdg_bumper_25">
                                            <a class="recover-ctrl" data-toggle="collapse" href="#getPassword"
                                               aria-expanded="false" aria-controls="getPassword">I found an issue with the site.</a>
                                        </div>

                                        <div class="collapse recoverPanel" id="getPassword">
                                            <div class="col-md-12 sdg_bottom_15">

                                                <h4>
                                                    Report issues with the site
                                                </h4>
                                                <p>If you have found bug that you would like to report, please fill out the form below.</p>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="recoverUserName" name="name" placeholder="My Lake Doctors ID">
                                                </div>
                                                <div class="sdg_bumper_25"></div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="recoverOffice" name="office" placeholder="My Subject">
                                                </div>
                                                <div class="sdg_bumper_25"></div>
                                                <div class="form-group">
                                                    <textarea  class="form-control sdg-h-150" id="recoverOffice" name="My Message" placeholder="My message"></textarea>
                                                </div>
                                                <div class="pull-left">
                                                    <button class="btn btn-success">Submit Issue</button>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="sdg_bumper_25"></div>
                                    <hr>
                                    <div class="pull-right" style="padding-bottom: 15px;">
                                        <a  href="#login" aria-controls="login" role="tab" data-toggle="tab">Return to login</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@include('breadcrumbs.breadcrumbs')
</div>
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endsection
