@extends('dash.app')

@section('title')
Edit
@endsection

@section('styles')
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="hidden-xs hidden-sm" style="height:200px"></div>
</div>
<div id="flip" class="edit-active"></div>
<aside id="left_side" class="left"></aside>
<div class="container"> 
    <div class="row">
        <div class="col-md-4 col-md-offset-1" style="margin-top:15px">
            <div class="panel panel-default">
                <div class="panel-body" style="min-height:350px">
                    <div class="panel panel-default edit-group {{ $submitted }}">
                        <div class="panel-heading">
                            <h3 class="panel-title">Panel title</h3>
                            <div class="pull-right"><i class="fa fa-edit edit-group-tool" data-group="1"></i></div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-content">
                                <table class="table table-borderless">
                                    <tbody id="job-table-1"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">TBD</div>
                    </div>

                    <div class="panel panel-default edit-group {{ $submitted }}">
                        <div class="panel-heading">
                            <h3 class="panel-title">Panel title</h3>
                            <div class="pull-right"><i class="fa fa-edit edit-group-tool" data-group="2"></i></div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-content">
                                <table class="table table-borderless">
                                    <tbody id="job-table-2">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">TBD</div>
                    </div>

                    <form method="POST">
                        <input type="submit" name="submit-go" id="submit-go" value="Go">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="pop-up" class="edit-pop-shadow poof" data-group-id="2" >
    <div class="edit-pop-body">
        <div id="edit-left-lists">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th style="width:45; text-overflow: ellipsis"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="job-display">
                    
                </tbody>
            </table>
        </div>
        <div id="edit-dropzone">
            <h3>Add Job Posting</h3>
            <div class="career-form">
                <div>
                    <input name="title" type="text" placeholder="Job Title" />
                </div>
                <div class="dropzone-prime dropzone">
                    
                </div>
                
                <div>
                    <input name="save" type="button" value="Save" />
                    <input name="save-plus" type="button" value="Add Anohter" />
                    <input name="cancel" type="button" value="Cancel" />
                </div>
            </div>
        </div>
    </div>
</div>
<pre>
    <?php
    var_dump ( $_POST );
    ?>
</pre>


@endsection

@section('footer')

@endsection

@section('scripts')

    <script src="<?php echo asset ( '/js/app.backend2.js' ); ?>" type="text/javascript"></script>
@endsection