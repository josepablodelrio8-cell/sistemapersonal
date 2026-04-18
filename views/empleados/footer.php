</main>

<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3>¿Eliminar empleado?</h3>
        <p>Esta acción es irreversible. El registro será eliminado permanentemente de la base de datos.</p>
        <div class="modal-actions">
            <button class="btn btn-ghost" onclick="closeModal()">Cancelar</button>
            <a href="#" id="confirmDelete" class="btn btn-danger-ghost">Sí, eliminar</a>
        </div>
    </div>
</div>

<!-- Toast notification -->
<div id="toast" style="
    position:fixed; bottom:28px; right:28px; z-index:300;
    background:#1A1D23; color:white; padding:12px 20px;
    border-radius:10px; font-size:.85rem; font-weight:500;
    box-shadow:0 8px 24px rgba(0,0,0,.2);
    display:flex; align-items:center; gap:10px;
    transform:translateY(80px); opacity:0;
    transition:transform .3s cubic-bezier(.34,1.56,.64,1), opacity .3s ease;
    pointer-events:none;
"></div>

<script>
function confirmDelete(id) {
    document.getElementById('confirmDelete').href = 'index.php?action=delete&id=' + id;
    document.getElementById('deleteModal').classList.add('active');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// Auto-dismiss alerts after 4s
document.querySelectorAll('.alert').forEach(function(alert) {
    setTimeout(function() {
        alert.style.transition = 'opacity .4s ease, transform .4s ease, max-height .4s ease, margin .4s ease, padding .4s ease';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-6px)';
        alert.style.maxHeight = '0';
        alert.style.marginBottom = '0';
        alert.style.padding = '0';
        setTimeout(function() { alert.remove(); }, 420);
    }, 4000);
});

// Smooth search debounce
var searchInput = document.querySelector('.search-input');
if (searchInput) {
    var searchTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        var val = this.value;
        searchTimer = setTimeout(function() {
            var url = val
                ? 'index.php?action=search&q=' + encodeURIComponent(val)
                : 'index.php?action=index';
            window.location.href = url;
        }, 380);
    });
}
</script>
</body>
</html>
