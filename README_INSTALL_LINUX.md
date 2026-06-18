# Guía de Instalación — Sisalmacen en Linux (Ubuntu/Debian)

> **Framework:** CodeIgniter 4.0.3 | **PHP requerido:** 7.2 – 7.4 | **Servidor:** Nginx | **DB:** MySQL

---

## 📋 Requisitos previos

| Componente | Versión / Nota |
|------------|----------------|
| PHP | **7.4** (CI 4.0.3 no compatible con PHP 8.x) |
| MySQL / MariaDB | 5.7+ |
| Nginx | ≥ 1.18 |
| Composer | 2.x |
| Sistema | Ubuntu 20.04/22.04, Debian 11/12 |
| Git | Requerido para clonar el proyecto |

---

## 0. Clonar el proyecto

```bash
cd /var/www
sudo git clone <repo-url> sisalmacen
cd sisalmacen
```

> Si ya tienes el proyecto, ubícate en la carpeta raíz y actualiza:
> ```bash
> cd /var/www/sisalmacen
> sudo git pull origin main
> ```

---

## 1. Agregar repositorio de PHP 7.4

PHP 7.4 está EOL y no viene en los repositorios de Ubuntu 22.04+. Usamos el PPA de Ondřej Surý:

```bash
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
```

---

## 2. Instalar PHP 7.4 y extensiones

```bash
sudo apt install -y php7.4 php7.4-fpm php7.4-cli \
  php7.4-curl php7.4-intl php7.4-json php7.4-mbstring \
  php7.4-mysql php7.4-xml php7.4-gd php7.4-zip unzip curl
```

Verificar:
```bash
php -v                          # Debe mostrar PHP 7.4.x
php -m | grep -E "curl|intl|json|mbstring|mysqlnd|xml|gd|zip|pdo"
```

---

## 3. Instalar Nginx

```bash
sudo apt install -y nginx
sudo systemctl enable nginx
sudo systemctl start nginx
```

---

## 4. Instalar MySQL

```bash
sudo apt install -y mysql-server
sudo mysql_secure_installation
sudo systemctl enable mysql
sudo systemctl start mysql
```

---

## 5. Instalar Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

---

## 6. Ubicar el proyecto

```bash
sudo mkdir -p /var/www/sisalmacen
```

Copiar los archivos del proyecto a `/var/www/sisalmacen` (rsync, scp, git clone, etc.).

```bash
cd /var/www/sisalmacen
```

---

## 7. Dependencias del proyecto (vendor)

El proyecto **ya incluye la carpeta `vendor/`** con todas las dependencias instaladas. No es necesario ejecutar `composer install`.

Si por alguna razón necesitas reinstalar, ten en cuenta:
- El paquete `phpexcel/phpexcel` en `composer.json` apunta a un repositorio eliminado (404 en GitHub).
- El proyecto tiene PHPExcel incluido localmente en la carpeta `PHPExcel/`.
- Para reinstalar desde cero: remueve `"phpexcel/phpexcel": "*"` de `composer.json` y de `composer.lock`, luego ejecuta `composer install`.

---

## 8. Configurar `.env`

```bash
cp env .env
nano .env
```

Contenido mínimo:

```ini
CI_ENVIRONMENT = production
app.baseURL = 'https://tudominio.com/'

# Base de datos
database.default.hostname = 127.0.0.1
database.default.database = sisalmacen
database.default.username = sisalmacen
database.default.password = TU_PASSWORD_SEGURO
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

---

## 9. Crear base de datos e importar el dump

```bash
# Crear la base de datos
sudo mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS sisalmacen CHARACTER SET utf8 COLLATE utf8_general_ci;"

# Crear usuario dedicado (recomendado)
sudo mysql -u root -p -e "CREATE USER 'sisalmacen'@'localhost' IDENTIFIED BY 'TU_PASSWORD_SEGURO';"
sudo mysql -u root -p -e "GRANT ALL PRIVILEGES ON sisalmacen.* TO 'sisalmacen'@'localhost';"
sudo mysql -u root -p -e "FLUSH PRIVILEGES;"

# Importar el dump (estructura + datos mínimos iniciales)
sudo mysql -u root -p sisalmacen < sisalmacen.sql

