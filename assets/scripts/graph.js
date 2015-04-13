var randomScalingFactor = function () { return Math.round(Math.random() * 100)};

var barChartData = {
    labels:   ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль'],
    datasets: [
        {
            fillColor:       'rgba(220,220,220,0.5)',
            strokeColor:     'rgba(220,220,220,0.8)',
            highlightFill:   'rgba(220,220,220,0.75)',
            highlightStroke: 'rgba(220,220,220,1)',
            data:            [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        },
        {
            fillColor:       'rgba(151,187,205,0.5)',
            strokeColor:     'rgba(151,187,205,0.8)',
            highlightFill:   'rgba(151,187,205,0.75)',
            highlightStroke: 'rgba(151,187,205,1)',
            data:            [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }
    ]
};

$(document).ready(function () {
    var clientsCtx = $('#canvas-clients').get(0).getContext('2d'),
        transactionsCtx = $('#canvas-transactions').get(0).getContext('2d'),
        goodsCtx = $('#canvas-goods').get(0).getContext('2d'),
        usersCtx = $('#canvas-users').get(0).getContext('2d');

    window.myBar = new Chart(clientsCtx).Bar(barChartData, {
        responsive: true
    });

    window.myBar = new Chart(transactionsCtx).Bar(barChartData, {
        responsive: true
    });

    window.myBar = new Chart(goodsCtx).Bar(barChartData, {
        responsive: true
    });

    window.myBar = new Chart(usersCtx).Bar(barChartData, {
        responsive: true
    });
});