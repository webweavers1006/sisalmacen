# Guía de Instalación — Sisalmacen en macOS

> **Framework:** CodeIgniter 4.0.3 | **PHP requerido:** 7.2 – 7.4 | **Servidor:** Nginx | **DB:** MySQL

---

## 📋 Requisitos previos

| Componente | Versión / Nota |
|------------|----------------|
| PHP | **7.4** (CI 4.0.3 no compatible con PHP 8.x) |
| MySQL | 5.7+ (probado con MySQL 9.6, funciona) |
| Nginx | Se instala en el paso 4 (`brew install nginx`) |
| Composer | 2.x (**manual**, no por brew) |
| Homebrew | Ya instalado |
| Git | Ya instalado (viene con macOS) |

---

## 0. Clonar el proyecto

```bash
cd ~/Documents/GitHub
git clone <repo-url> sisalmacen
cd sisalmacen
```

> Si ya tienes el proyecto, ubícate en la carpeta raíz y asegúrate de estar en la rama correcta:
> ```bash
> git pull origin main
> ```

---

## 1. Instalar PHP 7.4

PHP 7.4 ya no está en Homebrew core (EOL desde 2022). Se instala desde un tap externo:

```bash
brew tap shivammathur/php
brew install shivammathur/php/php@7.4
```

Agregar al PATH (⚠️ **importante**: debe estar antes que cualquier otro PHP):

```bash
echo 'export PATH="/opt/homebrew/opt/php@7.4/bin:$PATH"' >> ~/.zshrc
echo 'export PATH="/opt/homebrew/opt/php@7.4/sbin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

Verificar:
```bash
php -v                          # Debe mostrar PHP 7.4.33
php -m | grep -E "curl|intl|json|mbstring|mysqlnd|xml|gd|zip|pdo"
```

> Las extensiones vienen incluidas en la instalación del tap. No hace falta instalar extensiones por separado.

---

## 2. Instalar MySQL

```bash
brew install mysql
brew services start mysql
```

MySQL se instala sin contraseña root por defecto. Para asegurarlo (opcional):

```bash
mysql_secure_installation
```

---

## 3. Instalar Composer (manual, no por brew)

⚠️ **No usar `brew install composer`** porque depende de PHP 8.x y entra en conflicto con PHP 7.4.

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /opt/homebrew/bin/composer
composer --version
```

> En Mac Apple Silicon el binario va en `/opt/homebrew/bin/`, no en `/usr/local/bin/`.

---

## 4. Instalar Nginx

```bash
brew install nginx
brew services start nginx
```

Verificar:
```bash
nginx -v
# Debe mostrar: nginx version: x.x.x
```

> Si ya lo tienes instalado, solo asegúrate de que esté corriendo: `brew services list | grep nginx`

---

## 5. Dependencias del proyecto (vendor)

El proyecto **ya incluye la carpeta `vendor/`** con todas las dependencias instaladas. No es necesario ejecutar `composer install`.

Si por alguna razón necesitas reinstalar, ten en cuenta:
- El paquete `phpexcel/phpexcel` en `composer.json` apunta a un repositorio eliminado (404 en GitHub).
- El proyecto tiene PHPExcel incluido localmente en la carpeta `PHPExcel/`.
- Para reinstalar desde cero: remueve `"phpexcel/phpexcel": "*"` de `composer.json` y de `composer.lock`.

---

## 6. Configurar `.env`

```bash
cp env .env
nano .env
```

Contenido mínimo:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://sisalmacen.local/'

# Base de datos
database.default.hostname = 127.0.0.1
database.default.database = sisalmacen
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

> En macOS con brew, MySQL se instala sin contraseña root. Si configuraste una, ponla en `database.default.password`.

---

## 7. Crear base de datos e importar el dump

```bash
# Crear la base de datos
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sisalmacen CHARACTER SET utf8 COLLATE utf8_general_ci;"

# Importar el dump (estructura + datos mínimos iniciales)
mysql -u root sisalmacen < sisalmacen.sql

# Verificar tablas
mysql -u root -e "USE sisalmacen; SHOW TABLES;"
```

Tablas que se crean (22 en total):

| sta_almacen_entradas | sta_almacen_salidas | sta_categoria_producto |
| sta_dep_dir | sta_departamentos | sta_detalles_ordenes |
| sta_detalles_pre_requerimientos | sta_detalles_preordenes | sta_detalles_requerimientos |
| sta_direcciones | sta_entradas_detalles | sta_existencias |
| sta_log | sta_ordenes | sta_pre_requerimientos |
| sta_preordenes | sta_productos | sta_proveedores |
| sta_requerimientos | sta_roles | sta_status |
| sta_usuarios | | |

> El proyecto **no tiene migraciones** — la carpeta `app/Database/Migrations/` solo contiene `.gitkeep`. Todo el esquema viene del dump `sisalmacen.sql`.

### 🔑 Credenciales por defecto

| Campo | Valor |
|-------|-------|
| Email | `admin@sisalmacen.saime.gob.ve` |
| Password | `s4im3Deploy` |
| Rol | Soporte (acceso total) |

### 🧹 Limpiar la base de datos

Si necesitas reiniciar la BD a su estado original (sin transacciones, solo datos mínimos):

```bash
mysql -u root sisalmacen < limpiar_bd.sql
```

Esto borra todas las entradas, salidas, productos, existencias, usuarios (excepto el admin) y deja solo los catálogos base.

---

## 8. Crear carpetas writable y permisos

CodeIgniter 4 necesita estas carpetas con permisos de escritura:

```bash
cd ~/Documents/GitHub/sisalmacen-master

# Crear carpetas faltantes (uploads ya existe)
mkdir -p writable/cache
mkdir -p writable/session
mkdir -p writable/logs
mkdir -p writable/debugbar

# Permisos (777 para desarrollo local)
chmod -R 777 writable
```

