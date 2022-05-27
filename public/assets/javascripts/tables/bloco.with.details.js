
(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#bloco-table');

		// initialize
		var datatable = $table.dataTable({
			 dom: 'Blfrtip',
	        	buttons: [
	            { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 1, 2, 3, 4, 5]
                }},
	            { extend: 'excel', text: 'Excel'},
	            { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 1, 2, 3, 4, 5]
                }},
	            { extend: 'print', text: 'Imprimir', orientation: 'landscape', exportOptions: {
                    columns: [ 1, 2, 3, 4, 5]
                }}
	        ],

			aoColumnDefs: [{
				bSortable: false,
				aTargets: [ 0 ],
			}],
			aaSorting: [
				[0, 'asc']
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