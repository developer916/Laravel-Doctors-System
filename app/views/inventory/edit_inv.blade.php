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
                        <div class="col-md-12 sdg_stretch sdg_btm_bump _flex_order_2">
                            <div class="_flex _flex_stretch">
                                <div class="col-md-12 sdg_no_l_bump">
                                    <h2>Edit Inventory for {{ $office->officeName }}, {{ str_replace('-', '/', $inv_date) }}</h2>
                                </div>
                            </div>
                            <form action="{{ route('update_inv') }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                    @foreach($inventories as $inv)
                                        <tr>
                                            <td class="field-data field-code">
                                                {{ $inv->invMaterial->code }}
                                            </td>
                                            <td class="field-data field-material">
                                                <input class="form-control inventory-material" type="text" value="{{ $inv->invMaterial->name  }}" placeholder="Material Name">
                                                <input class="material-id" type="hidden" name="materials[{{ $inv->id }}]" value="{{ $inv->invMaterial->id }}">
                                            </td>
                                            <td class="field-data field-units">
                                                {{ $inv->invMaterial->units }}
                                            </td>
                                            <td class="field-data field-cost">
                                                <input class="form-control" value="{{ $inv->cost }}" data-mat="{{  $inv->invMaterial->material_id  }}" name="cost[{{  $inv->id }}]" />
                                            </td>
                                            <td class="field-data field-beginning">
                                                <input class="form-control" value="{{ $inv->begin_amount }}" placeholder="Beginning Inven" data-inv-id="{{  $inv->invMaterial->id }}" name="begin_amount[{{  $inv->id }}]" />
                                            </td>
                                            <td class="field-data field-purchased">
                                                <input class="form-control" value="{{ $inv->purchased_amount }}" placeholder="Purchased Amount" data-mat="{{  $inv->invMaterial->id }}" name="purchased_amount[{{  $inv->id }}]" />
                                            </td>
                                            <td class="field-data field-avail">
                                                {{ $inv->begin_amount + $inv->purchased_amount }}
                                            </td>
                                            <td class="field-data field-end">
                                                <input class="form-control" value="{{ $inv->end_amount }}" placeholder="End Inven" data-mat="{{ $inv->invMaterial->id }}" name="end_amount[{{$inv->id}}]" />
                                            </td>
                                            <td class="field-data field-used">
                                                {{ $inv->begin_amount * $inv->cost + $inv->purchased_amount * $inv->cost }}
                                            </td>
                                            <td class="field-data field-end-cost">
                                                {{ $inv->end_amount * $inv->cost }}
                                            </td>
                                            <td class="field-data field-purchased-cost">
                                                {{ $inv->purchased_amount * $inv->cost }}
                                            </td>
                                            <td class="field-data field-start-cost">
                                                {{ $inv->begin_amount * $inv->cost }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary">Update Inventory</button>
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
