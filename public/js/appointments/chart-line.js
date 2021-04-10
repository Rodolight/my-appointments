Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Citas registradas mensualmente'
    },
    
    xAxis: {
        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
    },
    yAxis: {
        title: {
            text: 'Cantidad de citas'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Citas registradas',
        data: counts
    }, ]
});