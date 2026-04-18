<?php require __DIR__ . '/header.php'; ?>

<?php
$msg      = $_GET['msg']      ?? '';
$msg_type = $_GET['msg_type'] ?? '';
$query    = $_GET['q']        ?? '';
$total    = count($empleados);
?>

<div class="page-header animated">
    <div>
        <span class="page-title">Empleados</span>
        <div style="font-size:.8rem; color:var(--text-muted); margin-top:3px;">Gestión de personal registrado</div>
    </div>
    <a href="index.php?action=create" class="btn btn-primary">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo empleado
    </a>
</div>

<?php if ($msg): ?>
<div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <?php if ($msg_type === 'success'): ?>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        <?php else: ?>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        <?php endif; ?>
    </svg>
    <?= htmlspecialchars($msg) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="stats-row animated-d1">
    <div class="stat-card">
        <div class="stat-icon">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
            </svg>
        </div>
        <div class="stat-value" id="counter-total">0</div>
        <div class="stat-label">Total empleados</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#E6FCF5; color:#0CA678;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <div class="stat-value" style="color:#0CA678;" id="counter-active">0</div>
        <div class="stat-label">Registros activos</div>
    </div>
</div>

<!-- Table Card -->
<div class="card animated-d2">
    <div class="toolbar">
        <div class="search-wrap">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
            </svg>
            <input
                type="text" class="search-input"
                placeholder="Buscar por nombre, apellido o DNI…"
                value="<?= htmlspecialchars($query) ?>"
                id="searchField"
            >
        </div>
        <?php if ($query): ?>
            <a href="index.php?action=index" class="btn btn-ghost btn-sm">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Limpiar
            </a>
        <?php endif; ?>
    </div>

    <div class="table-wrap" style="padding-top:12px;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($empleados)): ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding:48px 16px; color:var(--text-muted);">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" style="display:block;margin:0 auto 12px;opacity:.35">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                        <?= $query ? 'Sin resultados para "' . htmlspecialchars($query) . '"' : 'No hay empleados registrados.' ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($empleados as $emp): ?>
                <tr>
                    <td><span class="badge badge-blue"><?= $emp['id'] ?></span></td>
                    <td style="font-weight:500;"><?= htmlspecialchars($emp['nombre']) ?></td>
                    <td style="color:var(--text-muted);"><?= htmlspecialchars($emp['apellido']) ?></td>
                    <td>
                        <span style="font-family:monospace; font-size:.82rem; background:var(--bg); padding:3px 8px; border-radius:6px; color:var(--text-muted);">
                            <?= htmlspecialchars($emp['dni']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="index.php?action=edit&id=<?= $emp['id'] ?>" class="btn btn-ghost btn-sm" title="Editar">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <button class="btn btn-danger-ghost btn-sm" onclick="confirmDelete(<?= $emp['id'] ?>)" title="Eliminar">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div class="live-dot"></div>
        <?= $total ?> registro<?= $total !== 1 ? 's' : '' ?> encontrado<?= $total !== 1 ? 's' : '' ?>
        <?php if ($query): ?>
            &nbsp;·&nbsp; filtrando por "<strong><?= htmlspecialchars($query) ?></strong>"
        <?php endif; ?>
    </div>
</div>

<script>
// Animated counter
function animateCount(el, target) {
    var start = 0, duration = 700, step = target / (duration / 16);
    var timer = setInterval(function() {
        start += step;
        if (start >= target) { start = target; clearInterval(timer); }
        el.textContent = Math.floor(start);
    }, 16);
}
animateCount(document.getElementById('counter-total'),  <?= $total ?>);
animateCount(document.getElementById('counter-active'), <?= $total ?>);
</script>

<?php require __DIR__ . '/footer.php'; ?>
