$(function() {
	Highcharts.chart('highcharts_month', {
		chart: {
			type: '',
		},
		title: {
			text: 'Doanh Thu Hàng Ngày',
		},
		subtitle: {
			text: 'Source:  Cloudteam.com',
		},
		xAxis: {
			categories: ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
			crosshair: true,
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Số tiền (VNĐ)',
			},
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f} VNĐ</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true,
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0,
			},
		},
		series: [
			{
				name: 'VNMB 10',
				data: [29.4, 68.2, 76.5, 120.7, 54.6, 67.5, 76.4],
			},
			{
				name: 'VNMB 20',
				data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0],
			},
			{
				name: 'VNMB 50',
				data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6],
			},
			{
				name: 'VNMB 100',
				data: [63.6, 58.8, 90.6, 33.4, 16.0, 44.5, 95.0],
			},
			{
				name: 'VNMB 200',
				data: [54.6, 23.8, 18.5, 43.4, 77.0, 56.5, 49.0],
			},
			{
				name: 'VNMB 500',
				data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0],
			},
		],
	})

	Highcharts.chart('highcharts_year', {
		chart: {
			type: 'column',
		},
		title: {
			text: 'Doanh Số Trung Bình Năm: 2018',
		},
		xAxis: {
			categories: [
				'Jan',
				'Feb',
				'Mar',
				'Apr',
				'May',
				'Jun',
				'Jul',
				// 'Aug',
				// 'Sep',
				// 'Oct',
				// 'Nov',
				// 'Dec'
			],
			crosshair: true,
		},
		yAxis: [
			{
				min: 0,
				title: {
					text: 'Số lượng',
				},
			}, {
				title: {
					text: 'Doanh Thu (triệu)',
				},
				opposite: true,
			}],
		legend: {
			shadow: false,
		},
		tooltip: {
			shared: true,
		},
		plotOptions: {
			column: {
				grouping: true,
				shadow: false,
				borderWidth: 0,
			},
		},
		series: [
			{
				name: 'Số Lượng Sản Phẩm',
				color: 'rgba(150,0,0,.9)',
				data: [141, 370, 426, 593, 498, 345/*, 540, 631, 473, 493, 374*/, 80],
				tooltip: {
					valuePrefix: ' ',
				},
				pointPadding: 0.1,
				pointPlacement: 0.0,
			}, {
				name: 'Doanh Thu Sản Phẩm',
				color: 'rgba(0,0,150,.9)',
				data: [32.6, 81.8, 187.5, 198.8, 158.5, 128.3/*, 208.5, 198.8, 211.5, 198.8, 78.5*/, 44.5],
				tooltip: {
					valueSuffix: ' VNĐ',
				},
				pointPadding: 0.1,
				pointPlacement: 0.0,
				yAxis: 1,
			}],
	})

})