    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>&copy; Your Website 2024. All Rights Reserved.</span>
            </div>
        </div>
    </footer>
</div>

</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url()?>assets/vendors/js/jquery-3.6.0.min.js"></script>
<script src="<?= base_url()?>assets/vendors/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/backend/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url() ?>assets/backend/js/sb-admin-2.min.js"></script>
<script src="<?= base_url() ?>assets/tables/datatable/datatables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/tables/datatables/datatable-basic.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/vendors/js/easy-autocomplete/jquery.easy-autocomplete.min.js"></script>
<script src="<?= base_url() ?>vendor/js/scriptoman.js"></script>
<script>
    // Fungsi untuk menangani penambahan/penghapusan kelas sidebar
    function handleSidebarOnResize() {
        const body = document.getElementById('page-top');
        const sidebar = document.getElementById('accordionSidebar');
        // Ukuran tablet standar (breakpoint 'md' dari Bootstrap) adalah 768px
        const tabletBreakpoint = 768;

        // Periksa jika lebar layar di bawah breakpoint tablet
        if (window.innerWidth < tabletBreakpoint) {
            // Jika ya, pastikan body memiliki kelas 'sidebar-toggled'
            // dan sidebar itu sendiri memiliki kelas 'toggled' agar berfungsi dengan benar.
            body.classList.add('sidebar-toggled');
            sidebar.classList.add('toggled');
        } else {
            // Jika tidak (layar lebih besar dari tablet), hapus kelas tersebut
            // agar sidebar kembali ke tampilan normal (tidak tertutup).
            body.classList.remove('sidebar-toggled');
            sidebar.classList.remove('toggled');
        }
    }

    // Panggil fungsi saat pertama kali halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', handleSidebarOnResize);

    // Panggil fungsi lagi setiap kali pengguna mengubah ukuran jendela browser
    window.addEventListener('resize', handleSidebarOnResize);
    </script>

</body>
</html>
