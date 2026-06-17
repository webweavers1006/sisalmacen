<meta charset="utf-8">
<div class="content-wrapper">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
    
    <style>
      :root { 
        --azul-oscuro: #384c60; 
        --siac-blue: #4b647c; 
        --bg-light: #f8f9fa;
        --border-color: #d1d8e0;
      }

      .content-wrapper { min-height: 100vh; background-color: #f4f6f9; }

      .card.rounded-3 {
        border-radius: 12px !important;
        overflow: hidden;
        border: none;
        background: white;
      }

      .card-header.header-flex {
        background: var(--azul-oscuro) !important;
        color: white !important;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .container-wraper { 
        width: 95%; 
        max-width: 1400px; 
        margin: 20px auto; 
      }

      /* Estilos para la tabla */
      #table_existencias thead th {
        background: var(--siac-blue) !important;
        color: white !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 12px;
        border: none !important;
      }

      /* Selectores estilizados */
      .select-reactivo {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 6px 12px;
        outline: none;
        transition: all 0.2s;
        background-color: white;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--azul-oscuro);
        cursor: pointer;
      }

      .select-reactivo:hover { border-color: var(--siac-blue); }

      .label-filter {
        font-size: 0.75rem;
        font-weight: 800;
        color: #5d6d7e;
        margin-right: 8px;
        text-transform: uppercase;
      }

      /* Badges de Stock */
      .btnalerta { background-color: #fceae9; color: #e74c3c; border: 1px solid #f5c6cb; border-radius: 4px; padding: 2px 8px; font-weight: bold; }
      .btnsolvente { background-color: #e8f5e9; color: #27ae60; border: 1px solid #c3e6cb; border-radius: 4px; padding: 2px 8px; font-weight: bold; }
      .btncritico { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px; padding: 2px 8px; font-weight: bold; }

      /* Ajuste de botones inyectados */
      #contenedor-botones-dt .btn {
        margin-right: 5px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
      }
    </style>

    <div class="content">
        <div class="container-wraper">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-3 shadow-lg">
                        <div class="card-header header-flex">
                            <h3 class="card-title mb-0" style="font-size: 1.1rem; font-weight: 600;">
                                <i class="fas fa-boxes mr-2"></i> Control de Existencias
                            </h3>
                        </div>
                        
                        <div class="card-body p-0">
                            <div class="p-3 border-bottom bg-light">
                                <div class="d-flex align-items-center flex-wrap" style="gap: 20px;">
                                    
                                    <div class="d-flex align-items-center" style="gap: 15px;">
                                        <div class="d-flex align-items-center">
                                            <span class="label-filter">📁 CATEGORÍA:</span>
                                            <select class="select-reactivo" id="categoria" style="min-width: 220px;">
                                                <option value="0" selected disabled>Cargando...</option>
                                            </select>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <span class="label-filter">🔍 ESTADO:</span>
                                            <select id="filter_stock_type" class="select-reactivo text-primary" style="min-width: 210px;">
                                                <option value="todos">📋 Mostrar Todo</option>
                                                <option value="disponibles">✅ Óptimos (No críticos)</option>
                                                <option value="agotados">🔴 Agotados (Stock 0)</option> 
                                                <option value="critico">⚠️ Críticos (Bajo Mínimo)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="contenedor-botones-dt" class="d-flex align-items-center" style="border-left: 2px solid #dee2e6; padding-left: 15px;">
                                        </div>

                                </div>
                            </div>

                            <div class="p-3">
                                <table class="table table-hover table-sm mb-0" id="table_existencias" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>ID Item</th>
                                            <th>Marca</th>
                                            <th>Producto / Descripción</th>
                                            <th class="text-center">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div> </div> </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Asegura el alto de la pantalla
        if(document.querySelector('.content-wrapper')){
            document.querySelector('.content-wrapper').style.minHeight = '100vh';
        }
    });
</script>