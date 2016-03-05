/*Mi propio JavaScript*/

var ws = "datos.php";

function contactos(codigo, nombre, apellido
        , telefono
        ) {
    this.codigo = codigo;
    this.nombre = nombre;
    this.apellido = apellido;
    this.telefono = telefon;
 
    this.toStringJSON = function () {
        return JSON.stringify(this)
    };
}

function listUsuario() {
     $.ajax({
            url: ws,
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json',
            success: function (response) {
                var trHTML = '';
                $.each(response, function (i, item) {
                    trHTML += '<tr><td>' + item.descripcion + '</td><td>' + item.latitud + '</td><td class="two">' + item.longitud + '</td><td onclick="getValue('+item.latitud+','+item.longitud+')"><a href="#">Ver ruta</a></td></tr>';
                });
                $('#sample_1').append(trHTML);
            }
        });
}

function getValue(celda1,celda2){
    //alert(celda1+' - '+celda2);
    $('#id_input').val(celda1);
    $('#id_input2').val(celda2);
}

function createUsuario() {
    $.get("create.html", function (paginita) {
        $("#crud").html(paginita);

        $("formUsuario").append($("<input>", {type: "button"
            , value: "Registrar"
            , onclick: "return saveUsuarioJSON(new usuario(id.value,nombre.value,mail.value,telefonoCel.value(),telefonoCasa.value(),fecha.value(),anioNacimiento.value()))"
        }));
    })
}

function saveUsuarioJSON(usuario) {
    $.ajax({
        type: "POST"
        , url: ws
        , data: usuario.toStringJSON()
        , async: true
        , cache: false
        , contentType: "application/json"
        , dataType: "json"
        , success: function () {
            alert("Usuario agregado Exitosamente");
        }
    });
    return false;
}




function saveUsuarioXML() {
    var entity = "<usuario>"
            + "<id>" + $("#id").val() + "</id>"
            + "<nombre>" + $("#nombre").val() + "</nombre>"
            + "<mail>" + $("#mail").val() + "</mail>"
            + "<telefonoCel>" + $("#telefonoCel").val() + "</telefonoCel>"
            + "<telefonoCasa>" + $("#telefonoCasa").val() + "</telefonoCasa>"
            + "<fecha>" + $("#fecha").val() + "</fecha>"
            + "<anioNacimiento>" + $("#anioNacimiento").val() + "</anioNacimiento>"

            + "</usuario>";

    $.ajax({
        type: "POST"
        , url: ws
        , data: entity
        , async: true
        , cache: false
        , contentType: "application/xml"
        , dataType: "xml"
        , success: function (data) {
            console.log(data);
        }
    });
    return false;
}


function updateUsuario(id) {
    $.get("update.html", function (paginita) {
        $("#crud").html(paginita);



        $.ajax({
            type: "GET"
            , url: ws + "/" + id
            , async: true
            , cache: false
            , contentType: "application/json"
            , dataType: "json"
            , success: function (contactos) {
                $("#codigo").val(contactos.codigo);
                $("#nombre").val(contactos.nombre);
                $("#apellido").val(contactos.apellido);
                $("#telefono").val(contactos.telefono);
                
            }
        });
    }
    );

}


function updateUsuarioJSON(id) {


    var entity = {id: $("#codigo").val()
        , nombre: $("#nombre").val()
        , apellido: $("#apellido").val()
        , telefono: $("#telefono").val()
       

    };
    $.ajax({
        type: "PUT",
        contentType: "application/json",
        url: ws+'/'+ id,
        dataType: "json",
        data: contactos.toStringJSON(),
        success: function (data, textStatus, jqXHR) {
            window.location.reload()
            alert(data, 'Actualizado');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('ERROR');
        }
    });


}








function deleteContacto(codigo) {
    if (confirm("Deseas eliminar el registro?")) {
        $.ajax({
            type: "delete"
            , url: ws + "/" + codigo
            , async: true
            , cache: false
            , contentType: "application/json"
            , dataType: "json"
            , success: function (contactos) {
                console.log(contactos);
                window.location.reload();
            }
        })
        listUsuario();

    }
}





