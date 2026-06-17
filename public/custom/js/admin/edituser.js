$(function() {

    let id_direccion = $('#editusudir').val();
    let id_departamento = $('#editusudep').val();
    let id_rol = $('#editrol').val();
    llenar_direcciones(Event, id_direccion);
    llenar_departamentos(Event, id_departamento);
    llenar_rol(Event, id_rol);

    let borrado = $('#borrado').val();
    if (borrado == '0') {
        $('#usuopborrado').attr('checked', 'checked');
        $('#usuopborrado').val('0');
    }
    if (borrado == '1') {
        $('#usuopborrado').removeAttr('checked')
        $('#usuopborrado').val('1')
    }



});




function llenar_rol(e, id_rol) {

    e.preventDefault
    url = '/listar_rol';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $('#usurol').empty();
                $('#usurol').append('<option value=0  selected disabled>Seleccione</option>');
                if (id_rol === undefined) {
                    $.each(data, function(i, item) {
                        //console.log(data)
                        $('#usurol').append('<option value=' + item.idrol + '>' + item.rolnom + '</option>');

                    });
                } else {

                    $.each(data, function(i, item) {
                        if (item.idrol === id_rol) {
                            $('#usurol').append('<option value=' + item.idrol + ' selected>' + item.rolnom + '</option>');

                        } else {

                            $('#usurol').append('<option value=' + item.idrol + '>' + item.rolnom + '</option>');
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}





function llenar_departamentos(e, id_departamento) {

    e.preventDefault
    url = '/listar_departamentos';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $('#usudep').empty();
                $('#usudep').append('<option value=0  selected disabled>Seleccione</option>');
                if (id_departamento === undefined) {
                    $.each(data, function(i, item) {
                        //console.log(data)
                        $('#usudep').append('<option value=' + item.deptid + '>' + item.depnom + '</option>');

                    });
                } else {

                    $.each(data, function(i, item) {
                        if (item.deptid === id_departamento) {
                            $('#usudep').append('<option value=' + item.deptid + ' selected>' + item.depnom + '</option>');

                        } else {

                            $('#usudep').append('<option value=' + item.deptid + '>' + item.depnom + '</option>');
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}








function llenar_direcciones(e, id_direccion) {

    e.preventDefault
    url = '/listar_direcciones';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $('#usudir').empty();
                $('#usudir').append('<option value=0  selected disabled>Seleccione</option>');
                if (id_direccion === undefined) {
                    $.each(data, function(i, item) {
                        //console.log(data)
                        $('#usudir').append('<option value=' + item.dirid + '>' + item.dirnom + '</option>');

                    });
                } else {

                    $.each(data, function(i, item) {
                        if (item.dirid === id_direccion) {
                            $('#usudir').append('<option value=' + item.dirid + ' selected>' + item.dirnom + '</option>');

                        } else {

                            $('#usudir').append('<option value=' + item.dirid + '>' + item.dirnom + '</option>');
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}