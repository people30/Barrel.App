$(function () {
    $("#SliderSingle").slider({
        from: 5,
        to: 50,
        step: 2.5,
        round: 1,
        format: {
            format: '##.0',
            locale: 'de'
        },
        dimension: ' €',
        skin: "round"
    });
});