# Verificar tablas
sudo mysql -u root -p -e "USE sisalmacen; SHOW TABLES;"
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
sudo mysql -u root -p sisalmacen < limpiar_bd.sql
```

Esto borra todas las entradas, salidas, productos, existencias, usuarios (excepto el admin) y deja solo los catálogos base.

---

## 10. Crear carpetas writable y permisos

CodeIgniter 4 necesita estas carpetas con permisos de escritura:

```bash
cd /var/www/sisalmacen

# Crear carpetas faltantes (uploads ya existe)
sudo mkdir -p writable/cache
sudo mkdir -p writable/session
sudo mkdir -p writable/logs
sudo mkdir -p writable/debugbar

# Propietario y permisos
sudo chown -R www-data:www-data /var/www/sisalmacen
sudo chmod -R 755 /var/www/sisalmacen
sudo chmod -R 777 /var/www/sisalmacen/writable
```

Verificar:
```bash
ls -la /var/www/sisalmacen/writable/
# Deben aparecer: cache, debugbar, logs, session, uploads
```

---

## 11. Configurar Nginx

Crear archivo de sitio virtual:

```bash
sudo nano /etc/nginx/sites-available/sisalmacen
```

```nginx
server {
    listen 80;
    server_name tudominio.com www.tudominio.com;

    root /var/www/sisalmacen/public;
    index index.php index.html;

    access_log /var/log/nginx/sisalmacen_access.log;
    error_log  /var/log/nginx/sisalmacen_error.log;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        fastcgi_pass   unix:/var/run/php/php7.4-fpm.sock;
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

Activar el sitio:

```bash
sudo ln -s /etc/nginx/sites-available/sisalmacen /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 12. Configurar PHP-FPM 7.4

```bash
sudo nano /etc/php/7.4/fpm/pool.d/www.conf
```

Asegúrate de:
```ini
user = www-data
group = www-data
listen = /var/run/php/php7.4-fpm.sock
listen.owner = www-data
listen.group = www-data
```

Reiniciar:
```bash
sudo systemctl restart php7.4-fpm
sudo systemctl enable php7.4-fpm
```

---

## 13. Firewall (si UFW está activo)

```bash
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
```

---

## 14. SSL con Certbot (producción)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d tudominio.com -d www.tudominio.com
```

---

## 15. Probar

Abrir en el navegador: **http://tudominio.com**

Si ves el login, ¡instalación completa!

---

## 🔧 Solución de problemas

| Error | Causa | Solución |
|-------|-------|----------|
| **HTTP 500: "Cache unable to write to writable/cache/"** | Falta la carpeta o permisos incorrectos | `sudo mkdir -p writable/cache && sudo chmod -R 777 writable` |
| **HTTP 500: "Table 'sisalmacen.sta_log' doesn't exist"** | BD creada pero sin tablas | `sudo mysql -u root -p sisalmacen < sisalmacen.sql` |
| **502 Bad Gateway** | PHP-FPM caído o socket incorrecto | `sudo systemctl status php7.4-fpm` |
| **403 Forbidden** | Permisos de archivos incorrectos | `sudo chown -R www-data:www-data /var/www/sisalmacen` |
| **404 en rutas** | Nginx `try_files` no funciona | Verifica config en `/etc/nginx/sites-enabled/` |
| **Error "phpexcel/phpexcel" 404** | El repo fue eliminado de GitHub | No uses `composer install`, vendor ya está listo |
| **Error extensión PHP** | Falta alguna extensión | `sudo apt install php7.4-{curl,intl,mbstring,mysql,xml,gd,zip}` |
| **Error "writable" no escribible** | Permisos incorrectos | `sudo chmod -R 777 /var/www/sisalmacen/writable` |
| **ErrorException: "Trying to access array offset on value of type null"** | CI 4.0.3 + PHP 7.4: acceso a índice de array sobre resultado null de BD | Ver sección [Compatibilidad PHP 7.4](#-compatibilidad-php-74) abajo |

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

Lo mismo aplica para `getRow()->propiedad`:

```php
// ❌ ROMPE
return $query->getRow()->campo;

// ✅ CORRECTO
$row = $query->getRow();
return $row ? $row->campo : null;
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
/var/www/sisalmacen/
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

---

## ⚠️ Nota sobre PHP 7.4 EOL

PHP 7.4 llegó a su fin de vida (EOL) el 28 de noviembre de 2022. Ya no recibe parches de seguridad. Se recomienda **migrar el proyecto a CodeIgniter 4.4+** (compatible con PHP 8.1/8.2) tan pronto como sea posible. Este README usa PHP 7.4 solo porque CI 4.0.3 no funciona correctamente con PHP 8.x.
