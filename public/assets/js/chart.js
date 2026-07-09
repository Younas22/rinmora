$(document).ready(function() {

	// Bar Chart
	if($('#monthly-charts').length > 0) {
		var options = {
			series: [{
				name: 'Project In',
				data: [10000, 9000, 8000, 7000, 6000, 10000, 9000, 8000, 7000, 6000, 10000, 9000, 8000, 7000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
			}, 

			// {
			// 	name: ' Project Taken',
			// 	data: [35, 41, 36, 26, 45]
			// }

			],
				chart: {
				type: 'bar',
				height: 300,
				toolbar: false
			},
			colors: ['#E24F55', '#5F3B7E'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '55%',
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 3,
				colors: ['transparent']
			},
			xaxis: {
				categories: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
			},
			fill: {
				opacity: 1,
			},
			grid: {
				yaxis: {
					lines: {
					  show: false
					}
				  }
			},
			tooltip: {
				y: {
				formatter: function (val) {
					return "$ " + val + " thousands"
				}
				}
			}
		};
	
		var chart = new ApexCharts(document.querySelector("#monthly-charts"), options);
		chart.render();
	}
	
	
	// Bar Chart
	if($('#bar-charts').length > 0) {
		var options = {
			series: [{
				name: 'Project In',
				data: [0, 5000, 4000, 8000, 2000,9000,10000]
			}, 

			// {
			// 	name: ' Project Taken',
			// 	data: [35, 41, 36, 26, 45]
			// }

			],
				chart: {
				type: 'bar',
				height: 300,
				toolbar: false
			},
			colors: ['#E24F55', '#5F3B7E'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '55%',
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 3,
				colors: ['transparent']
			},
			xaxis: {
				categories: ['Sat','Sun', 'Mon', 'Tue', 'Wed', 'Thu','Fri'],
			},
			fill: {
				opacity: 1,
			},
			grid: {
				yaxis: {
					lines: {
					  show: false
					}
				  }
			},
			tooltip: {
				y: {
				formatter: function (val) {
					return "$ " + val + " thousands"
				}
				}
			}
		};
	
		var chart = new ApexCharts(document.querySelector("#bar-charts"), options);
		chart.render();
	}

	// Evaluation Chart
	
	if($('#evaluation-charts').length > 0) {
		var options = {
			series: [42, 47, 85, 35],
			chart: {
				height: 340,
				type: 'polarArea',				
			},
			labels: ['Design', 'iOS', 'HR', 'DevOps'],
			colors: ['#AA60BB', '#E64B51', '#6B468C', '#734FFE'],
			fill: {
				type: 'normal',
				opacity: 1,
				colors: ['#AA60BB', '#E64B51', '#6B468C', '#734FFE']	
			},
			stroke: {
				width: 0,
				colors: undefined
			},
			yaxis: {
				show: false
			},
			legend: {
				position: 'bottom'
			},
			plotOptions: {
				polarArea: {
				rings: {
					strokeWidth: 0
				},
				spokes: {
					strokeWidth: 0,
				},
				}
			}
		};
	
		var chart = new ApexCharts(document.querySelector("#evaluation-charts"), options);
		chart.render();
	}
	

	// Employee Chart

	if($('#employee-chart').length > 0) {
		var options = {
			series: [20, 20, 20, 20, 20],
			colors : ['#BA4A00', '#D68910', '#2ECC71','#1ABC9C','#2980B9'],
			chart: {
				type: 'donut',
			},
			fill: {
				type: 'normal'
			},
			legend: {
				formatter: function(val, opts) {
					return val + " - " + opts.w.globals.series[opts.seriesIndex]
				},
				position: 'bottom'
			},
			plotOptions: {
				labels: {
					show: false
				}
			},
			dataLabels: {
				enabled: false
			},
			title: {
				show: true,
			},
			donut: {
				labels: {
					show: false,
					name: {
						show: true,
					}
				}
			},
			
		};

		var chart = new ApexCharts(document.querySelector("#employee-chart"), options);
		chart.render();
	}


	// Employee Chart

	if($('#employee-chart_').length > 0) {
		var options = {
			series: [20, 20, 20, 20, 20],
			colors : ['#BA4A00', '#D68910', '#2ECC71','#1ABC9C','#2980B9'],
			chart: {
				type: 'donut',
			},
			fill: {
				type: 'normal'
			},
			legend: {
				formatter: function(val, opts) {
					return val + " - " + opts.w.globals.series[opts.seriesIndex]
				},
				position: 'bottom'
			},
			plotOptions: {
				labels: {
					show: false
				}
			},
			dataLabels: {
				enabled: false
			},
			title: {
				show: true,
			},
			donut: {
				labels: {
					show: false,
					name: {
						show: true,
					}
				}
			},
			
		};

		var chart = new ApexCharts(document.querySelector("#employee-chart_"), options);
		chart.render();
	}
		
});