function validarLogin()
{
    if ($.trim($('#usuario').val()).length == 0) {
        $('#error').html("Debe ingresar un nombre de usuario");
        $('#usuario').focus();
        return false;
    }
    else {
        if ($.trim($('#password').val()).length == 0) {
            $('#error').html("Debe ingresar una contraseña");
            $('#password').focus();
            return false;
        }
        else {
            $.post("redireccionar.php",
                $('#formulario').serialize(),
                function(data) {
                    if (data.ok) {
                        location.assign(data.url);
                    }
                    else {
                        $('#usuario').focus();
                        $('#error').html(data.msj);
                    }
                }
                ,"json"
            );
        }
    }
}

function remitir(pagina, idFormulario, divMostrar)
{
    $.post(pagina, $("#" + idFormulario).serialize(), function(data) {$("#" + divMostrar).html(data);});
}

// Muestra un mensaje de exito.
function mostrarCorrecto(msj)
{
    $('#msj').attr("class", "ui-state-highlight ui-corner-all").html(msj);
}

function mostrarError(msj)
{
 	$('#msj').attr("class", "ui-state-error ui-corner-all").html(msj);
}


//Muestra msj y recarga pagina si es solicitado
function mostrarMsj(datos, pagina, origen)
{
    if (datos.ok) {
        //mostrando msj de exito
        $("#msj").attr("class", "ui-state-highlight ui-corner-all").html(datos.msj);
        //recargando pagina
        $("#principal").load(pagina);
    }
    else {
        if (origen == "dialogo") {
            alert("ERROR: " + datos.msj);
        }
        else {
            $("#msj").attr("class", "ui-state-error ui-corner-all").html("<strong>ERROR:</strong> " + datos.msj);
        }
    }
    
    return datos.ok;
}

//funcion para cargar paginas desde el menu
function cargar(pagina)
{
    $("#principal").html('<div id="cargando"><div><img src="/css/images/iconos/indicator.gif" /></div><div>Cargando...</div></div>').show();
    
    $('#msj').removeAttr("class").empty();
    $('#principal').load(pagina, function(response, status, xhr) {
        if (status == "error") {
            var msg = "No se pudo cargar el contenido: ";
            $(this).html(msg + xhr.status + " " + xhr.statusText);
        }
    });
}

/***********************************************************************************************/
/* PARA DESPLEGAR EL DIALOGO DE CIERRE DE SESION */
function mostrarDialogo(idDiv, tituloDialogo, width, height, pantallaCompleta, imprimir, imprimirPdf)
{
    var objDialog = null;
    
    objDialog = $('#'+idDiv).dialog('open');
    objDialog = $('#'+idDiv).dialog({
        title: tituloDialogo,
        modal: true,
        closeOnEscape: true,
        position:'top',
        width: width,
        height: height,
        overlay: {
            backgroundColor: '#000',
            opacity: 0.5
        },
        buttons: {
            'Cerrar': function() {
                    // De cualquier forma, el cuadro debe ser cerrado.
                    $(this).dialog('close');
                    $(this).dialog('destroy');
                    $(this).html("");
                }
        }
    });

    if(pantallaCompleta){
        $("#"+idDiv).dialog( "option", "height", window.innerHeight - 2);
        $("#"+idDiv).dialog( "option", "width", window.innerWidth - 5);
        $("#"+idDiv).dialog( "option", "position", [10, 10]);
    }
    
    if (imprimir) {
        objDialog.dialog("option", "buttons", {
            "Imprimir": function() {
                imprimirElemento(objDialog);
            },
            "Cerrar": function() {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $(this).html("");
            }
        });
    }
    
    if (imprimirPdf) {
        objDialog.dialog("option", "buttons", {
            "Imprimir PDF": function() {
                // la variable imprimirPdf contendra el id de la orden
                window.open("/administracion/imprimirOrdenPdf.php?id_orden_produccion=" + imprimirPdf);
            },
            "Imprimir": function() {
                imprimirElemento(objDialog);
            },
            "Cerrar": function() {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $(this).html("");
            }
        });
    }
}

/* -- Administracion -- */
function mostrarDialogo2(idDialogo, paginaFrm, paginaPrc, idFormEnviar, paginaOk, tituloDialogo, alto, ancho, datosModificar, funcValidar)
{
    $("#" + idDialogo).html('<div id="cargando"><div><img src="/css/images/iconos/indicator.gif" /></div><div>Cargando...</div></div>').show();

    $("#" + idDialogo).load(paginaFrm, datosModificar, function(response, status, xhr) {
        if (status == "error") {
            var msg = "No se pudo cargar el contenido: ";
            $("#" + idDialogo).html(msg + xhr.status + " " + xhr.statusText);
        }
    });

    $("#" + idDialogo).dialog("open");
    $("#" + idDialogo).dialog({
        title: tituloDialogo,
        position: 'top',
        height: alto,
        width: ancho,
        modal: true,
        buttons: {
            "Guardar": function() {
                $("#msj").removeAttr("class").empty();
                $.validator.setDefaults({
                    highlight: function(input) {
                        $(input).addClass("ui-state-highlight");
                    },
                    unhighlight: function(input) {
                        $(input).removeClass("ui-state-highlight");
                    }
                });
                $("#" + idFormEnviar).validate(funcValidar());
                
                if ($("#" + idFormEnviar).valid()) {
                    $("#msj").html('<div id="cargando"><div><img src="/css/images/iconos/indicator.gif" /></div><div>Realizando la operaci&oacute;n solicitada, por favor espere...</div></div>').show();
                    
                    objDialog = $(this);
                    //Mandando datos a pagina de proceso
                    $.post(paginaPrc,
                        $("#" + idFormEnviar).serialize(),
                        function(data) {
                            $("#msj").removeAttr("class").empty();
                            if (mostrarMsj(data, paginaOk, "dialogo")) {
                                //destruyendo dialogo
                                objDialog.dialog('close');
                                objDialog.dialog('destroy');
                                objDialog.html("");
                            }
                        },
                        "json"
                    );
                }
            },
            "Cancelar": function() {
                //destruyendo dialogo
                $(this).dialog('close');
                $(this).dialog('destroy');
                $(this).html("");
            }
        }
    });
}

function enviarPost(paginaPrc, datos, paginaOk)
{
    $("#msj").removeAttr("class").empty();
    $("#msj").html('<div id="cargando"><div><img src="/css/images/iconos/indicator.gif" /></div><div>Realizando la operaci&oacute;n solicitada, por favor espere...</div></div>').show();
    $.post(paginaPrc,
        datos,
        function(data){
            $("#msj").removeAttr("class").empty();
            mostrarMsj(data, paginaOk);
        }
        ,"json"
    );
}
/* -- Administracion -- */