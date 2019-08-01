<option value="default">Please Choose a State...</option>
@foreach($taxDist as $tD)
    <option value="{{ $tD['id_code'] }}">{{ (intval($tD['id_code']) < 10? '0'. $tD['id_code']:$tD['id_code'])  }} &mdash; {{ $tD['name'] }}</option>
@endforeach