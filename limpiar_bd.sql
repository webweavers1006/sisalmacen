-- ============================================
-- SISALMACEN - Limpieza y datos iniciales
-- Deja la BD lista para nuevo proyecto
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Limpiar tablas transaccionales
TRUNCATE TABLE sta_log;
TRUNCATE TABLE sta_detalles_ordenes;
TRUNCATE TABLE sta_detalles_preordenes;
TRUNCATE TABLE sta_detalles_pre_requerimientos;
TRUNCATE TABLE sta_detalles_requerimientos;
TRUNCATE TABLE sta_entradas_detalles;

-- 2. Limpiar encabezados
TRUNCATE TABLE sta_almacen_salidas;
TRUNCATE TABLE sta_ordenes;
TRUNCATE TABLE sta_preordenes;
TRUNCATE TABLE sta_pre_requerimientos;
TRUNCATE TABLE sta_requerimientos;
TRUNCATE TABLE sta_almacen_entradas;

-- 3. Limpiar productos e inventario
TRUNCATE TABLE sta_existencias;
TRUNCATE TABLE sta_productos;
TRUNCATE TABLE sta_proveedores;

-- 4. Limpiar usuarios y estructura organizacional
TRUNCATE TABLE sta_dep_dir;
TRUNCATE TABLE sta_usuarios;
TRUNCATE TABLE sta_departamentos;
TRUNCATE TABLE sta_direcciones;

-- 5. Mantener catálogos base (NO se tocan)
-- sta_roles        → 4 registros (Soporte, Administrador, Almacenista, Usuario)
-- sta_status       → 5 registros (En Tramite, Aprobado, Despachado, etc.)
-- sta_categoria_producto → 2 registros (PRODUCTOS, BIENES)

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- DATOS MÍNIMOS INICIALES
-- ============================================

-- Estructura organizacional básica
INSERT INTO sta_departamentos (deptid, depnom) VALUES (1, 'General');
INSERT INTO sta_direcciones (dirid, dirnom) VALUES (1, 'General');
INSERT INTO sta_dep_dir (depid, dirid) VALUES (1, 1);

-- Usuario administrador inicial
-- Email: admin@sisalmacen.saime.gob.ve
-- Password: s4im3Deploy
INSERT INTO sta_usuarios (userid, usupnom, ususnom, usupape, ususape, usuemail, usupass, deptid, idrol, borrado)
VALUES (1, 'Admin', 'Admin', 'Sistema', 'Sistema', 'admin@sisalmacen.saime.gob.ve', '$2y$10$BrKtsPoYq/oc5RDNF/iW4O9jipjPSx/0JbbqMSpbJrHzWOlCm4XLC', 1, 1, 0);

-- Proveedor genérico
INSERT INTO sta_proveedores (idprov, nomprov, numrif, direccprov, telef1, telef2, email)
VALUES (1, 'Saime', 'G200088893', 'Sin dirección', '0000-0000000', '0000-0000000', 'proveedor@correo.com');

-- Productos vacíos — se cargarán desde Excel con el módulo de importación
-- No se insertan productos, el usuario los creará según su necesidad
