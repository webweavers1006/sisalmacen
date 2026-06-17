<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}
/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::login');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

/*Rutas de la aplicacion*/
$routes->get('/admin', 'Home::admin');
$routes->get('/403', 'Home::forbidden');
$routes->get('/404', "Home::notFound");
$routes->get('/503', "Home::mantenimiento");
$routes->get('/inicio', 'Home::dashboard');
$routes->get('/logout', 'Login::logout');
$routes->get("/perfil/(:num)", "Usuarios::perfil/$1");
$routes->get('/forget', "Home::recuperarPass");
$routes->post('/sendEmail', "Login::sendRecoverEmail");
$routes->get('/confirmRecover/(:any)', "Login::settingNewPass/$1");
$routes->post('/changepassword', "Login::changepassword");

/*Rutas para login*/
$routes->post('/signin', 'Login::signin');
/*Rutas para usar con AJAX*/
$routes->post('/counters', 'ControlPanel::getStats');
$routes->post('/getAllData', 'ControlPanel::get_all_data');
/*Rutas del panel de control*/
$routes->resource('direcciones');
$routes->resource('departamentos');
$routes->resource('usuarios');
$routes->resource('roles');
//RUTAS PARA LAS DIRECCIONES 
$routes->get('/listar_direcciones', 'Direcciones::listar_direcciones');
//RUTAS PARA LOS DEPARTAMENTOS
$routes->get('/listar_departamentos', 'Departamentos::listar_departamentos');
//RUTAS PARA LOS ROLES
$routes->get('/listar_rol', 'Roles::listar_rol');
//RUTAS PARA LOS USUARIOS
$routes->get('/listar_Usuarios', 'Usuarios::listar_Usuarios');
$routes->POST('/reset_password', 'Usuarios::reset_password');
$routes->get('/getDepts/(:num)', 'Usuarios::getDeptDetalles/$1');
$routes->get('/adduser', 'Usuarios::addUser');
$routes->get('/edituser/(:num)', 'Usuarios::editUser/$1');
/*Rutas para el almacen */
$routes->get('/almacen', 'Almacen::index');
$routes->get('/existencias', 'Almacen::existencias');
$routes->get('/listar_existencias/(:num)', 'Almacen::listar_existencias/$1');


/*Rutas para el stock minimo */
$routes->get('/stock_minimo', 'Almacen::stock_minimo');
$routes->get('/listar_stock_minimo', 'Almacen::listar_stock_minimo/');


/*Rutas para el reporte de despachp*/
$routes->get('/reporte_despachos', 'Almacen::reporte_despachos');
$routes->get('/listar_reporte_despachos/(:any)/(:any)/(:any)', 'Almacen::listar_reporte_despachos/$1/$2/$3');



$routes->post('/buscar_producto_existencias/(:any)', 'Almacen::buscar_producto_existencias/$1');
$routes->get('/entradas', 'Almacen::entradas');
$routes->get('/regentrada', 'Almacen::registrarEntrada');
$routes->get('/despachos', 'Almacen::despachos');
$routes->get('/salidas', 'Almacen::salidas');
$routes->post('/acttabla', 'Almacen::refrescarTabla');
$routes->post('/addentrada', 'Almacen::newEntrada');
$routes->post('/adddetalle', 'Almacen::addDetalle');
$routes->get('/detalleent/(:num)', 'Almacen::detalleEntrada/$1');
$routes->post('/detalles', "Almacen::obtenerDetalles");
$routes->post('/actualizarcatalogo', "Almacen::actualizarCatalogo");
$routes->get('/importar-entradas', 'Almacen::importarEntradas');
$routes->post('/procesar-excel', 'Almacen::procesarExcel');
$routes->get('/descargar-plantilla', 'Almacen::descargarPlantilla');
/*Rutas para los productos*/
$routes->get('/regprod', 'Productos::registrar');
$routes->get('/consultaproducto', 'Productos::consutaProducto');
$routes->post('/addproduct', 'Productos::addProducto');
$routes->get('/editarproducto/(:num)', 'Productos::show/$1');

$routes->get('/listar_categoria', 'Productos::listar_categoria');



