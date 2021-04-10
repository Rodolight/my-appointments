const barChart = Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Médicos más activos'
    },
    xAxis: {
        categories: [
            'Medico 1',
            'Medico 2',
            'Medico 3',
                   ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Citas atendidas'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: []
});

let $start, $end;

function fetchData(){
  const startDate = $start.val();
  const endDate = $end.val();

  const url = `/charts/doctors/bar/data?start=${startDate}&end=${endDate}`; 
  fetch(url)
  .then(response => response.json())
  .then(data => {
       barChart.xAxis[0].setCategories(data.categories);
       if(barChart.series.length > 0){
           barChart.series[1].remove();
           barChart.series[0].remove();
       }
       barChart.addSeries(data.series[0]);
       barChart.addSeries(data.series[1]);
  });

}

$(() => {
    $start = $('#startDate');
    $end = $('#endDate');

    fetchData();
    $start.change(fetchData);
    $end.change(fetchData);
 })