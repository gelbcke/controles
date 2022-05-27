
(function( $ ) {

	'use strict';

	/*
	Estatíticas dos Projetores por Modelo
	*/	
	Morris.Bar({
		resize: false,
		element: 'TotalProjetoresModelo',
		data: TotalProjetoresModeloBarData,
		xkey: 'projetor_count',
		ykeys: ['projetor_total'],
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
	Estatíticas dos Projetores por Unidade
	*/	
	Morris.Bar({
		resize: false,
		element: 'TotalProjetoresUnidades',
		data: TotalProjetoresUnidadesBarData,
		xkey: 'unidade_count',
		ykeys: ['projetor_total'],
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


$('svg').height(700);
}).apply( this, [ jQuery ]);


	