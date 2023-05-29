<script type="text/javascript" src="{{asset('packages/datatables/datatables.min.js')}}"></script>
<script>

    /**
     * Bloque funcional para gestionar noticias.
     */
    let script_noticias = function() {
        let datatable_noticias;

        /**
         * Cargar datatable con todas las subsecciones existentes.
         */
        let cargar_datatable = function() {
            datatable_noticias = jQuery('#tabla').DataTable({
                ordering: false,
                fixedColumns: false,
                info: true,
                autoWidth: false,
                stateSave: false,
                lengthChange: false,
                searching: false,
                processing: true,
                serverSide: true,
                language: {
                    "info": "Mostrando de _START_ a _END_ en un total de _TOTAL_ noticias",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing":   "<span style='color:#1b330c' class='fa-stack fa-lg'>\n\
                                        <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                                    </span>&emsp;Cargando...",
                    "zeroRecords": "Sin resultados",
                    "infoEmpty": "Mostrando 0 noticias",
                },
                order: [[0, 'asc']],
                ajax: {
                    url: '{{ URL::current() }}',
                    data: function (d) {
                        d.titulo = $('input[name=titulo]').val();
                        d.fuente_id = $('select[name=fuente_id]').val();
                        d.bien_cultural_id = $('select[name=bien_cultural_id]').val();
                        d.municipio_id = $('select[name=municipio_id]').val();
                        d.provincia_id = $('select[name=provincia_id]').val();
                        d.estado_id = $('select[name=estado_id]').val();
                    }
                },
                columns: [
                    {data: "titulo", name: "titulo", className: ""},
                    {data: "fuente", name: "fuente", className: ""},
                    {data: "bien_cultural", name: "bien_cultural", className: ""},
                    {data: "municipio", name: "municipio", className: ""},
                    {data: "provincia", name: "provincia", className: ""},
                    {data: "estado", name: "estado", className: ""},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: "ta-center"}
                ]
            });
        };

        /*jQuery(document).ready(function () {
            jQuery('#fuente_id').select2(
            );
        });*/

        return {
            init: function() {

                $(document).on('click', '.paginate_button', function () {
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                });

                //Buscador
                jQuery('#buscar').click(function() {
                    datatable_noticias.ajax.reload();
                });
                
                cargar_datatable();
            }
        };
    }();

    let noticias = function() {
        return {
            init: function() {
                script_noticias.init();
            }
        };
    }();

    jQuery(document).ready(function() {
        noticias.init();
    });
</script>