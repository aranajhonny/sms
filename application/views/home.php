        <!-- Jumbotron -->
        <div class="jumbotron">
          <h1>SMS enviados</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <table id="table" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Texto</th>
                    <!-- <th>Token</th> -->
                    <th>Recibido</th>
                    <th>Fecha y Hora envio</th>
                    <th>Fecha y Hora enviado</th>
                    <th>status</th>
                    <th>Destinatario</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <th>Item</th>
                    <th>Texto</th>
                    <!-- <th>Token</th> -->
                    <th>Recibido</th>
                    <th>Fecha y Hora envio</th>
                    <th>Fecha y Hora enviado</th>
                    <th>status</th>
                    <th>Destinatario</th>
                </tr>
            </tfoot>
        </table>
          </div>
        </div>


<script type="text/javascript">

var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({
    	"language": {
    		"url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    	},

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('ajax/enviados') ?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],

    });

});
</script>