(function() {

	/*
	Modal with CSS animation
	*/
	$('.modal-with-zoom-anim').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in',
		modal: true
	});

	/*
	Modal Dismiss
	*/
	$(document).on('click', '.modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	/*
	Modal Confirm
	*/
	$(document).on('click', '.modal-confirm', function (e) {
		e.preventDefault();
		$.magnificPopup.close();

		new PNotify({
			title: 'Success!',
			text: 'Modal Confirm Message.',
			type: 'success'
		});
	});

		/*
		Vencimentos por Bloco Mês Atual
		*/	
		Morris.Bar({
			resize: true,
			element: 'VencidosPorBlocoBar',
			data: VencidosPorBlocoBarData,
			xkey: 'blocos_count',
			ykeys: ['rev_bloco_v'],
			labels: ['Vencidos'],
			hideHover: 'auto',
			barColors: ['#bf1313'],
			xLabelAngle: 50,
			fillOpacity: 0.7,
			smooth: false,
			stacked: true,
			hideHover: true,
			padding: 60,
		});

		/*
		Blocos com maior indice de vencidos
		*/	
		Morris.Bar({
			resize: true,
			element: 'BlocosMaisVencidos',
			data: BlocosMaisVencidosData,
			xkey: 'total_blocos_count',
			ykeys: ['percent_rev_bloco'],
			labels: ['%'],
			hideHover: 'auto',
			barColors: ['#bf1313'],
			xLabelAngle: 45,
			fillOpacity: 0.7,
			hAxis: {format: '0'},
			smooth: false,
			stacked: true,
			hideHover: true,
			padding: 60,
		});

		// SLA DO MÊS ATUAL
		var c= gaugeAlternative.getContext("2d");
		var target = $('#gaugeAlternative'),
			opts = $.extend(true, {}, {
				lines: 12, // The number of lines to draw
				angle: 0.12, // The length of each line
				lineWidth: 0.5, // The line thickness
				pointer: {
					length: 0.7, // The radius of the inner circle
					strokeWidth: 0.05, // The rotation offset
					color: '#444' // Fill color
				},
				limitMax: 'true', // If true, the pointer will not go past the end of the gauge
				colorStart: '#1960af', // Colors
				colorStop: '#173eb1', // just experiment with them
				strokeColor: '#F1F1F1', // to see which ones work best for you
				generateGradient: true
			
			}, target.data('plugin-options'));

			var gauge = new Gauge(target.get(0)).setOptions(opts);

		gauge.maxValue = opts.maxValue; // set max gauge value
		gauge.animationSpeed = 32; // set animation speed (32 is default value)
		gauge.set(opts.value); // set actual value
		gauge.setTextField(document.getElementById("gaugeAlternativeTextfield"));
	})();

