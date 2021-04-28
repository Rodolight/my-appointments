
$( function (){

    var $chart = $('#chart-bars');

	// Init chart
	function initChart($chart) {

		// Create chart
		var ordersChart = new Chart($chart, {
			type: 'bar',
			data: {
				labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
				datasets: [{
					label: 'Citas médicas',
					data: appointmentByDay
				}]
			}
		});

		// Save to jQuery object
		$chart.data('chart', ordersChart);
	}


	// Init chart
	if ($chart.length) {
		initChart($chart);
	}

})
