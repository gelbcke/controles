
(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#print-details');

		// format function for row details
		var fnFormatDetails = function( datatable, tr ) {
			var data = datatable.fnGetData( tr );

			return [
				'<table class="table mb-none">',
					'<tr>',
						'<td><label class="mb-none">Fila de Impressão:</label></td>',
						'<td>' + data[7] + '</td>',
					'</tr>',
					'<tr>',
						'<td><label class="mb-none">Contrato:</label></td>',
						'<td>' + data[8] + '</td>',
					'</tr>',
					'<tr>',
						'<td><label class="mb-none">Valor da Locação:</label></td>',
						'<td>R$ ' + data[9] + '</td>',
					'</tr>',
					'<tr>',
						'<td><label class="mb-none">Acessar Console:</label></td>',
						'<td><a href="http://' + data[5] +'/" target="_blank"><i class="fas fa-external-link-alt"></i></a></td>',
					'</tr>',
				'</div>'
			].join('');
		};

		// insert the expand/collapse column
		var th = document.createElement( 'th' );
		var td = document.createElement( 'td' );
		td.innerHTML = '<i data-toggle class="far fa-plus-square text-primary h5 m-none" style="cursor: pointer;"></i>';
		td.className = "text-center";

		$table
			.find( 'thead tr' ).each(function() {
				this.insertBefore( th, this.childNodes[0] );
			});

		$table
			.find( 'tbody tr' ).each(function() {
				this.insertBefore(  td.cloneNode( true ), this.childNodes[0] );
			});

		// initialize
		var datatable = $table.dataTable({
			 dom: 'Blfrtip',
	        	buttons: [
	            { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8]
                }},
	            { extend: 'excel', text: 'Excel'},
	            { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8]
                }},
	            { extend: 'print', text: 'Imprimir', orientation: 'landscape', exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8]
                }}
	        ],

			aoColumnDefs: [{
				bSortable: false,
				aTargets: [ 0 ],
			}],
			aaSorting: [
				[1, 'asc']
			],

		});

		// add a listener
		
		$table.on('click', 'i[data-toggle]', function() {
			var $this = $(this),
				tr = $(this).closest( 'tr' ).get(0);

			if ( datatable.fnIsOpen(tr) ) {
				$this.removeClass( 'far fa-minus-square' ).addClass( 'far fa-plus-square' );
				datatable.fnClose( tr );
			} else {
				$this.removeClass( 'far fa-plus-square' ).addClass( 'far fa-minus-square' );
				datatable.fnOpen( tr, fnFormatDetails( datatable, tr), 'details' );
			}
		});
	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);