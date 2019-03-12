$(function () {
    var sliderArea = $('#range').get(0);
    var selectedPriceMin = $('#selectedPriceMin').get(0);
    var selectedPriceMax = $('#selectedPriceMax').get(0);

    var slider = noUiSlider.create(sliderArea, {
        range: {
            'min': 0,
            'max': 50000
        },
        step: 500,
        start: [0, 50000],
        connect: true,
        tooltips: true,
        format: wNumb({
            suffix: ' 円'
        })
    });

    slider.on('update', function(values, handleKey) {
        // 最小値のハンドラ
        if(handleKey === 0) {
            $(selectedPriceMin).val((values[handleKey]));
        }
        else if(handleKey === 1) {
            $(selectedPriceMax).val((values[handleKey]));
        }
    });

    $(selectedPriceMax).change(function() {
        slider.set()
    });
});