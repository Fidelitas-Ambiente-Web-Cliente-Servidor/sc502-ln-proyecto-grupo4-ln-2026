console.log("Bienvenidos a AlimentTICO - Restaurante");
document.addEventListener("DOMContentLoaded", function () {
    let btnSidebar = document.getElementById("btnSidebar");
    let btnCerrar = document.getElementById("btnCerrarSidebar");
    let sidebar = document.getElementById("sidebar");

    if (btnSidebar) {
        btnSidebar.addEventListener("click", function () {
            sidebar.classList.add("abierto");
        });
    }

    if (btnCerrar) {
        btnCerrar.addEventListener("click", function () {
            sidebar.classList.remove("abierto");
        });
    }
});

$(document).ready(function() {
    let formNuevaDonacion = $('#formNuevaDonacion');
    if (formNuevaDonacion.length) {
        formNuevaDonacion.on('submit', function(e) {
            e.preventDefault();
            
            let data = {
                option: 'crear_donacion',
                tipo_alimento: $('#tipo_alimento').val(),
                nombre_descripcion: $('#nombre_descripcion').val(),
                cantidad: $('#cantidad').val(),
                descripcion_adicional: $('#descripcion_adicional').val(),
                informacion_importante: $('#informacion_importante').val(),
                fecha_disponible: $('#fecha_disponible').val(),
                hora_limite: $('#hora_limite').val()
            };
            
            $.post('index.php', data, function(response) {
                let mensaje = $('#mensaje');
                if (response.response === '00') {
                    mensaje.html(response.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                    setTimeout(function() {
                        window.location.href = 'index.php?page=restaurante_donaciones';
                    }, 1500);
                } else {
                    mensaje.html(response.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
                }
            }, 'json');
        });
    }
    
    let formEditarDonacion = $('#formEditarDonacion');
    if (formEditarDonacion.length) {
        formEditarDonacion.on('submit', function(e) {
            e.preventDefault();
            
            let data = {
                option: 'editar_donacion',
                id_donacion: $('#id_donacion').val(),
                tipo_alimento: $('#tipo_alimento').val(),
                nombre_descripcion: $('#nombre_descripcion').val(),
                cantidad: $('#cantidad').val(),
                descripcion_adicional: $('#descripcion_adicional').val(),
                informacion_importante: $('#informacion_importante').val(),
                fecha_disponible: $('#fecha_disponible').val(),
                hora_limite: $('#hora_limite').val(),
                estado: $('#estado').val()
            };
            
            $.post('index.php', data, function(response) {
                let mensaje = $('#mensaje');
                if (response.response === '00') {
                    mensaje.html(response.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                    setTimeout(function() {
                        window.location.href = 'index.php?page=restaurante_donaciones';
                    }, 1500);
                } else {
                    mensaje.html(response.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
                }
            }, 'json');
        });
    }
    
    let btnConfirmarEntrega = $('#btnConfirmarEntrega');
    if (btnConfirmarEntrega.length) {
        btnConfirmarEntrega.on('click', function() {
            let id_reserva = $(this).data('id');
            let nombre = $(this).data('nombre');
            
            if (confirm('¿Confirmar que ' + nombre + ' fue entregado al beneficiario?')) {
                $.post('index.php', {
                    option: 'confirmar_entrega',
                    id_reserva: id_reserva
                }, function(response) {
                    let mensaje = $('#mensaje');
                    if (response.response === '00') {
                        mensaje.html(response.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        mensaje.html(response.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
                    }
                }, 'json');
            }
        });
    }
    
    let formPerfilRestaurante = $('#formPerfilRestaurante');
    if (formPerfilRestaurante.length) {
        
        $('.switch-dia').on('change', function() {
            let dia = $(this).attr('id').replace('switch', '');
            let inputAbre = $('#abre' + dia);
            let inputCierra = $('#cierra' + dia);
            let labelEstado = $('#estado' + dia);
            
            if ($(this).is(':checked')) {
                inputAbre.prop('disabled', false);
                inputCierra.prop('disabled', false);
                labelEstado.html('Abierto');
            } else {
                inputAbre.prop('disabled', true).val('');
                inputCierra.prop('disabled', true).val('');
                labelEstado.html('Cerrado');
            }
        });
        
        formPerfilRestaurante.on('submit', function(e) {
            e.preventDefault();
            
            let data = {
                option: 'guardar_perfil_restaurante',
                nombre_negocio: $('#nombre_negocio').val(),
                tipo_establecimiento: $('#tipo_establecimiento').val(),
                cedula_juridica: $('#cedula_juridica').val(),
                telefono: $('#telefono').val(),
                provincia: $('#provincia').val(),
                canton: $('#canton').val(),
                distrito: $('#distrito').val(),
                direccion_exacta: $('#direccion_exacta').val(),
                link_maps: $('#link_maps').val(),
                correo: $('#correo').val(),
                contrasena: $('#contrasena').val()
            };
            
            // Agregar horarios
            let dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
            for (let i = 0; i < dias.length; i++) {
                let dia = dias[i];
                let sw = $('#switch' + dia);
                if (sw.length && sw.is(':checked')) {
                    data['switch' + dia] = 'on';
                    data['abre' + dia] = $('#abre' + dia).val();
                    data['cierra' + dia] = $('#cierra' + dia).val();
                }
            }
            
            $.post('index.php', data, function(response) {
                let mensaje = $('#mensaje');
                if (response.response === '00') {
                    mensaje.html(response.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    mensaje.html(response.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
                }
            }, 'json');
        });
    }
    
    let btnEliminarPerfil = $('#btnEliminarPerfil');
    if (btnEliminarPerfil.length) {
        btnEliminarPerfil.on('click', function() {
            if (confirm('¿Estás completamente seguro de eliminar tu cuenta? Esta acción NO se puede deshacer y perderás todas tus donaciones y datos.')) {
                $.post('index.php', {
                    option: 'eliminar_cuenta_restaurante'
                }, function(response) {
                    if (response.response === '00') {
                        alert('Tu cuenta ha sido eliminada. Gracias por haber sido parte de AlimenTICO.');
                        window.location.href = 'index.php?page=login';
                    } else {
                        alert(response.message);
                    }
                }, 'json');
            }
        });
    }
    
    $(document).on('click', '.btn-eliminar-donacion', function() {
        let id = $(this).data('id');
        let nombre = $(this).data('nombre');
        
        if (confirm('¿Estás seguro de eliminar la donación "' + nombre + '"? Esta acción no se puede deshacer.')) {
            $.post('index.php', {
                option: 'eliminar_donacion',
                id_donacion: id
            }, function(response) {
                let mensaje = $('#mensaje');
                if (response.response === '00') {
                    mensaje.html(response.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    mensaje.html(response.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
                }
            }, 'json');
        }
    });
    
    let filtroEstado = $('#filtroEstado');
    if (filtroEstado.length) {
        filtroEstado.on('change', function() {
            let estado = $(this).val();
            $('#cuerpoTabla tr').each(function() {
                if (estado === '' || $(this).data('estado') === estado) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    }
    
    let inputBuscar = $('#inputBuscar');
    if (inputBuscar.length) {
        inputBuscar.on('keyup', function() {
            let texto = $(this).val().toLowerCase();
            $('#cuerpoTabla tr').each(function() {
                let nombre = $(this).find('td:first').text().toLowerCase();
                if (nombre.includes(texto)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    }
});

$(document).on('click', '.btn-completar-donacion', function() {
    let id     = $(this).data('id');
    let nombre = $(this).data('nombre');
    let fila   = $(this).closest('tr');

    if (confirm('¿Marcar "' + nombre + '" como completada?')) {
        fetch('/sc502-ln-proyecto-grupo4-ln-2026/index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ option: 'completar_donacion', id_donacion: id }).toString(),
            credentials: 'include'
        })
        .then(r => r.json())
        .then(function(response) {
            let mensaje = $('#mensaje');
            if (response.response === '00') {
                fila.attr('data-estado', 'completado');
                fila.find('.badge').removeClass('bg-warning').addClass('bg-primary').html('Completado');
                fila.find('.btn-completar-donacion').closest('td').html(
                    '<a href="index.php?page=restaurante_detalle_donacion&id=' + id + '" class="btn-tabla"><i class="bi bi-info-square-fill"></i></a>' +
                    '<button class="btn-tabla" disabled><i class="bi bi-pencil-square" style="opacity:0.5"></i></button>' +
                    '<button class="btn-tabla" disabled><i class="bi bi-trash-fill" style="opacity:0.5"></i></button>'
                );
                mensaje.html(response.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                setTimeout(function() { mensaje.hide(); }, 3000);
            } else {
                mensaje.html(response.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
            }
        })
        .catch(function() {
            $('#mensaje').html('Error de conexión').css('background-color', 'rgba(149, 24, 24, 0.758)').show();
        });
    }
});