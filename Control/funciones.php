<?php
    session_start();
    if (!isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
        exit;
    }
    
    /* Connect To Database*/
    require_once("config/db.php"); // Contiene las variables de configuracion para conectar a la base de datos
    require_once("config/conexion.php"); // Contiene funcion que conecta a la base de datos
    
    $active_categoria = "active";
    $title = "Categorías";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
    <?php include("navbar.php"); ?>
    
    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <button type='button' class="btn btn-success" data-toggle="modal" data-target="#nuevoCliente">
                        <span class="glyphicon glyphicon-plus"></span> Nueva Categoría
                    </button>
                </div>
                <h4><i class='glyphicon glyphicon-search'></i> Buscar Categorías</h4>
            </div>
            
            <div class="panel-body">
                <?php
                include("modal/registro_categorias.php");
                include("modal/editar_categorias.php");
                ?>
                
                <form class="form-horizontal" role="form" id="datos_cotizacion">
                    <div class="form-group row">
                        <label for="q" class="col-md-2 control-label">Nombre</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="q" placeholder="Nombre de la categoría" onkeyup='load(1);'>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default" onclick='load(1);'>
                                <span class="glyphicon glyphicon-search"></span> Buscar
                            </button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>
                
                <div id="resultados"></div><div class='outer_div'></div></div>
        </div>
    </div>
    
    <hr>
    <?php include("footer.php"); ?>
    
    <script type="text/javascript" src="js/categorias.js"></script>
  </body>
</html>

<script>
// Guardar nueva categoría de forma asíncrona
$("#guardar_categoria").submit(function( event ) {
    $('#guardar_datos').attr("disabled", true);
  
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nueva_categoria.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
});

// Editar categoría existente
$("#editar_categoria").submit(function( event ) {
    $('#actualizar_datos').attr("disabled", true);
  
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/editar_categoria.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#resultados_ajax2").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax2").html(datos);
            $('#actualizar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
});

// Pasar los datos de la tabla al modal para poder editarlos
function obtener_datos(id){
    var nombre_categoria = $("#nombre_categoria"+id).val();
    var descripcion_categoria = $("#descripcion_categoria"+id).val(); // Por si tienes descripción en tu tabla
    
    $("#mod_id").val(id);
    $("#mod_nombre").val(nombre_categoria);
    $("#mod_descripcion").val(descripcion_categoria);
}
</script>