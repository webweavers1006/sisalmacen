<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
  <script src="https://cdn.tailwindcss.com"></script>



<style>
    /* Custom styles for DataTables compatibility */
    #entradas_table tbody tr:nth-child(even) { background-color: #ebf5ff; }
    
    /* Table action buttons as blue circles w/ lupa icon */
    #entradas_table .btn, #entradas_table a.btn, #entradas_table td:last-child a {
      position: relative; /* For icon positioning */
    }
    /* Replace "detalle" text with lupa icon */
    #entradas_table td a[href*='detalle'], #entradas_table td a:contains('detalle'), #entradas_table a:has-text('detalle') {
      font-size: 0 !important; /* Hide text */
    }
    #entradas_table td a[href*='detalle']::before, #entradas_table td a:has-text('detalle')::before {
      content: ''; display: inline-block; width: 1.25rem; height: 1.25rem;
      mask: url('data:image/svg+xml,<svg fill="white" viewBox="0 0 20 20"><path d="M9 4.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 12a2 2 0 100 4 2 2 0 000-4zm0-8a8 8 0 017.14 4.58l.72 1.02A3.98 3.98 0 0119 13a3.5 3.5 0 01-7 0v-3.5a.5.5 0 00-1 0V13a5.5 5.5 0 01-5 5.5A1 1 0 016 19h1.5a.5.5 0 000-1A4 4 0 0010 14v-3.5a1.5 1.5 0 10-3 0V14a8 8 0 007.64-6.22l.75-1.07A7 7 0 1110 4V4z"/></svg>') no-repeat center; mask-size: contain; background: white;
    }
      all: unset; display: inline-flex; align-items: center; justify-content: center;
      width: 2.5rem; height: 2.5rem; background: #007bff; border-radius: 9999px;
      color: white; font-size: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: all 0.2s; cursor: pointer; text-decoration: none;
    }
    #entradas_table .btn:hover, #entradas_table td:last-child a:hover {
      background: #0056b3; box-shadow: 0 4px 8px rgba(0,0,0,0.15); transform: translateY(-1px);
    }
    #entradas_table .btn svg, #entradas_table td:last-child a svg { width: 1.25rem; height: 1.25rem; }
    
    /* Subtle sort icons in thead */
    #entradas_table thead td { position: relative; }
    #entradas_table thead td::after {
      content: ' ↕'; font-size: 0.75rem; opacity: 0.7; margin-left: 0.25rem;
    }
    #entradas_table tbody tr:nth-child(odd) { background-color: white; }
    #entradas_table tbody tr:hover { background-color: #e3f2fd !important; transition: background-color 0.2s; }
    #entradas_table th, #entradas_table td { border-bottom: 1px solid #e0e0e0 !important; }
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input { 
      border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; font-family: ui-sans-serif, system-ui; 
    }
    .dataTables_wrapper .dataTables_filter input:focus { outline: none; ring: 2px solid #3b82f6; }
    .dataTables_wrapper .paginate_button { border-radius: 0.375rem; }
  </style>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
      <div class="bg-[#3c4e5e] text-white font-bold text-lg p-4 rounded-t-xl">
        <h3 class="text-left mb-0">Historico de entradas de productos</h3>

        <div class="card-tools">
          <a class="w-12 h-12 bg-[#007bff] hover:bg-[#0056b3] rounded-full flex items-center justify-center text-white text-lg shadow-lg hover:shadow-xl transition-all duration-200 ml-auto" href="/regentrada" title="Añadir">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          </a>
        </div>
      </div>
      <div class="card-body">
<div class="overflow-x-auto">
  <table id="entradas_table" class="w-full text-center border-collapse divide-y divide-gray-200">
          <thead class="bg-[#5d7384] text-white uppercase tracking-wider text-xs leading-4">
            <tr>
              <td>Nº Registro</td>
              <td>Nº Factura</td>
              <td>Proveedor</td>
              <td>Fecha Factura</td>
              <td>Fecha Operacion</td>
              <td>Usuario</td>
              <td>Comentario</td>
              <td></td>
            </tr>
          </thead>
          <tbody id="entradas">
            <?php echo $tbody; ?>
          </tbody>
        </table>
  </div>
      </div>
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
