<!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <?php $dashboard = $this->db->get('dashboard')->row_array(); ?>
                        <span>Copyright &copy; Proyek Akhir <?= $dashboard['footer'].' '.date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>


    <!--Chart Js-->
    <script src="<?= base_url('assets/'); ?>js/Chart.js"></script>


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script src="<?= base_url('assets/') ?>js/demo/datatables-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/') ?>dist/sweetalert2.all.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

    <script type="text/javascript">
        const flashData = $('.flash-data').data('flashdata');
        const shuttle = $('.shuttle').data('shuttle');
        const objek = $('.flash-data').data('objek');
        console.log(flashData);
        console.log(objek);
        if (flashData) {
            //'Data ' + 
            Swal.fire({
                title: objek,
                text: flashData,
                icon: 'success'
            });
        }
        if (shuttle) {
            Swal.fire({
                title: 'Pemesanan Anda Berhasil',
                text: shuttle,
                icon: 'success'
            });
        }
        $('.tombol-hapus').on('click', function(e) {
            const hapus = $(this).data('hapus');
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data " + hapus + " akan dihapus!",
                icon: 'warning',
                confirmButtonText: 'Hapus',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });

        $('.tombol-terima').on('click', function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Pesanan yang diterima, tidak dapat dikembalikan!",
                icon: 'warning',
                confirmButtonText: 'diterima',
                showCancelButton: true,
                confirmButtonColor: '#32a852',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });
        $('.tombol-yakin').on('click', function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "",
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                showCancelButton: true,
                confirmButtonColor: '#32a852',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });
        $('.minta-password').on('click', function(e) {
            Swal.fire({
                title: 'Masukkan Password',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Look up',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(`//api.github.com/users/${login}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                            )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url
                    })
                }
            })
        });
    </script>

    <script type="text/javascript">
        $('.custom-file-input').on('change', function(){
            let filename = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(filename);
        });

        $(function() {
            $('.newMenuModalButton').on('click', function(){
                $('#newMenuModalLabel').html('Add New Menu');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/menu');
            });

            $('.updateMenuModalButton').on('click', function() {
                $('#newMenuModalLabel').html('Edit Menu');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/menu/updateMenu');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/menu/getUpdateMenu',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#menu').val(data.menu);
                        $('#active').attr("checked", true);
                        if(data.active == 1){
                            $('#active').attr("checked", true);
                        } else{
                            $('#active').attr("checked", false);
                        }
                    }
                });
            });
        });

        $(function() {
            $('.newRoleModalButton').on('click', function(){
                $('#newRoleModalLabel').html('Add New Role');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Admin/role/');
            });

            $('.updateRoleModalButton').on('click', function() {
                $('#newRoleModalLabel').html('Edit Role');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Admin/updateRole');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/admin/getUpdateRole',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#role').val(data.role);
                    }
                });
            });
        });

        $(function() {
            $('.setRoleButton').on('click', function() {
                $('#setRoleLabel').html('Set User Role');
                $('.modal-footer button[type=submit]').html('Save');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/admin/getUserData',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#role_id').val(data.role_id);
                    }
                });
            });
        });

        $(function() {
            $('.newSubMenuModalButton').on('click', function(){
                $('#newSubMenuModalLabel').html('Add New SubMenu');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/menu/subMenu');
            });

            $('.updateSubMenuModalButton').on('click', function() {
                $('#newSubMenuModalLabel').html('Edit SubMenu');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/menu/updateSubMenu');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/menu/getUpdateSubMenu',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#title').val(data.title);
                        $('#menu_id').val(data.menu_id);
                        $('#url').val(data.url);
                        $('#icon').val(data.icon);
                        $('#is_active').attr("checked", true);
                        if(data.is_active == 1){
                            $('#is_active').attr("checked", true);
                        } else if(data.is_active == 0){
                            $('#is_active').attr("checked", false);
                        }
                    }
                });
            });
        });

        $(function() {
            $('.newAgamaModalButton').on('click', function(){
                $('#newAgamaModalLabel').html('Add New Religion');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/agama');
            });

            $('.updateAgamaModalButton').on('click', function() {
                $('#newAgamaModalLabel').html('Edit Religion');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateAgama');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateAgama',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#agama').val(data.agama);
                    }
                });
            });
        });

        $(function() {
            $('.newPendidikanModalButton').on('click', function(){
                $('#newPendidikanModalLabel').html('Add New Education');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/pendidikan');
            });

            $('.updatePendidikanModalButton').on('click', function() {
                $('#newPendidikanModalLabel').html('Edit Education');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updatePendidikan');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdatePendidikan',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#pendidikan').val(data.pendidikan);
                    }
                });
            });
        });

        $(function() {
            $('.newPertanyaan1ModalButton').on('click', function(){
                $('#newPertanyaan1ModalLabel').html('Add New Question 1');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/pertanyaan/1');
            });

            $('.updatePertanyaan1ModalButton').on('click', function() {
                $('#newPertanyaan1ModalLabel').html('Edit Question 1');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updatePertanyaan/1');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdatePertanyaan1',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id1').val(data.id);
                        $('#pertanyaan1').val(data.pertanyaan);
                    }
                });
            });
        });

        $(function() {
            $('.newPertanyaan2ModalButton').on('click', function(){
                $('#newPertanyaan2ModalLabel').html('Add New Question 2');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/pertanyaan/2');
            });

            $('.updatePertanyaan2ModalButton').on('click', function() {
                $('#newPertanyaan2ModalLabel').html('Edit Question 2');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updatePertanyaan/2');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdatePertanyaan2',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id2').val(data.id);
                        $('#pertanyaan2').val(data.pertanyaan);
                    }
                });
            });
        });

        $(function() {
            $('.newKontenModalButton').on('click', function(){
                $('#newKontenModalLabel').html('Add New Content');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/konten');
            });

            $('.updateKontenModalButton').on('click', function() {
                $('#newKontenModalLabel').html('Edit Content');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateKonten');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateKonten',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#header').val(data.header);
                        $('#konten').val(data.content);
                        $('#footer').val(data.footer);
                    }
                });
            });
        });

        $(function() {
            $('.newTahunAjaranModalButton').on('click', function(){
                $('#newTahunAjaranModalLabel').html('Add New School Year');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/tahunAjaran');
            });

            $('.updateTahunAjaranModalButton').on('click', function() {
                $('#newTahunAjaranModalLabel').html('Edit School Year');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateTahunAjaran');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateTahunAjaran',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#tahun_ajaran').val(data.tahun_ajaran);
                    }
                });
            });
        });

        $(function() {
            $('.newStatusMahasiswaModalButton').on('click', function(){
                $('#newStatusMahasiswaModalLabel').html("Add New Student's Status");
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/statusMahasiswa');
            });

            $('.updateStatusMahasiswaModalButton').on('click', function() {
                $('#newStatusMahasiswaModalLabel').html("Edit Student's Status");
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateStatusMahasiswa');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateStatusMahasiswa',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#status').val(data.status);
                    }
                });
            });
        });

        $(function() {
            $('.newFakultasModalButton').on('click', function(){
                $('#newFakultasModalLabel').html('Add New Faculty');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/fakultas');
            });

            $('.updateFakultasModalButton').on('click', function() {
                $('#newFakultasModalLabel').html('Edit Faculty');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateFakultas');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateFakultas',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#kode_fakultas').val(data.kode_fakultas);
                        $('#nama_fakultas').val(data.nama_fakultas);
                    }
                });
            });
        });

        $(function() {
            $('.newProdiModalButton').on('click', function(){
                $('#newProdiModalLabel').html('Add New Prodi');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/prodi');
            });

            $('.updateProdiModalButton').on('click', function() {
                $('#newProdiModalLabel').html('Edit Prodi');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateProdi');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateProdi',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#kode_prodi').val(data.kode_prodi);
                        $('#nama_prodi').val(data.nama_prodi);
                        $('#id_fakultas').val(data.id_fakultas);
                        $('#id_kaprodi').val(data.id_kaprodi);
                    }
                });
            });
        });

        $(function() {
            $('.newKelasModalButton').on('click', function(){
                $('#newKelasModalLabel').html('Add New Class');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/kelas');
            });

            $('.updateKelasModalButton').on('click', function() {
                $('#newKelasModalLabel').html('Edit Class');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateKelas');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateKelas',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#kelas').val(data.kelas);
                        $('#semester_kelas').val(data.semester_kelas);
                        $('#nama_ketua_kelas').val(data.nama_ketua_kelas);
                        $('#nomor_ketua_kelas').val(data.nomor_ketua_kelas);
                        $('#id_dosen_wali').val(data.id_dosen_wali);
                        $('#id_prodi').val(data.id_prodi);
                    }
                });
            });
        });

        $(function() {
            $('.newMataKuliahModalButton').on('click', function(){
                $('#newMataKuliahModalLabel').html('Add New Course');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/mataKuliah');
            });

            $('.updateMataKuliahModalButton').on('click', function() {
                $('#newMataKuliahModalLabel').html('Edit Course');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateMataKuliah');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/DataMaster/getUpdateMataKuliah',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#kode_mata_kuliah').val(data.kode_mata_kuliah);
                        $('#nama_mata_kuliah').val(data.nama_mata_kuliah);
                        $('#sks').val(data.sks);
                        $('#semester').val(data.semester);
                        $('#id_prodi').val(data.id_prodi);
                    }
                });
            });
        });

        $(function() {
            $('.newPengampuModalButton').on('click', function(){
                $('#newPengampuModalLabel').html('Add New Lecturer');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Kaprodi/Pengampu');
            });

            $('.updatePengampuModalButton').on('click', function() {
                $('#newPengampuModalLabel').html('Edit Lecturer');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Kaprodi/updatePengampu');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/Kaprodi/getUpdatePengampu',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_dosen').val(data.id_dosen);
                        $('#id_mata_kuliah').val(data.id_mata_kuliah);
                    }
                });
            });
        });

        $(function() {
            $('.newNilaiMahasiswaModalButton').on('click', function(){
                $('#newNilaiMahasiswaModalLabel').html('Add New Student Score');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/NilaiMahasiswa');
            });

            $('.updateNilaiMahasiswaModalButton').on('click', function() {
                $('#newNilaiMahasiswaModalLabel').html('Edit Student Score');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/updateNilaiMahasiswa');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/Dosen/getUpdateNilaiMahasiswa',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_mahasiswa').val(data.id_mahasiswa);
                        $('#ipk').val(data.ipk);
                        $('#tak').val(data.tak);
                    }
                });
            });
        });

        $(function() {
            $('.newNilaiMataKuliahModalButton').on('click', function(){
                $('#newNilaiMataKuliahModalLabel').html('Add New Student Score');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/nilaiMataKuliah');
            });

            $('.updateNilaiMataKuliahModalButton').on('click', function() {
                $('#newNilaiMataKuliahModalLabel').html('Edit Student Score');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/updateNilaiMataKuliah');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/Dosen/getUpdateNilaiMataKuliah',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_nilai_mahasiswa').val(data.id_nilai_mahasiswa);
                        $('#indeks').val(data.indeks);
                        $('#presensi').val(data.presensi);
                        $('#tahun_ajaran').val(data.tahun_ajaran);
                        $('#semester').val(data.semester);
                        $('#id_pengampu').val(data.id_pengampu);
                    }
                });
            });
        });

        $(function() {
            $('.newDetailSubNilaiMataKuliahModalButton').on('click', function(){
                $('#newDetailSubNilaiMataKuliahModalLabel').html('Add New Student Score');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/DetailSubnilaiMataKuliah/<?= $this->uri->segment(3); ?>');
            });

            $('.updateDetailSubNilaiMataKuliahModalButton').on('click', function() {
                $('#newDetailSubNilaiMataKuliahModalLabel').html('Edit Student Score');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/updateSubNilaiMataKuliah/<?= $this->uri->segment(3); ?>/detail');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/Dosen/getUpdateSubNilaiMataKuliah',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_nilai_mata_kuliah').val(data.id_nilai_mata_kuliah);
                        $('#nama_penilaian').val(data.nama_penilaian);
                        $('#bobot').val(data.bobot);
                        $('#nilai').val(data.nilai);
                    }
                });
            });
        });

        $(function() {
            $('.newSubNilaiMataKuliahModalButton').on('click', function(){
                $('#newSubNilaiMataKuliahModalLabel').html('Add New Student Score');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/SubnilaiMataKuliah');
                $('#id_nilai_mata_kuliah').hide();
                $('#id_pengampu').show();
                $('#id_nilai_mahasiswa').show();
            });

            $('.updateSubNilaiMataKuliahModalButton').on('click', function() {
                $('#newSubNilaiMataKuliahModalLabel').html('Edit Student Score');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Dosen/updateSubNilaiMataKuliah/data');
                $('#id_nilai_mata_kuliah').show();
                $('#id_pengampu').hide();
                $('#id_nilai_mahasiswa').hide();
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/Dosen/getUpdateSubNilaiMataKuliah',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_nilai_mata_kuliah').val(data.id_nilai_mata_kuliah);
                        $('#nama_penilaian').val(data.nama_penilaian);
                        $('#bobot').val(data.bobot);
                        $('#nilai').val(data.nilai);
                    }
                });
            });
        });
        $(function() {
            $('.newTakModalButton').on('click', function(){
                $('#newTakModalLabel').html('Add New TAK');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', 'http://localhost/presensi/Mahasiswa/tak');
            });

            $('.updateTakModalButton').on('click', function() {
                $('#newTakModalLabel').html('Edit TAK');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', 'http://localhost/presensi/Mahasiswa/updateTak');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: 'http://localhost/presensi/Mahasiswa/getUpdateTak',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_nilai_mahasiswa').val(data.id_nilai_mahasiswa);
                        $('#aktivitas').val(data.aktivitas);
                        $('#deskripsi').val(data.deskripsi);
                        $('#semester').val(data.semester);
                        $('#tahun_ajaran').val(data.tahun_ajaran);
                        $('#poin').val(data.poin);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        
        $('.check_role').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('admin/changeAccess') ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleAccess/'); ?>" + roleId;
                }
            });
        });

        $('.cek_angkatan').on('click', function() {

            var checkbox = document.getElementsByName("angkatan");
            var angkatan = "";
            for(var i = 0; i < checkbox.length; i++){
                if(checkbox[i].checked){
                    angkatan = angkatan + checkbox[i].value +"-";
                }
            }
            <?php
            $segmentasi = '';
            if ($this->uri->segment(4) == ''){
                $segmentasi = 'All';
            } else{
                $segmentasi = $this->uri->segment(4);
            } ?>
            document.location.href = "<?= base_url('Kaprodi/index/'.$this->uri->segment(3).'/'.$segmentasi.'/'); ?>"+angkatan;

            // $.ajax({
            //     url: "<?= base_url('Kaprodi/index/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>",
            //     type: 'post',
            //     data: {
            //         angkatan: angkatan
            //     },
            //     success: function() {
            //     }
            // });
        });

        
    </script>

    
</body>

</html>