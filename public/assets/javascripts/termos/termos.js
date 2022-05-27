
(function( $ ) {

	'use strict';

	/*
	Estatíticas dos Termos por Ano
	*/	
Morris.Bar({
		resize: false,
		element: 'TotalTermosAnual',
		data: TotalTermosAnualBarData,
		xkey: 'year',
		ykeys: ['term_hist'],
		labels: ['Quantidade'],
		hideHover: 'auto',
		barColors: ['#0088cc'],
		xLabelAngle: 60,
		/*
		xLabelAngle: 90,
		stacked: true,
		hideHover: true,
		padding: 60,
		*/
		fillOpacity: 0.7,
		smooth: false,

	});

	/*
	Estatíticas dos Termos por Unidade
	*/	
	Morris.Bar({
		resize: false,
		element: 'TotalTermosUnidades',
		data: TotalTermosUnidadesBarData,
		xkey: 'unidade_count',
		ykeys: ['termos_total'],
		labels: ['Quantidade'],
		hideHover: 'auto',
		barColors: ['#0088cc'],
		xLabelAngle: 60,
		/*
		xLabelAngle: 90,
		stacked: true,
		hideHover: true,
		padding: 60,
		*/
		fillOpacity: 0.7,
		smooth: false,

	});


		/*
	Estatíticas dos Termos vencidos por colaborador
	*/	
	Morris.Bar({
		resize: false,
		element: 'TotalTermosVencidos',
		data: TotalTermosVencidosBarData,
		xkey: 'colaborador',
		ykeys: ['vencidos_count'],
		labels: ['Quantidade'],
		hideHover: 'auto',
		barColors: ['#bf1313'],
		xLabelAngle: 0,
		/*
		xLabelAngle: 90,
		stacked: true,
		hideHover: true,
		padding: 60,
		*/
		fillOpacity: 0.7,
		smooth: false,

	});







$('svg').height(700);
}).apply( this, [ jQuery ]);


