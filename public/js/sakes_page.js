$(function () {
    var dataContext = JSON.parse($('body').attr('data-context'));
    var sliderArea = $('#range').get(0);
    var suffix = ' 円';

    var slider = noUiSlider.create(sliderArea, {
        range: {
            'min': 0,
            'max': dataContext.priceMax
        },
        step: 500,
        start: [
            dataContext.selectedPriceMin != null ? dataContext.selectedPriceMin : dataContext.priceMin,
            dataContext.selectedPriceMax != null ? dataContext.selectedPriceMax : dataContext.priceMax,
        ],
        connect: true,
        tooltips: true,
        format: wNumb({
            decimals: 0,
            suffix: suffix
        })
    });

    slider.on('update', function(values, handleKey) {
        var value = values[handleKey].toString().replace(suffix, '');

        // 最小値のハンドラ
        if(handleKey === 0) {
            $(selectedPriceMin).val(value);
        }
        else if(handleKey === 1) {
            $(selectedPriceMax).val(value);
        }
    });
});