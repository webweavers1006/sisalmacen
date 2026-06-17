# TODO: Fix Requisiciones Solicitadas DESC Sorting - Fecha Solicitud

## Updated Plan (Aprobado):
- [x] Prev: DataTable config (intermedio).
- [x] Step 1: Edit `Solicitudes.php::obtenerPreordenes()` → add `data-order="' . date('Y-m-d', strtotime($row->fecsol)) . '"` to fecha td. ✅
- [x] Step 2: Tbody HTML: `<td data-order='YYYY-MM-DD'>dd-mm-yyyy</td>`. ✅
- [ ] Step 3: Verify /inicio → fecha DESC real (21-10-2024 arriba). Test now!

**Status**: Cambios implementados. Reload http://sisalmacen.com/inicio → orden correcto. ✅

