<!-- Footer -->
<div class="footer">
    <p>&copy; 2025 Sistem Informasi Inventaris IT</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function loadPage(page) {
        const content = document.getElementById('main-content');
        content.innerHTML = `<div class='card'><div class='card-body'><h3 class='card-title text-capitalize'>${page.replace('_', ' ')}</h3><p class='text-muted'>Konten untuk halaman ${page} akan ditampilkan di sini.</p></div></div>`;

        // Reset active class
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        const activeLinks = [...document.querySelectorAll('.nav-link')].filter(link => link.textContent.toLowerCase().includes(page));
        if (activeLinks.length) activeLinks[0].classList.add('active');
    }

    function logout() {
        alert("Anda telah logout.");
        // Tambahkan logika redirect ke halaman login jika ada
    }

    <!-- Script untuk handle active & collapse -->

    // Aktifkan sidebar dari localStorage
    document.addEventListener("DOMContentLoaded", function () {
        const current = localStorage.getItem("activeSidebar");
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";

        if (isCollapsed) document.getElementById("sidebar").classList.add("collapsed");

        if (current) {
            const activeLink = document.querySelector(`.nav-link[data-page="${current}"]`);
            if (activeLink) {
                activateLink(activeLink);
                expandCollapseIfNeeded(activeLink);
            }
        }
    });

    function loadPage(pageName) {
        localStorage.setItem("activeSidebar", pageName);
        const clickedLink = document.querySelector(`.nav-link[data-page="${pageName}"]`);
        if (clickedLink) {
            activateLink(clickedLink);
            expandCollapseIfNeeded(clickedLink);
        }

        // ... Load konten via AJAX jika ada
    }

    function activateLink(link) {
        document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
        link.classList.add('active');
    }

    function expandCollapseIfNeeded(link) {
        const parentCollapse = link.closest('.collapse');
        if (parentCollapse) {
            const collapseId = parentCollapse.getAttribute('id');
            const collapseEl = document.getElementById(collapseId);
            if (collapseEl && !collapseEl.classList.contains('show')) {
                new bootstrap.Collapse(collapseEl, { toggle: true });
            }
        }
    }

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("collapsed");
        localStorage.setItem("sidebarCollapsed", sidebar.classList.contains("collapsed"));
    }

    document.getElementById('kode_barang').addEventListener('change', function () {
        var kode = this.value;

        if (kode !== '') {
            fetch('get_spesifikasi.php?kode_barang=' + kode)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('spesifikasi_barang').value = data.spesifikasi_barang || '-';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('spesifikasi_barang').value = '-';
                });
        } else {
            document.getElementById('spesifikasi_barang').value = '';
        }
    });

    document.getElementById('add-stok').addEventListener('click', function () {
        const container = document.getElementById('stok-container');
        const firstRow = container.querySelector('.stok-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelectorAll('input').forEach(el => el.value = '');
        newRow.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
        container.appendChild(newRow);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('.stok-row');
            const container = document.getElementById('stok-container');
            if (container.querySelectorAll('.stok-row').length > 1) {
                row.remove();
            }
        }
    });


</script>
</body>



</html>