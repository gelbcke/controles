
(function( $ ) {

	'use strict';

	/*
	Estatíticas dos Projetores por Unidade
	*/	
	Morris.Bar({
		resize: false,
		element: 'TotalImpressorasUnidades',
		data: TotalImpressorasUnidadesBarData,
		xkey: 'unidade_count',
		ykeys: ['impressoras_total'],
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


	