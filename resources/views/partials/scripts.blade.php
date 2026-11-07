
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openButton = document.getElementById('openSidebar');

    if (!sidebar) return;

    const desktop = window.matchMedia('(min-width: 1024px)');

    function openSidebar() {
        if (desktop.matches) return;

        sidebar.classList.add('is-open');
        overlay?.classList.remove('hidden');

        document.body.style.overflow = 'hidden';
        openButton?.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        if (desktop.matches) return;

        sidebar.classList.remove('is-open');
        overlay?.classList.add('hidden');

        document.body.style.overflow = '';
        openButton?.setAttribute('aria-expanded', 'false');
    }

    function syncSidebar() {
        sidebar.classList.remove('is-open');
        overlay?.classList.add('hidden');
        document.body.style.overflow = '';

        openButton?.setAttribute('aria-expanded', 'false');
    }

    // Tombol buka/tutup sidebar
    openButton?.addEventListener('click', function () {
        if (sidebar.classList.contains('is-open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // Tutup saat overlay diklik
    overlay?.addEventListener('click', closeSidebar);

    // Tutup ketika menu dipilih pada HP
    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!desktop.matches) {
                closeSidebar();
            }
        });
    });

    // Tombol Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    // Perubahan ukuran layar
    desktop.addEventListener('change', syncSidebar);

    // Keadaan awal
    syncSidebar();
});
</script>
