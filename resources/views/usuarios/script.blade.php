<script type="text/javascript" src="{{asset('packages/datatables/datatables.min.js')}}"></script>
<script>

    /**
     * Bloque funcional para gestionar usuarios.
     */
    let script_usuarios = function() {
        let datatable_usuarios;

        /**
         * Cargar datatable con todas las subsecciones existentes.
         */
        let cargar_datatable = function() {
            datatable_usuarios = jQuery('#tabla').DataTable({
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
                    "info": "Mostrando de _START_ a _END_ en un total de _TOTAL_ usuarios",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing":   "<span style='color:#1b330c' class='fa-stack fa-lg'>\n\
                                        <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                                    </span>&emsp;Cargando...",
                    "zeroRecords": "Sin resultados",
                    "infoEmpty": "Mostrando 0 usuarios",
                },
                order: [[0, 'asc']],
                ajax: {
                    url: '{{ URL::current() }}',
                    data: function (d) {
                        d.nombre_completo = $('input[name=nombre_completo]').val();
                        d.email = $('input[name=email]').val();
                        d.rol_id = $('select[name=rol_id]').val();
                    }
                },
                columns: [
                    {data: "nombre_completo", name: "nombre_completo", className: ""},
                    {data: "email", name: "email", className: ""},
                    {data: "rol", name: "rol", className: ""},
                    {data: "estado", name: "estado", className: "ta-center"},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: "ta-center"}
                ]
            });
        };

        let modal_cambiar_estado = function(event) {
            event.preventDefault();
            let btn = jQuery(event.target);
            if(btn.prop("tagName") != "A"){
                btn = btn.parent();
            }
            let id = btn.data('id');
            let url = btn.data('url');
            let es_activar = btn.data('activar');
            let texto_activar = "";
            if(es_activar){
                let texto_activar = "¿Está seguro que desea activar el usuario?"
            }else{
                let texto_activar = "¿Está seguro que desea desactivar el usuario?"
            }
            swal({
                title: "Cambiar estado",
                text: texto_activar,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDelete) {
                if (willDelete) {
                    let CSRF_TOKEN = jQuery('meta[name="csrf-token"]').attr('content');
                    let prom_estado= jQuery.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                        _token: CSRF_TOKEN,
                        id: id
                    }
                    });
                    prom_estado.done(function (data) {
                        swal("Eliminado correctamente", {
                            icon: "success",
                        });
                        $("#tabla").DataTable().ajax.reload();
                    });

                    prom_estado.error(function (data) {
                        swal("Ha ocurrido un error", {
                            icon: "error",
                        });
                    });

                } else {
                    swal("Acción cancelada");
                }
            });
        };

        return {
            init: function() {

                $(document).on('click', '.paginate_button', function () {
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                });

                //Buscador
                jQuery('#buscar').click(function() {
                    datatable_usuarios.ajax.reload();
                });

                cargar_datatable();
            },
            modal_cambiar_estado: function (btn) {
                modal_cambiar_estado(btn);
            }
        };
    }();

    let usuarios = function() {
        return {
            init: function() {
                script_usuarios.init();
            }
        };
    }();

    jQuery(document).ready(function() {
        usuarios.init();
    });
</script>