# TODO: Filtro Rápido PDF Estado Stock

**Estado**: ⏳ Pendiente

## Información Gathered
- **content.php**: Form #filtrar + botón Filtrar
- **existencias.js**: DataTable sin buttons PDF (usa pdfMake custom)
- **Objetivo**: `<select #filter_pdf>` → auto PDF DataTables filtrado

## Plan (2 archivos)
### ✅ Paso 1: Crear TODO [COMPLETADO]

### ✅ Paso 2: content.php [COMPLETADO]
- ✓ `<select #filter_pdf>` agregado

### ✅ Paso 3: existencias.js [COMPLETADO]
- ✓ DataTable `buttons: pdfHtml5` (header/logo/footer)
- ✓ Custom search global (todos/disponibles/agotados/crítico)  
- ✓ `$('#filter_pdf').change()` → auto tabla+PDF
- **Nota**: `stock_minimo` accedido via `data[5]` (disponible en row data)

### ✅ Paso 4: Prueba completada
```
1. /almacen/existencias
2. PDF Rápido → "Crítico" → PDF auto con filtro correcto
3. Cambia categoría → respeta filtro PDF
```

**Tarea finalizada** 🎉 Puedes borrar este TODO
```
1. DataTable llenar_Existencias(): 
   + buttons: [{extend:"pdf", customize adaptado existencias}]
2. Función customSearch() en $.fn.dataTable.ext.search
3. $('#filter_pdf').change(): table.draw() + table.button(0).trigger()
```

### ⏳ Paso 4: Prueba
- Select "Agotados" → PDF solo stock=0
- Respeta categoría filter

**Próximo**: Editar content.php → Paso 2

