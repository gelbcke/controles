
(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#img-datatable');

		// initialize
		var datatable = $table.dataTable({
			 dom: 'Blfrtip',
    
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2 ]
                }},             
          ],
			aoColumnDefs: [{
				type: 'date-eu', 
			 	targets: [0],
			}],
			aaSorting: [
				 [0,'asc']
			],

		});		
	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);