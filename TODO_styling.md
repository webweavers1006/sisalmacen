# PDF Label Styling Enhancement

**Status**: 🔄 Pending

**Feedback**: "Cat Cod Marca Stock" labels should be UPPERCASE and more prominent than values.

**Current** (public/custom/js/almacen/existencias.js - crearInfoStack):
```
{ text: 'Cat: ', bold: true, color: '#718096' }  // Gray
{ text: 'Cod: ', bold: true, color: '#718096' }
{ text: 'Marca: ', bold: true, color: '#718096' }
{ text: 'Stock: ', bold: true, color: '#2d3748' } // Darker
```

**Plan**:
Edit `crearInfoStack()` function:
```
{ text: 'CAT: ', bold: true, color: '#2d3748', fontSize: 7.2 }  // Dark, larger
{ text: 'COD: ', bold: true, color: '#2d3748', fontSize: 7.2 }
{ text: 'MARCA: ', bold: true, color: '#2d3748', fontSize: 7.2 }
{ text: 'STOCK: ', bold: true, color: '#2d3748', fontSize: 7.2 }
```

**Next**: Confirm plan → Edit JS file → Test PDF → Complete
