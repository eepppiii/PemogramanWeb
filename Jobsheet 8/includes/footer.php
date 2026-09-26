  </main>

  <footer>
    <p>&copy; <?= date('Y') ?> <strong>Seni Theatrisic</strong> &mdash; Sistem Manajemen Organisasi</p>
    <p class="footer-sub">Dibuat dengan ❤️ untuk kemajuan seni</p>
  </footer>

  <div id="confirm-modal" class="modal-overlay">
      <div class="modal-box">
          <p id="confirm-modal-text">Yakin ingin menghapus data ini?</p>
          <div class="modal-actions">
              <button type="button" class="btn-cancel" onclick="closeConfirm()">Batal</button>
              <a href="#" id="confirm-delete-link" class="btn-danger" style="text-decoration:none; display:inline-block;">Hapus</a>
          </div>
      </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const alert = document.getElementById('flash-alert');
      if (alert) setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 300);
      }, 5000);
    });

    function askDelete(url, label) {
      document.getElementById('confirm-modal-text').textContent =
        'Hapus data "' + label + '"? Data yang sudah dihapus tidak bisa dikembalikan.';
      document.getElementById('confirm-delete-link').href = url;
      document.getElementById('confirm-modal').classList.add('open');
    }
    function closeConfirm() {
      document.getElementById('confirm-modal').classList.remove('open');
    }
  </script>
</body>
</html>