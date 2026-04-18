<?php require __DIR__ . '/header.php'; ?>

<div class="page-header animated">
    <div>
        <span class="page-title">Editar Empleado</span>
        <div style="font-size:.8rem; color:var(--text-muted); margin-top:3px;">Modificando registro <strong>#<?= $empleado['id'] ?></strong></div>
    </div>
    <a href="index.php?action=index" class="btn btn-ghost">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver
    </a>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-error animated">
    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <div><?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
</div>
<?php endif; ?>

<div class="card form-card animated-d1">
    <form method="POST" action="index.php?action=update" id="editForm">
        <input type="hidden" name="id" value="<?= $empleado['id'] ?>">
        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="<?= htmlspecialchars($_POST['nombre'] ?? $empleado['nombre']) ?>"
                    required autofocus>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control"
                    value="<?= htmlspecialchars($_POST['apellido'] ?? $empleado['apellido']) ?>"
                    required>
            </div>
        </div>
        <div class="form-group">
            <label for="dni">DNI</label>
            <input type="text" id="dni" name="dni" class="form-control"
                value="<?= htmlspecialchars($_POST['dni'] ?? $empleado['dni']) ?>"
                maxlength="12" pattern="[0-9]+" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar cambios
            </button>
            <a href="index.php?action=index" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.getElementById('editForm').addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    btn.style.opacity = '.7';
    btn.style.pointerEvents = 'none';
    btn.innerHTML = '<svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="animation:spin .7s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Guardando…';
});
</script>
<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<?php require __DIR__ . '/footer.php'; ?>
