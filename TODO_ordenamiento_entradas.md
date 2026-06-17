# TODO: Corregir ordenamiento tabla entradas

## Plan aprobado por usuario

**Estado: En progreso**

## Pasos:
- [x] Analizar archivos relevantes (Controller, Model, View, JS)
- [x] Confirmar orden en Model ya es DESC por numregent
- [x] Leer public/custom/js/core.js → Inicializa TODAS .tabla sin order (default ASC col 0)
- [x] Editar app/Views/almacen/entradas/content.php - Agregar DataTables config con order: [[0, 'desc']] ✓
- [x] Probar en http://sisalmacen.com/entradas → Recarga página para verificar
- [x] Verificar orden (registros nuevos primero) → Tabla ahora ordena correctamente DESC por Nº Registro
- [x] Marcar como completado y attempt_completion ✓

**CORRECCIONES APLICADAS POR ERRORES:**

- Movido script de content.php → footer.php (despues jQuery)
- Agregado ID="entradas_table" para selector especifico
- Limpiado encoding y caracteres especiales

**¡TAREA COMPLETADA!**

**Columna de orden: numregent DESC (Nº Registro, más nuevos primero)**
