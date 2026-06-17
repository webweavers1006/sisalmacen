
  function valideKey(evt) {
    var code = (evt.which) ? evt.which : evt.keyCode;
    return (code == 8 || (code >= 48 && code <= 57));
  }

// 1. Eliminar Imagen mediante AJAX (Lógica de borrado físico)
    $('#btn_eliminar_img').click(function() {
      if (confirm('¿Está seguro de eliminar la imagen actual del servidor?')) {
        let codbar = $("#codbar").val();
       // console.log('Delete img AJAX:', codbar);
        $.ajax({
          url: '/productos/updateImagen/' + codbar,
          method: 'POST',
          data: { action: 'delete' },
          dataType: 'JSON',
          success: function(response) {
            //console.log('Delete success:', response);
            $('#img_actual').attr('src', '/documentos_productos/sin_img.png');
            Swal.fire('Eliminado', 'La imagen ha sido borrada.', 'success');
          },
          error: function(xhr) {
            //console.error('Delete error:', xhr.responseText);
            Swal.fire('Error', 'No se pudo eliminar el archivo.', 'error');
          }
        });
      }
    });

    // 2. Previsualización de la nueva imagen seleccionada
    $('#imagen').change(function() {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          // Reemplaza la vista actual con la nueva para que el usuario vea qué va a subir
          $('#img_actual').attr('src', e.target.result).css('border', '2px solid #27ae60');
        };
        reader.readAsDataURL(file);
      }
    });

 function valideKey(evt) {
    var code = (evt.which) ? evt.which : evt.keyCode;
    return (code == 8 || (code >= 48 && code <= 57));
  }

  function limpiarPreview() {
    $('#img_nueva').attr('src', '/documentos_productos/sin_img.png');
  }
  
  $(document).ready(function() {
    $('#imagen').change(function() {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#img_nueva').attr('src', e.target.result).fadeIn();
        };
        reader.readAsDataURL(file);
      } else {
        limpiarPreview();
      }
    });
  });


$(document).ready(function() {
    // Auto-generar código de barras si está vacío
    if (!$("#codbar").val()) {
        $.ajax({
            url: '/productos/getNextCodbarAjax',
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                if (response.next_codbar) {
                    $("#codbar").val(response.next_codbar);
                }
            },
            error: function() {
               // console.log('Error al obtener siguiente codbar');
            }
        });
    }

    // 1. Inicialización de variables y carga de categorías
    let borrado_inicial = $("#borrado_actual").val();
    let id_cat_seleccionada = $("#id_categoria").val(); // Este viene de la base de datos si es edición
    
    // Llamada inicial para llenar el select
    llenar_categoria(id_cat_seleccionada);

    // Configuración visual inicial del checkbox de borrado
    if (borrado_inicial == '0') {
        $("#borrado").prop("checked", true);
    } else {
        $("#borrado").prop("checked", false);
    }

    // 2. Lógica para previsualizar la imagen (ID original: imagen)
    $('#imagen').change(function() {
      var file = this.files[0];
      //console.log('File change:', file ? file.name : 'no file');
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#img_actual').attr('src', e.target.result);
          let codbar = $("#codbar").val();
          //console.log('Preview set, codbar:', codbar);
          // AJAX upload
          let formData = new FormData();
          formData.append('imagen', file);
          $.ajax({
            url: '/productos/updateImagen/' + codbar,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function(response) {
              // console.log('Upload success:', response);
              // Swal.fire('OK', 'Imagen actualizada', 'success');
            },
            error: function(xhr) {
              //console.error('Upload error:', xhr.responseText);
              Swal.fire('Error', 'No se pudo actualizar imagen', 'error');
            }
          });
        };
        reader.readAsDataURL(file);
      }
    });

    // 3. Manejo del Checkbox de Borrado (Sincroniza con el input hidden)
    $('#borrado').click(function() {
        if ($(this).is(':checked')) {
            $("#borrado_actual").val('0');
        } else {
            $("#borrado_actual").val('1');
        }
    });

    // 4. Función para llenar el combo de categorías
    function llenar_categoria(id_categoria) {
        let url = '/listar_categorias';
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function(data) {
                if (data.length >= 1) {
                    $('#categoria').empty();
                    $('#categoria').append('<option value="0">Seleccione</option>');
                    
                    $.each(data, function(i, item) {
                        // Si el ID coincide con la categoría del producto, se marca como selected
                        let selected = (item.id == id_categoria) ? 'selected' : '';
                        $('#categoria').append('<option value="' + item.id + '" ' + selected + '>' + item.descripcion + '</option>');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar categorías:", error);
            }
        });
    }

    // 5. Envío del Formulario (Submit)
    $(document).on('submit', '#nuevoproducto', function(e) {
        e.preventDefault();
        //console.log('Form submit #nuevoproducto, modform:', $("#modform").val(), 'codbar:', $("#codbar").val(), 'file:', $('#imagen')[0].files[0] ? $('#imagen')[0].files[0].name : 'no');

        let buscar_codbar = $("#codbar").val();
        let borrado_val = $("#borrado_actual").val();
        let id_categoria = $("#categoria").val();

        if (id_categoria == '0' || id_categoria == null) {
            Swal.fire('Atención', 'Debe Seleccionar una Categoria', 'warning');
            return false;
        }

        var formData = new FormData();
        
        let datos_producto = {
            'modform': $("#modform").val(),
            'codbar': $("#codbar").val(),
            'prodmar': $("#prodmar").val(),
            'prodmodel': $("#prodmodel").val(),
            'borrado': borrado_val,
            'id_categoria': id_categoria,
            'stock_min': $("#stock_min").val()
        };
        //console.log('Form data:', datos_producto);

        formData.append('data', btoa(JSON.stringify(datos_producto)));

        if ($('#imagen')[0].files[0]) {
            formData.append('imagen', $('#imagen')[0].files[0]);
        }

        $.ajax({
            url: '/buscar_producto_existencias/' + buscar_codbar,
            method: 'POST',
            dataType: 'JSON',
            success: function(data) {
               // console.log('Existencias check:', data);
                if (data.length > 0 && data[0].numexis > 0 && borrado_val == '1') {
                    Swal.fire('Error', 'No se puede eliminar el producto debido a que tiene existencia en inventario', 'error');
                } else {
                    ejecutarGuardado(formData);
                }
            },
            error: function() {
                ejecutarGuardado(formData);
            }
        });
    });

    // Función auxiliar para realizar el guardado final
    function ejecutarGuardado(formData) {
        $.ajax({
            url: '/addproduct',
            method: 'POST',
            data: formData,
            processData: false, // Obligatorio para FormData
            contentType: false, // Obligatorio para FormData
            dataType: 'JSON',
            beforeSend: function() {
                $("button[type=submit]").attr('disabled', 'true').html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            },
            success: function(response) {
                Swal.fire({
                    title: 'Éxito',
                    text: 'Producto guardado correctamente',
                    icon: 'success',
                    timer: 2000
                }).then(() => {
                    window.location = '/consultaproducto';
                });
            },
            error: function(request) {
                $("button[type=submit]").removeAttr('disabled').text('Guardar');
                let mensaje = (request.responseJSON) ? request.responseJSON.message : "Error al procesar la solicitud";
                Swal.fire('Error!', mensaje, 'error');
            }
        });
    }
});