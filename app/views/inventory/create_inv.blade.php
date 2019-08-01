@extends('masters.inventory')
@section('title')
Lake Doctors - Create New Inventory
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body sdg_zero_bounce sdg_flex">
                        {{--<div class="col-md-4 sdg_tool_panel sdg_stretch _flex_order_2 sdg_no_bmp">--}}
                            {{--<div class="act_head">--}}
                                {{--<h2>New Inventory</h2>--}}

                                {{--<p>--}}
                                    {{--Here you create a new Inventory.--}}
                                {{--</p>--}}
                            {{--</div>--}}

                            {{--<div class="col-xs-12 col-sm-12 sdg_no_bmp" id="sidebar-left">--}}



                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="col-md-12 sdg_stretch sdg_btm_bump _flex_order_2">
                            <div class="_flex _flex_stretch">
                                <div class="col-md-12 sdg_no_l_bump">
                                    <h2>New Inventory for {{ $office }}, {{ $inv_date  }}</h2>
                                </div>
                            </div>
                            <form action="{{ route('create_inv_save') }}" method="post">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="office_id" value="{{ $office_id }}">
                                <input type="hidden" name="month" value="{{ str_replace('/', '-', "$year/$month/$month") }}" >

                                <table class="table table-striped field-data">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Units</th>
                                            <th>Cost</th>
                                            <th>Beginning</th>
                                            <th>Purchased</th>
                                            <th>Avail</th>
                                            <th>End</th>
                                            <th>Used</th>
                                            <th>End Cost</th>
                                            <th>Purch. Cost</th>
                                            <th>Start Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $order = 0 @endphp
                                    @foreach($mat as $m)
                                        <tr>
                                            <td class="field-data field-code">{{ $m->code  }}</td>
                                            <td class="field-data field-material">
                                                <input class="form-control inventory-material" type="text" value="{{ $m->name }}" placeholder="Material Name">
                                                <input class="material-id" type="hidden" name="data[{{ $order }}][mat_id]" value="{{ $m->id }}">
                                            </td>
                                            <td class="field-data field-units">{{ $m->units  }}</td>
                                            <td class="field-data field-cost">
                                                <input class="form-control" value="{{ $m->cost}}" data-mat="{{ $m->material_id  }}" name="data[{{ $order }}][cost]" />
                                            </td>
                                            <td class="field-data field-beginning">
                                                <input class="form-control" value="" placeholder="Beginning Inven" data-mat="{{ $m->id }}" name="data[{{ $order }}][begin_amount]" />
                                            </td>
                                            <td class="field-data field-purchased"><input class="form-control" value="" placeholder="Purchased Amount" data-mat="{{ $m->id }}" name="data[{{ $order }}][purchased_amount]" /></td>
                                            <td class="field-data field-avail">0.00</td>
                                            <td class="field-data field-end">
                                                <input class="form-control" value="" placeholder="End Inven" data-mat="{{ $m->id }}" name="data[{{ $order }}][end_amount]" />
                                            </td>
                                            <td class="field-data field-used">0.00</td>
                                            <td class="field-data field-end-cost">0.00</td>
                                            <td class="field-data field-purchased-cost">0.00</td>
                                            <td class="field-data field-start-cost">0.00</td>

                                            <input type="hidden" value="{{ $office_id }}" name="data[{{ $order }}][office_id]">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="data[{{$order}}][month]">
                                        </tr>
                                        @php $order++ @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary">Save Inventory</button>
                            </form>
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

@section('footer')

@endsection

@section('scripts')
    <script src="{{ asset('js/inventory_report.js') }}"></script>
@endsection