/*Autenticacion de usuario*/
$(document).on('submit', '#login', function(e) {
    e.preventDefault();
    let datos = {
        usuemail: $("#usuemail").val(),
        usupass: $("#usupass").val()
    }
    $.ajax({
        url: '/signin',
        method: 'POST',
        data: { data: btoa(JSON.stringify(datos)) },
        dataType: 'JSON',
        beforeSend: function() {
            // $("button[type=submit]").addClass('disabled');
            // Swal.fire({
            //     toast: true,
            //     position: 'center',
            //     showConfirmButton: false,
            //     timer: 2000,
            //     type: 'info',
            //     title: 'Verficando informacion'
            // });
        },
        success: function(mensaje) {


            if (mensaje === 0) {
                Swal.fire({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'success',
                    title: 'Iniciando Sesion'
                });
                setTimeout(function() {
                    window.location = "/inicio";
                }, 1400);
            } else if (mensaje === 1) {
                Swal.fire({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Contraseña Invalida'
                });
            } else if (mensaje === 2) {
                Swal.fire({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Usuario Inactivo o Bloqueado'
                });

            } else if (mensaje === 3) {
                Swal.fire({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Usuario o contraseña incorrectos'
                });

            }
        }
    })
});

/*Verficacion de datos en el form*/
$(document).on('change', '#usuemail', function(e) {
    let texto = $("#usuemail").val();
    if (texto.match(/\w*.\w*\@sapi.gob.ve/) == null) {
        $("button[type=submit]").removeClass('is-valid');
        $("#usuemail").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.lenght < 5) {
        $("#usuemail").removeClass('is-invalid');
        $("#usuemail").removeClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    } else if (datos.usuemail.lenght < 1 || datos.usupass.lenght < 1) {
        Swal.fire({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000,
            type: 'error',
            title: 'Debe rellenar los campos solicitados'
        });
    } else if (datos.usuemail.lenght < 1 && datos.usupass.lenght > 1) {
        $("#usuemail").addClass('is-invalid');
    } else if (datos.usupass.lenght < 1 && datos.usuemail.lenght > 1) {
        $("#usupass").addClass('is-invalid');
    } else {
        $("#usuemail").removeClass('is-invalid');
        $("#usuemail").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});