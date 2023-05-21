<script type="text/javascript" src="{{asset('packages/datatables/datatables.min.js')}}"></script>
<script>

    /**
     * Bloque funcional para gestionar noticias.
     */
    let script_noticias = function() {
        let datatable_tipos_lista;

        /**
         * Cargar datatable con todas las subsecciones existentes.
         */
        let cargar_datatable = function() {
            datatable_tipos_lista = jQuery('#tabla').DataTable({
                ordering: true,
                fixedColumns: false,
                info: false,
                autoWidth: false,
                stateSave: false,
                lengthChange: false,
                searching: false,
                processing: true,
                serverSide: true,
                order: [[0, 'asc']],
                ajax: {
                    url: '{{ URL::current() }}',
                    data: function (d) {
                        d.titulo = $('input[name=titulo]').val();
                        d.fuente_id = $('select[name=fuente_id]').val();
                        d.bien_cultural_id = $('select[name=bien_cultural_id]').val();
                        d.municipio_id = $('select[name=municipio_id]').val();
                        d.provincia_id = $('select[name=provincia_id]').val();
                    }
                },
                columns: [
                    {data: "titulo", name: "titulo", className: ""},
                    {data: "fuente", name: "fuente", className: ""},
                    {data: "bien_cultural", name: "bien_cultural", className: ""},
                    {data: "municipio", name: "municipio", className: ""},
                    {data: "provincia", name: "provincia", className: ""},
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

                //Buscador
                jQuery('#buscar').click(function() {
                    datatable_tipos_lista.ajax.reload();
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