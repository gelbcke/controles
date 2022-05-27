
(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#datatable-users');

		// initialize
		var datatable = $table.dataTable({
			 dom: 'Blfrtip',
    
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                }},             
          ],
			aoColumnDefs: [{
				type: 'date-eu', 
			 	targets: 3,
			},
			{
				bSortable: false,
				aTargets: 6,
			}],
			aaSorting: [
				[0, 'asc']
			],
		});		
	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);