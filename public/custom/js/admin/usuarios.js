let usuarios = [];



/*Evento que busca el valor en la tabla y lo agrega o elimina segun el caso */
$(document).on('change', 'input[name=userval]', function() {
    if ($(this).is(':checked')) {
        usuarios.push($(this).val());
    } else {
        usuarios.removeItem($(this).val());
    }
    if (usuarios.length > 1) {
        Swal.fire('Atencion!', 'Solo debe seleccionar un registro', 'warning');
        $(this).attr(':unchecked');
    }
});

/*Para borrar un registro de direcciones*/
$(document).on('click', '.userdel', function(e) {
    if (usuarios.length < 1) {
        Swal.fire("Atencion", "Debe seleccionar un registro", 'warning');
    } else if (usuarios.length > 1) {
        Swal.fire("Atencion", "Debe seleccionar solo un registro", 'warning');
    } else {
        e.preventDefault();
        let id = usuarios[0];
        Swal.fire({
            title: '¿Esta seguro de eliminar este registro?',
            text: "Esta Accion no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/usuarios/' + id,
                    method: 'DELETE',
                    dataType: 'JSON',
                    beforeSend: function() {
                        $("button[type=submit]").addClass('disabled');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            load_data();
                            $("button[type=submit]").removeClass('disabled');
                        }
                    }
                });
                Swal.fire("Exito", "Operacion completada exitosamente", 'success');
            }
        });
        usuarios.pop();
    }
});

/*Carga de los departamentos de manera dinamica*/
$(document).on('change', '#usudir', function(e) {
    let dato = $("#usudir").val();
    if (dato != 'Seleccione una opcion') {
        $.ajax({
            url: '/getDepts/' + dato,
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                switch (response.status) {
                    case 200:
                        html = "<option>Seleccione una opcion</option>";
                        /*Ponemos los select donde corresponda*/
                        for (let i = 0; i < response.data.length; i++) {
                            let row = response.data[i];
                            html = html + `<option value="${row[0]}">${row[1]}</option>`;
                        }
                        $("#usudep").html(html);
                        break;
                }
            }
        });
    } else {
        html = "<option>Seleccione una opcion</option>";
        $("#usudep").html(html);
    }
});


//******METODO QUE TOMA EL ESTATUS ACTUAL DEL CHECKBO*****
$('#usuopborrado').click(function() {
    if ($('#usuopborrado').is(':checked')) {

        $("#borrado_actual").val('0');
    } else {
        $("#borrado_actual").val('1');

    }

});

/*Evento para enviar el formulario*/
$(document).on('submit', '#userinfodata', function(e) {
    e.preventDefault();
    let mode = $("#optype").val();
    let borrado = $("#borrado_actual").val();
    let datos = {
        userid: $("#userid").val(),
        userpnom: $("#userpnom").val(),
        usersnom: $("#usersnom").val(),
        userpape: $("#userpape").val(),
        userspae: $("#userspae").val(),
        useremail: $("#useremail").val(),
        borrado: borrado,
        usudir: $("#usudir").val(),
        usudep: $("#usudep").val(),
        usurol: $("#usurol").val(),
        userpass: $("#userpass").val(),
    }
    $.ajax({
        url: '/usuarios',
        method: 'POST',
        data: { data: btoa(JSON.stringify(datos)) },
        beforeSend: function() {
            $("button[type=submit]").attr('disabled', 'true');
        },
        dataType: 'JSON',
        success: function(response) {
            switch (response.status) {
                case 200:
                    $("button[type=submit]").removeAttr('disabled');
                    if (mode == "0") {
                        window.location = '/admin';
                    } else {
                        window.location = "/inicio";
                    }
                    break;
                default:
                    $("button[type=submit]").removeAttr('disabled');
                    Swal.fire('Error!', 'Hubo un error al cargar los datos', 'error');
                    break;
            }
        }
    });
});