
(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#rev-datatable');

		// initialize
		var datatable = $table.dataTable({
			 dom: 'Blfrtip',
    
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }},             
          ],
			aoColumnDefs: [{
				type: 'date-eu', 
			 	targets: 0,
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