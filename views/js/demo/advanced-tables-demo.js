//DataTables Initialization
$(document).ready(function () {

	var dataTable;

    var table = $('#example').DataTable({

    	lengthChange: false,
        buttons: [	
        	{
        		extend: 'pdfHtml5',
                download: 'open'
            },

        	'copy', 'excel', 'colvis',
        	{
                text: 'Mi boton',
                action: function () {                	
                    
                                window.location.assign("index.php?action=alta-clientes");
                }
            }


        ],

        "language": {
            "decimal": "",
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Show _MENU_ entries",
            "loadingRecords": "Loading...",
            "processing": "Processing...",
            "search": "Search: ",
            "zeroRecords": "No matching records found",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    	
    });

    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );


    $('#example tbody').on('click', 'tr', function () {

    	dataTable = table.row(this).data();
        //console.log('Clicked en = ' + data[2]);

        if ($(this).hasClass('success')) {

            $(this).removeClass('success');            

        } else {

            table.$('tr.success').removeClass('success');
            $(this).addClass('success');
			
        }        

    });

});