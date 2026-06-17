<?php
$session = session();
?>
<meta charset="utf-8">
<!-- <link rel="stylesheet" href="<php echo base_url(); ?>css/navar.css> -->
<!-- Google Font: Source Sans Pro -->
<link rel=" stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-whiFte navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a id="logout" class="nav-link" href="#">
            <i class="fas fa-user"></i>
            Cerrar Sesion
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: linear-gradient(to right, #263846, #344958, #263846);">
      <!-- Brand Logo -->
      <a href=" /inicio" class="brand-link" style="background: linear-gradient(to right, #f2f2f2, #e6e6e6, #f2f2f2);">
        <img src="<?php echo base_url(); ?>/img/logosis002.png" alt="Sistema de almacen logo" style="width:50px; height: 50px;">
        <span class="brand-text font-weight-light" style="color: black;">Sistema de Almacen</span>
      </a>


      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo base_url(); ?>/theme/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="/perfil/<?php echo $session->get('userid'); ?>" class="d-block"><?php echo $session->get('usupnom') . ' ' . $session->get('usupape'); ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="/inicio" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Tablero
                </p>
              </a>
            </li>
            <?php if ($session->get('usurol') == 1) { ?>
              <!--Panel de control-->
              <li class="nav-item">
                <a href="/admin" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Panel de Control
                  </p>
                </a>
              </li>
            <?php }
            if (($session->get('usurol') == 1 or $session->get('usurol') == 2)) {
            ?>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-toolbox"></i>
                  <p>
                    Administrador
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <!--Solicitudes-->
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="far fa-edit nav-icon"></i>
                      <p>
                        Solicitudes
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/listarequisiciones" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Requisiciones</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/lista-requerimientos" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Requerimientos</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/anular-solicitud" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Anular Solicitudes</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!--Existencias-->
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-search nav-icon"></i>
                      <p>
                        Consultas
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/existencias" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Existencias</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="/stock_minimo" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Stock Minimo</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!--Reportes-->
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-flag nav-icon"></i>
                      <p>
                        Reportes
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/reportes/4" class="nav-link">
                          <i class="fas fa-file-signature nav-icon"></i>
                          <p>Por Solicitud</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportes/6" class="nav-link">
                          <i class="far fa-chart-bar nav-icon"></i>
                          <p>Movimientos</p>
                        </a>
                      </li>
                      <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>
                            Consolidados
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="/consolidados/1" class="nav-link">
                              <i class="fas fa-file-signature nav-icon"></i>
                              <p>Entradas Salidas</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="/consolidados/2" class="nav-link">
                              <i class="far fa-chart-bar nav-icon"></i>
                              <p>Por Departamentos</p>
                            </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            <?php }
            if (($session->get('usurol') == 1 or ($session->get('usurol')) == 3)) {
            ?>
              <!--Almacen -->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-store-alt"></i>
                  <p>
                    Almacen
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <!--Registros de entradas y salidas-->
                  <li class="nav-item has-treeview">
                    <!-- <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Existencias
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a> -->
                    <li class="nav-item">
                        <a href="/stock_minimo" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Stock Minimo </p>
                        </a>
                      </li>
                    
                      <li class="nav-item">
                        <a href="/entradas" class="nav-link">
                          <i class="fas fa-arrow-left nav-icon"></i>
                          <p>Entradas</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/importar-entradas" class="nav-link">
                          <i class="fas fa-file-excel nav-icon"></i>
                          <p>Importar Entradas</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/salidas" class="nav-link">
                          <i class="fas fa-arrow-right nav-icon"></i>
                          <p>Salidas</p>
                        </a>
                      </li>
                   
                  </li>
                  <!--Productos -->
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Productos
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/regprod" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Registrar Producto</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/consultaproducto" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Consultar Producto</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!--Proveedores -->
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Proveedores
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/newprovider" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Registrar Proveedor</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/consultaproveedor" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Consultar Proveedor</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!--Reportes-->
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Reportes
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/reportes/4" class="nav-link">
                          <i class="fas fa-file-signature nav-icon"></i>
                          <p>Por Solicitud</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportes/6" class="nav-link">
                          <i class="far fa-chart-bar nav-icon"></i>
                          <p>Movimientos</p>
                        </a>
                      </li>
                      <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>
                            Consolidados
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="/consolidados/1" class="nav-link">
                              <i class="fas fa-file-signature nav-icon"></i>
                              <p>Entradas Salidas</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="/consolidados/2" class="nav-link">
                              <i class="far fa-chart-bar nav-icon"></i>
                              <p>Por Departamentos</p>
                            </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <!--Despachos-->
                  <li class="nav-item">
                    <a href="/despachos" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Despachos</p>
                    </a>
                  </li>
                  <!--Existencias-->
                  <li class="nav-item">
                    <a href="/existencias" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Existencias</p>
                    </a>
                  </li>
                  <li class="nav-item">
                        <a href="/stock_minimo" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Stock Minimo</p>
                        </a>
                      </li>
                   <!--Existencias-->
                   <li class="nav-item">
                    <a href="/reporte_despachos" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Notas de Entregas </p>
                    </a>
                  </li>

                </ul>
              </li>

          <!--Mantenimiento-->
        <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>
                Mantenimiento
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/categorias" class="nav-link">
                    <i class="fas fa-file-medical-alt nav-icon"></i>
                    <p>Categorias</p>
                  </a>
                </li>
                
              </ul>
            </li>

            <?php } ?>
            <!--Usuario-->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>
                  Solicitudes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/nuevarequisicion" class="nav-link">
                    <i class="fas fa-file-medical-alt nav-icon"></i>
                    <p>Requisiciones</p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a href="/requerimientos" class="nav-link">
                    <i class="fas fa-list-ul nav-icon"></i>
                    <p>Requerimientos</p>
                  </a>
                </li> -->
              </ul>
            </li>
           





            <li class="nav-item">
              <a href="/perfil/<?php echo $session->get('userid'); ?>" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Perfil de usuario
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>