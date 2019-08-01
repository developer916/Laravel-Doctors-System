<h4>Material Statistics</h4>
<ul class="btn-list">
    <li><strong>Total Materials: </strong>
        <strong id="mat-pre-total">{{ $materials->total }}</strong>
    </li>
</ul>
<stront>For {{ date('F') }}</stront>
<ul class="btn-list">
    <li><strong>Field Services: </strong>
        <strong id="mat-pre-number">{{ $materials->number }}</strong>
    </li>
    <li><strong>Materials Used: </strong>
        <strong id="mat-pre-units">{{ $materials->units }}</strong>
    </li>
    <li><strong>Total Cost: </strong>
        <strong id="mat-pre-cost">{{ $materials->cost }}</strong>
    </li>
</ul>
