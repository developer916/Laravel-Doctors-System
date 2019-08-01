@extends('reports.report-act-app')

@section('title')
Lake Doctors Material Cost
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body sdg_zero_bounce sdg_flex" style="min-height: 500px;">
                    <div class="col-md-4 sdg_tool_panel sdg_stretch _flex_order_2 sdg_no_bmp">
                        <div class="act_head">
                            <h2>Material Cost</h2>
                            <p>
                            </p>
                        </div>

                        <div class="col-xs-12 col-sm-12 sdg_no_bmp" id="sidebar-left">


                        </div>
                    </div>


                    <div class="col-md-7 col-md-offset-1 sdg_stretch sdg_btm_bump _flex_order_2">
                        <div class="_flex _flex_stretch">
                            <div class="col-md-8 sdg_no_l_bump">
                                <h2>Material Costs</h2>
                            </div>


                        </div>
                        <p>Below is a quick breakdown of material costs over time..</p>
                        <div class="col-md-10">
                            <div id="graph"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @include('breadcrumbs.breadcrumbs')

    </div>
@endsection

@section('scripts')
<script src="<?php echo asset( '/js/app.backend.js' ); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        var chart = c3.generate({
            bindto: '#graph',
            data: {
                x: 'x',
//        xFormat: '%Y%m%d', // 'xFormat' can be used as custom format of 'x'
                columns: [
                    ['x', '2013-01-01', '2013-01-02', '2013-01-03', '2013-01-04', '2013-01-05', '2013-01-06'],
//            ['x', '20130101', '20130102', '20130103', '20130104', '20130105', '20130106'],
                    ['AGDX', 12.10, 11.120, 13.10, 14.10, 11.150, 10.10],
                    ['AMID', 8.40, 4.40, 5.40, 2.40, 3.40, 4.40],
                    ['C24D', 17.66, 17.76, 16.96, 16.66, 17.00, 17.66],
                    ['CLAC', 13.38, 14.38, 15.38, 14.08, 13.38, 9.38]
                ]
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: '%Y-%m-%d'
                    }
                }
            }
        });

    </script>
@endsection