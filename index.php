<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD con PHP, PDO, Ajax y Datatables.js</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
  </head>
  <body>

    <div class="container fondo">
        <h1 class="text-center">CRUD con PHP, PDO, Ajax y Datatables.js</h1>

        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#modalUsuario" id="botonCrear">
                    <i class="bi bi-plus-circle-fill"></i> &nbsp; Crear
                    </button>
                </div>
            </div>
        </div>

        <br><br>

        <div class="table-responsive">
            <table id="datos_usuario" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Imagen</th>
                        <th>Fecha Creación</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>    
            </table>
        </div>
    </div>

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="formulario" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-body">
                            <label for="nombre">Ingrese el nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                            <br>
                            <label for="apellidos">Ingrese los apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control">
                            <br>
                            <label for="telefono">Ingrese el teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                            <br>
                            <label for="email">Ingrese el email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <br>
                            <label for="imagen_usuario">Seleccione una imagen</label>
                            <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                            <span id="imagen-subida"></span>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="operacion" id="operacion">
                            <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#botonCrear').click(function(){
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#imagen_subida").html("");
            });
            var dataTable = $('#datos_usuario').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax":{
                    url: "obtener_registros.php",
                    type: "POST",
                },
                "columnsDefs":[
                    {
                    "targets":[0, 3, 4],
                    "orderable": false,
                    },  
                ]
            });
        });

        $(document).on('submit', '#formulario', function(event){
            event.preventDefault();
            var nombres = $("#nombre").val();
            var apellidos = $("#apellidos").val();
            var telefono = $("#telefono").val();
            var email = $("#email").val();
            var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();

            if(extension != ''){
                if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1){
                    alert("Formato de imagen inválido");
                    $("#imagen_usuario").val('');
                    return false;
                }
            }

            if(nombres != '' && apellidos != '' && email != ''){
                $.ajax({
                    url: "crear.php",
                    method: "POST",
                    data:new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data){
                        alert(data);
                        $('#formulario')[0].reset();
                        $('#modalUsuario').modal.hide();
                        dataTable.ajax.reload();
                    }
                });
            }else{
                alert("Algunos campos son obligatorios");
            }

        });

    </script>

  </body>
</html>