$routes->post('/buscarxcodbar', 'Productos::searchByCodbar');
/*Rutas para los proveedores*/
$routes->post('/nuevoproveedor', 'Proveedores::nuevo');
$routes->get('/consultaproveedor', 'Proveedores::consulta');
$routes->post('/detalleproveedor', 'Proveedores::detalleProveedor');
$routes->post('/buscarproveedor', 'Proveedores::buscarProveedor');
$routes->get('/newprovider', 'Home::newProvider');
$routes->post('/editarproveedor', "Proveedores::editarProveedor");
$routes->post('/reloadProveedores', "Proveedores::reloadProveedores");
/*Rutas para las solicitudes*/
$routes->get('/nuevarequisicion', 'Solicitudes::nuevaRequisicion');
$routes->post('/addpreorddet', 'Solicitudes::addDetalle');
$routes->post('/obtpreordenes', 'Solicitudes::obtenerPreordenes');
$routes->post('/obtordenes', 'Solicitudes::obtenerOrdenes');
$routes->get('/preordenesdetalle/(:num)', 'Solicitudes::preordenesdetalle/$1');
$routes->get('/ordendetalle/(:num)', 'Solicitudes::detalleOrden/$1');
$routes->get('/editarpreorden/(:num)', "Solicitudes::editarPreorden/$1");
$routes->get('/eliminarpreorden/(:num)', "Solicitudes::eliminarPreorden/$1");
$routes->post('/eliminaritem', 'Solicitudes::eliminarItemPreOrden');
$routes->get('/confirmarpreorden/(:num)/(:any)', "Solicitudes::aprobarPreorden/$1/$2");
$routes->get('/verpreorden/(:num)', "Solicitudes::verPreorden/$1");
$routes->get("/anular-solicitud", "Solicitudes::listaOrdenes");
$routes->get('/detalle-orden/(:num)', "Solicitudes::verDetalleOrden/$1");
$routes->post("/anular-orden", "Solicitudes::anularOrden");
$routes->post("/actualizarOrden", "Solicitudes::actualizarOrden");
$routes->post("/detallesPreordenes", "Solicitudes::actualizaPreorden");
//Rutas para aprobar preordenes
$routes->get('/listarequisiciones', "Solicitudes::requerimientosPorAprobar");
$routes->get('/aprobarpreorden/(:num)', "Solicitudes::apruebapreorden/$1");
$routes->get('/rechazar-orden/(:num)', "Solicitudes::rechazarOrden/$1");
$routes->post('/nuevaorden', "Solicitudes::nuevaOrden");
//Rutas para el despacho de productos
$routes->get('/verdespacho/(:num)', "Almacen::verDespacho/$1");
$routes->post('/registrarsalida', "Almacen::registrarSalida");
$routes->get('/detalledespacho/(:num)', "Almacen::detalleDespacho/$1");
$routes->get('/despachareq/(:num)', "Almacen::verSolDesReq/$1");
//Rutas para los requerimientos
$routes->resource('requerimientos');
$routes->get('/lista-requerimientos', "Requerimientos::list");
$routes->post("/borrarPreReq", "Requerimientos::deletePreReq");
$routes->post('/confirmprereq', "Requerimientos::confirmPreReq");
$routes->get('/apprereq/(:num)', "Requerimientos::confirmarPrerequerimiento/$1");
$routes->post('/newreq', "Requerimientos::registrarRequerimiento");
$routes->post('/registraDespacho', "Almacen::registrarDespacho");
$routes->post('/obtrequerimientos', "Requerimientos::obtenerRequerimientoPorUsuario");
$routes->get('/verPreReq/(:num)', "Requerimientos::verPreRequerimiento/$1");
//$routes->get('/confprereq/(:num)', "Requerimientos::confirmarPrerequerimiento/$1");
$routes->get('/confprereq/(:num)', "Requerimientos::confirmarPrerequerimiento/$1");
//Ruta para generar los reportes
$routes->get("/reportes/(:num)", "Reportes::consultaReporte/$1");

$routes->post('/consultausuario', "Reportes::consultaPorUsuario");
$routes->get('/generareporte/(:num)', "Reportes::generarReporte/$1");
$routes->post("/consultaFecha/(:num)", "Reportes::consultarPorFecha/$1");
$routes->post("/consultaSolicitud", "Reportes::consultaSolicitud");
$routes->get('/comprobanteDespacho/(:num)/(:num)', "Reportes::comprobanteDespacho/$1/$2");
$routes->get('/consolidados/(:num)', 'Home::consolidados/$1');
$routes->post('/obtenerConsolidado/(:num)', "Reportes::consultaConsolidado/$1");
////
$routes->get('/obtenerConsolidado', "Reportes::consultaConsolidado");
////

//RUTAS PARA LAS Categorias
$routes->get('/categorias', 'categoria_controllers::categorias');
$routes->get('/listar_categorias', "categoria_controllers::listar_categorias");
$routes->get('/listar_categorias_sin_filtro', "categoria_controllers::listar_categorias_sin_filtro");
$routes->post('/add_categoria', "categoria_controllers::add_categoria");
$routes->post('/editCategoria', "categoria_controllers::editCategoria");

$routes->get('/generarConsolidadoExcel/(:any)/(:any)/(:num)', "Reportes::generarConsolidadoExcel/$1/$2/$3");
$routes->post('/consultadepartamentos', "Reportes::consultaPorDepartamentos");
$routes->get('/generarExcelDepartamentos/(:any)', "Reportes::generarPorDepartamentosEx/$1");