Verificar:
```bash
ls -la writable/
# Deben aparecer: cache, debugbar, logs, session, uploads
```

---

## 9. Configurar Nginx

Crear archivo de sitio virtual:

```bash
nano /opt/homebrew/etc/nginx/servers/sisalmacen.conf
```

```nginx
server {
    listen 80;
    server_name sisalmacen.local;

    root /Users/zireael/Documents/GitHub/sisalmacen-master/public;
    index index.php index.html;

    access_log /opt/homebrew/var/log/nginx/sisalmacen_access.log;
    error_log  /opt/homebrew/var/log/nginx/sisalmacen_error.log;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }

    location ~ /writable {
        deny all;
    }
}
```

---

## 10. Iniciar servicios

```bash
# Iniciar PHP-FPM 7.4
brew services start php@7.4

# Verificar que esté en puerto 9000
lsof -i :9000

# Reiniciar Nginx
brew services restart nginx
nginx -t
```

---

## 11. Agregar dominio local

```bash
sudo nano /etc/hosts
```

Agregar:
```
127.0.0.1   sisalmacen.local
```

---

## 12. Probar

Abrir en el navegador: **http://sisalmacen.local**

Si ves el login, ¡instalación completa!

---

## 🔧 Solución de problemas (basado en experiencia real)

| Error | Causa | Solución |
|-------|-------|----------|
| **HTTP 500: "Cache unable to write to writable/cache/"** | Falta la carpeta `writable/cache/` o no tiene permisos | `mkdir -p writable/cache && chmod -R 777 writable` |
| **HTTP 500: "Table 'sisalmacen.sta_log' doesn't exist"** | BD creada pero sin tablas | `mysql -u root sisalmacen < sisalmacen.sql` |
| **502 Bad Gateway** | PHP-FPM no está corriendo | `brew services restart php@7.4` |
| **404 en rutas** | Nginx no está aplicando el rewrite | Verifica `try_files` en la config |
| **Composer pide PHP 8.x** | Instalaste composer vía brew | Desinstálalo y usa instalación manual |
| **Error "phpexcel/phpexcel" 404** | El repo fue eliminado de GitHub | No uses `composer install`, vendor ya está listo |
| **Error "php: command not found"** | PATH no incluye PHP 7.4 | Agrega `/opt/homebrew/opt/php@7.4/bin` al PATH |
| **MySQL no arranca** | Conflicto con otra versión | `brew services list \| grep mysql` y verifica |
| **ErrorException: "Trying to access array offset on value of type null"** | CI 4.0.3 + PHP 7.4: acceso a índice de array sobre resultado null de base de datos | Ver sección [Compatibilidad PHP 7.4](#-compatibilidad-php-74) abajo |

---

## ⚠️ Compatibilidad PHP 7.4

CodeIgniter 4.0.3 fue lanzado antes de PHP 8.0 y **funciona solo con PHP 7.4**. Sin embargo, PHP 7.4 es más estricto que versiones anteriores al acceder a índices de arrays sobre valores `null`.

### Error común

```
ErrorException: Trying to access array offset on value of type null
```

Este error aparece cuando una consulta a la base de datos no encuentra resultados y el código intenta acceder directamente al índice del array:

```php
// ❌ ROMPE en PHP 7.4 si no hay resultados
return $query->getRowArray()['campo'];

// ✅ CORRECTO
$row = $query->getRowArray();
return $row ? $row['campo'] : null;
```

### Archivos afectados y ya corregidos

| Archivo | Método / línea |
|---------|---------------|
| `app/Models/Almacen_model.php` | `obtenerPresentacionProd()`, `obtenerUnidadesSolicitadas()`, `getLastID()` |
| `app/Models/BaseModel.php` | `actualizaExistencias()` |
| `app/Models/Solicitudes_model.php` | `findItemPreorden()` |
| `app/Models/Productos_model.php` | `getNextCodbar()` |
| `app/Models/Departamento.php` | `get_id_by_nom()` |
| `app/Controllers/Almacen.php` | `cargarDespacho()` |

Si aparecen nuevos errores similares en otros módulos, aplica el mismo patrón de fix.

---

## 📁 Estructura del proyecto

```
sisalmacen-master/
├── app/                # Código de la aplicación
│   ├── Config/         # App.php, Database.php, Paths.php, etc.
│   ├── Controllers/    # Controladores
│   ├── Models/         # Modelos
│   └── Views/          # Vistas
├── public/             # 🎯 Document root de Nginx
│   └── index.php       # Front controller
├── system/             # CodeIgniter 4.0.3
├── vendor/             # Dependencias (ya instaladas)
├── PHPExcel/           # PHPExcel incluido localmente (el paquete online está muerto)
├── writable/           # Archivos generados (777)
│   ├── cache/          # Caché del sistema
│   ├── session/        # Sesiones PHP
│   ├── logs/           # Logs
│   ├── debugbar/       # Barra de depuración
│   └── uploads/        # Archivos subidos
├── .env                # Configuración de entorno (creado desde env)
├── sisalmacen.sql      # Dump de la base de datos (estructura + datos mínimos)
├── limpiar_bd.sql      # Script para reiniciar la BD a estado original
└── spark               # CLI de CodeIgniter
```

---

## 🔄 Comandos Git útiles

```bash
# Ver estado del proyecto
git status

# Ver historial de cambios
git log --oneline -10

# Deshacer el último commit (manteniendo los cambios)
git reset --soft HEAD~1

# Deshacer cambios locales en un archivo
git checkout -- nombre-archivo

# Actualizar desde el repositorio remoto
git pull origin main

# Crear una rama para pruebas
git checkout -b prueba
```
