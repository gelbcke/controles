
(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#amb-datatable');

		// initialize
		var datatable = $table.dataTable({
			 dom: 'Blfrtip',
    
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }},             
          	],
			ColumnDefs: [{
				type: 'date-eu', 
			 	targets: [3,4,5],
			}],
			aaSorting: [
				[0, 'desc']
			],

		});		
	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);