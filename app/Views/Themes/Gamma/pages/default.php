<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb px-3 py-2 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>

<h2 class="mb-4">Bienvenido al DashboardX</h2>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body">
                <h6 class="text-muted">Usuarios</h6>
                <h3>1,234</h3>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 12%</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body">
                <h6 class="text-muted">Ventas</h6>
                <h3>$45,678</h3>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 8%</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body">
                <h6 class="text-muted">Pedidos</h6>
                <h3>567</h3>
                <small class="text-danger"><i class="fas fa-arrow-down"></i> 3%</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body">
                <h6 class="text-muted">Visitas</h6>
                <h3>23,456</h3>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 15%</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Gráfico de Ventas</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Aquí puedes integrar un gráfico con Chart.js o similar</p>
                <div class="chart-placeholder"
                     style="height: 300px; display: flex; align-items: center; justify-content: center;">
                    <span class="text-muted">Área de Gráfico</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tareas Pendientes</h5>
            </div>
            <div class="card-body">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="task1">
                    <label class="form-check-label" for="task1">
                        Revisar reportes mensuales
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="task2">
                    <label class="form-check-label" for="task2">
                        Actualizar base de datos
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="task3" checked>
                    <label class="form-check-label" for="task3">
                        Llamar a clientes
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>