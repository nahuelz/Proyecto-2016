$(document).ready(function() {
    var caracteres = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
    var numeros = /^[0-9]+$/;
    rows = 2;


    $(".usuario").click(function (){
        $(".error").remove();
        if( $("#documento").val().length < 7 || $("#documento").val().length > 8 ) {
            $("#documento").focus().after("<span class='error'>Ingrese un documento correcto</span>");
            return false;  
        }
        if( $("#rol").val() == 3) {
            if ( $("#nombre_trabajo").val().length < 4){
                $("#nombre_trabajo").focus().after("<span class='error'>Ingrese un lugar de trabajo valido. </span>");
                return false;  
            }
            if ( $("#descripcion_trabajo").val().length < 4){
                $("#descripcion_trabajo").focus().after("<span class='error'>Ingrese una deescripcion valida. </span>");
                return false;
            }
        }
        if( $("#nombre").val().length < 4 || !caracteres.test($("#nombre").val())) {
            $("#nombre").focus().after("<span class='error'>Ingrese un nombre valido</span>");
            return false;  
        }
        if( $("#usuario").val().length < 4 ) {
            $("#usuario").focus().after("<span class='error'>Ingrese un usuario valido</span>");
            return false;  
        }
        if( $("#apellido").val().length < 4 || !caracteres.test($("#apellido").val())) {
            $("#apellido").focus().after("<span class='error'>Ingrese un apellido valido</span>");
            return false;  
        }
        if( $("#telefono").val().length < 7 || !numeros.test($("#telefono").val())) {
            $("#telefono").focus().after("<span class='error'>Ingrese un telefono valido</span>");
            return false;  
        }
    });

    $(".altaProducto").click(function (){
        $(".error").remove();
            if( $("#codigoBarra").val().length != 6 || !numeros.test($("#codigoBarra").val())) {
            $("#codigoBarra").focus().after("<span class='error'>El codigo de barra debe tener 6 caracteres numericos.</span>");
            return false;  
        }
    });

    $("#documento").keyup(function(){
        if( $(this).val() != "" ){
            $(".error").fadeOut();
            return false;
        }
    });

    $("#agregarCampo").click(function(){

        var div = $("<div class=\"divDinamico\"/>");

        var campoId = $("#formulario input").length + 1; //Asigno un id dinamico a cada input

        var campoProductoOld = $("<label>Producto: </label><select class=\"campoDinamico inputVenta\"><option value=\"producto1\">producto1</option><option value=\"producto2\">Producto2</option><option value=\"producto3\">Producto3</option></select></label>");

        var campoProducto = $("<label>Producto: </label><input class=\"campoDinamico inputVenta\" name=\"producto\" palcegolder=\"Buscar producto por nombre\" maxlength=\"100\" required><datalist class=\"inputVenta\" id=\"productos\">{% for p in products %}<option onclick=\"adddElement('{{ p.nombre }}')\" value=\"{{ p.nombre }}\">'{% endfor %}'</datalist>")

        var campoCantidad = $("<label>Cantidad: </label><input class=\"inputVenta\" id=\"cantidad" + campoId + "\" type=\"text\">")


        var eliminarCampo = $("<input type=\"button\" class=\"remove\" value=\"Borrar campo\" />");
        eliminarCampo.click(function() {
            $(this).parent().remove();
        });

        div.append(campoProducto);
        div.append(campoCantidad);
        div.append(eliminarCampo);
        $("#dinamico").append(div);
    });
    
    $("#sumarProd").click(function(){
        var div = $("<div id="+rows+"></div>");
        var inputProducto = $("#productoCompra").clone();
        var inputCant = $("#cantidadProducto").clone();      
        var inputPrecio = $("#precioProducto").clone();

        inputProducto.attr("name", "producto"+rows);
        inputCant.attr("name", "cantidad"+rows);
        inputPrecio.attr("name", "precio"+rows);

        var eliminarCampo = $("<input type=\"button\" style=\"width: 15%;\" class=\"remove\" value=\"Borrar campo\" />");
        eliminarCampo.click(function() {
            $(this).parent().remove();
        });

        div.append(inputProducto);
        div.append(inputCant);     
        div.append(inputPrecio);
        div.append(eliminarCampo);

        $("#listaProductos").append(div);
        $("#cantProductos").attr("value", rows);
        rows++;
    });
});


function ocultarMostrarNav(id) {
    var x = document.getElementById(id);
    if (x.className === "") {
        x.className = "hiddenNav";
    } else {
        x.className = "";
    }
}

function ocultarMostrarAside(id) {
    var x = document.getElementById(id);
    var y01 = document.getElementById(id.concat('01'));
    var y02 = document.getElementById(id.concat('02'));
    if (x.className === "") {
        x.className = "hidden";
        y01.className = "deslegable01 hidden";
        y02.className = "deslegable02";
    } else {
        x.className = "";
        y01.className = "deslegable01";
        y02.className = "deslegable02 hidden";
    }
}

function eliminar(id, accion){
    if(confirm("¿Desea eliminar el registro?")){
        window.location = "./?action="+accion+"&id="+id;
    }
}

function cancelar(id, accion, from){
    if(confirm("¿Desea eliminar este pedido?")) {
        window.location = "./?action=" + accion + "&id=" + id + "&from=" + from + "&function=cancelar_pedido";
    }
}

function aceptar(id){
    if(confirm("¿Desea confirmar el pedido?")) {
        window.location = "./?action=pedidos" + "&pedidoId=" + id + "&function=aceptar_pedido";
    }
}


