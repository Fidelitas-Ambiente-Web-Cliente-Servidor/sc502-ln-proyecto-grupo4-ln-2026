<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Mis Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/beneficiario.css">
    <script src="public/js/beneficiario.js"></script>
</head>

<body>

    <button class="btn-sidebar" id="btnSidebar">☰</button>

    <div class="layout">

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <h2 class="logo-texto">AlimenTICO <img src="../img/donacion-de-alimentos.png" alt="logo" height="40px"></h2>
                <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
            </div>
            <nav class="sidebar-nav">
                <a href="beneficiario-panel.html" class="sidebar-link">Donaciones Disponibles</a>
                <a href="beneficiario-reservas.html" class="sidebar-link activo">Mis Reservas</a>
                <a href="beneficiario-perfil.html" class="sidebar-link">Mi Perfil</a>
                <a href="../login.html" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="panel-contenido">

            <h1 class="titulo-panel">Mis Reservas</h1>

            <div id="mensaje"></div>

            <div class="tabs-reservas">
                <button class="tab-reserva" id="tabActivas">Activas</button>
                <button class="tab-reserva" id="tabConfirmadas">Confirmadas</button>
                <button class="tab-reserva" id="tabCanceladas">Canceladas</button>
            </div>

            <div id="seccionActivas">

                <div class="reserva-card" data-estado="activa">
                    <div class="reserva-card-header">
                        <div>
                            <h5 class="reserva-nombre">Arroz con pollo</h5>
                            <span class="reserva-estado estado-activa">Pendiente</span>
                        </div>
                        <span class="reserva-codigo">ALM-2026-001</span>
                    </div>
                    <div class="reserva-card-body">
                        <div class="reserva-campo">
                            <span class="reserva-label">Negocio</span>
                            <span>Restaurante La Casa</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Fecha</span>
                            <span>19/03/2026</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Hora límite</span>
                            <span>8:00 PM</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Ubicación</span>
                            <span>San José, Centro</span>
                        </div>
                    </div>
                    <div class="reserva-card-footer">
                        <button class="btn-accion" id="btnConfirmar1">Confirmar retiro</button>
                        <button class="btn-accion" id="btnCancelar1">Cancelar reserva</button>
                    </div>
                </div>

                <div class="reserva-card" data-estado="activa">
                    <div class="reserva-card-header">
                        <div>
                            <h5 class="reserva-nombre">Ensalada de frutas</h5>
                            <span class="reserva-estado estado-activa">Pendiente</span>
                        </div>
                        <span class="reserva-codigo">ALM-2026-002</span>
                    </div>
                    <div class="reserva-card-body">
                        <div class="reserva-campo">
                            <span class="reserva-label">Negocio</span>
                            <span>Supermercado La Económica</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Fecha</span>
                            <span>19/03/2026</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Hora límite</span>
                            <span>6:00 PM</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Ubicación</span>
                            <span>Alajuela, Centro</span>
                        </div>
                    </div>
                    <div class="reserva-card-footer">
                        <button class="btn-accion" id="btnConfirmar2">Confirmar retiro</button>
                        <button class="btn-accion" id="btnCancelar2">Cancelar reserva</button>
                    </div>
                </div>

            </div>

            <div id="seccionConfirmadas">

                <div class="reserva-card" data-estado="confirmada">
                    <div class="reserva-card-header">
                        <div>
                            <h5 class="reserva-nombre">Panadería variada</h5>
                            <span class="reserva-estado estado-confirmada">Confirmada</span>
                        </div>
                        <span class="reserva-codigo">ALM-2026-003</span>
                    </div>
                    <div class="reserva-card-body">
                        <div class="reserva-campo">
                            <span class="reserva-label">Negocio</span>
                            <span>Panadería San José</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Fecha</span>
                            <span>18/03/2026</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Hora de retiro</span>
                            <span>5:30 PM</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Ubicación</span>
                            <span>San José, Escazú</span>
                        </div>
                    </div>
                </div>

            </div>

            

            <div id="seccionCanceladas">

                <div class="reserva-card" data-estado="cancelada">
                    <div class="reserva-card-header">
                        <div>
                            <h5 class="reserva-nombre">Pizza</h5>
                            <span class="reserva-estado estado-cancelada">Cancelada</span>
                        </div>
                        <span class="reserva-codigo">ALM-2026-004</span>
                    </div>
                    <div class="reserva-card-body">
                        <div class="reserva-campo">
                            <span class="reserva-label">Negocio</span>
                            <span>Pizzería Don José</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Fecha</span>
                            <span>17/03/2026</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Hora límite</span>
                            <span>8:00 PM</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Ubicación</span>
                            <span>San José, Desamparados</span>
                        </div>
                    </div>
                </div>

                <div class="reserva-card" data-estado="cancelada">
                    <div class="reserva-card-header">
                        <div>
                            <h5 class="reserva-nombre">Pizza</h5>
                            <span class="reserva-estado estado-cancelada">Cancelada</span>
                        </div>
                        <span class="reserva-codigo">ALM-2026-004</span>
                    </div>
                    <div class="reserva-card-body">
                        <div class="reserva-campo">
                            <span class="reserva-label">Negocio</span>
                            <span>Pizzería Don José</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Fecha</span>
                            <span>17/03/2026</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Hora límite</span>
                            <span>8:00 PM</span>
                        </div>
                        <div class="reserva-campo">
                            <span class="reserva-label">Ubicación</span>
                            <span>San José, Desamparados</span>
                        </div>
                    </div>
                </div>
                               

            </div>

        </main>
    </div>

</body>

</html>