$(document).ready(function () {
    $( ".inventory-material" ).on( 'keyup', function() {
        var keyword  = $(this).val(),
            selector = $(this);

        if (keyword)
        {
            $.ajax({
                url: '/material/autocomplete-report',
                method: 'get',
                data: {'keyword' : keyword, '_token' : $( "input[name=_token]" ).val()}
            })
                .done(function(data) {

                    var availableTags = [];

                    if (data.length > 0)
                    {
                        $.each(data, function (index, value) {
                            availableTags.push({
                                "label" : value.name,
                                "value" : value.name,
                                'id' : value.id,
                                'code' : value.code,
                                'units' : value.units
                            })
                        });
                    }

                    selector.autocomplete({
                        source: availableTags,
                        select: function (event, ui) {
                            var code  = ui.item.code,
                                id    = ui.item.id,
                                units = ui.item.units;

                            selector.parent().parent().find( ".field-code" ).text( code );
                            selector.parent().parent().find( ".field-units" ).text( units );
                            selector.parent().parent().find( ".field-material input.material-id" ).val( id );
                        }
                    })

                });
        }
    });

    $( ".field-cost input" ).on('keyup', function () {
        var parent            = $(this).parent().parent(),
            startCostElem     = parent.find( ".field-start-cost" ),
            purchasedCostElem = parent.find( ".field-purchased-cost" ),
            endCostElem       = parent.find( ".field-end-cost" ),
            usedElem          = parent.find( ".field-used" );

        var cost      = parseFloat( $(this).val() ),
            beginning = parent.find( ".field-beginning input" ).val(),
            purchased = parent.find( ".field-purchased input" ).val(),
            end       = parent.find( ".field-end input" ).val();

        updateStartCost( beginning, cost, startCostElem );
        updateEndCost( end, cost, endCostElem );
        updatePurchaseCost( purchased, cost, purchasedCostElem );
        updateUsed( beginning, purchased, cost, usedElem );
    });

    $( ".field-beginning input" ).on('keyup', function () {
        var parent         = $(this).parent().parent(),
            startCostElem  = parent.find( ".field-start-cost" ),
            usedElem       = parent.find( ".field-used" ),
            availElem      = parent.find( ".field-avail" );

        var cost      = parent.find( ".field-cost input" ).val(),
            beginning = parseFloat( $(this).val() ),
            purchased = parent.find( ".field-purchased input" ).val();

        updateStartCost( beginning, cost, startCostElem );
        updateUsed( beginning, purchased, cost, usedElem );
        updateAvail( beginning, purchased, availElem );
    });

    $( ".field-purchased input" ).on('keyup', function () {
        var parent            = $(this).parent().parent(),
            purchasedCostElem = parent.find( ".field-purchased-cost" ),
            usedElem          = parent.find( ".field-used" ),
            availElem         = parent.find( ".field-avail" );

        var cost      = parent.find( ".field-cost input" ).val(),
            beginning = parent.find( ".field-beginning input" ).val(),
            purchased = parseFloat( $(this).val() );

        updatePurchaseCost( purchased, cost, purchasedCostElem );
        updateUsed( beginning, purchased, cost, usedElem );
        updateAvail( beginning, purchased, availElem );
    });

    $( ".field-end input" ).on('keyup', function () {
        var parent      = $(this).parent().parent(),
            endCostElem = parent.find( ".field-end-cost" );

        var cost = parent.find( ".field-cost input" ).val(),
            end  = parseFloat( $(this).val() );

        updateEndCost( end, cost, endCostElem );
    });

    function updateStartCost( beginning, cost, elem )
    {
        var result = parseInt(beginning * cost);

        if (result)
        {
            result = parseFloat( result ).toFixed(2);
        }
        else
        {
            result = 0;
        }

        $(elem).html( result );
    }

    function updatePurchaseCost( purchased, cost, elem )
    {
        var result = parseInt(purchased * cost);

        if (result)
        {
            result = parseFloat( result ).toFixed(2);
        }
        else
        {
            result = 0;
        }

        $(elem).html( result );
    }

    function updateEndCost( end, cost, elem )
    {
        var result = parseInt(end * cost);

        if (result)
        {
            result = parseFloat( result ).toFixed(2);
        }
        else
        {
            result = 0;
        }

        $(elem).html( result );
    }

    function updateUsed( beginning, purchased, cost, elem )
    {
        var result = parseInt(beginning * cost) + parseInt(purchased * cost);

        if ( result )
        {
            result = parseFloat( result ).toFixed(2);
        }
        else
        {
            result = 0;
        }

        $(elem).html( result );
    }

    function updateAvail( beginning, purchased, elem )
    {
        var result = parseInt(beginning) + parseInt(purchased);

        if (result)
        {
            result = parseFloat( result ).toFixed(2);
        }
        else
        {
            result = 0;
        }

        $(elem).html( result );
    }
});