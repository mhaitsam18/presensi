        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Performa Kelas</h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($kelas as $key): ?>
                            <div class="card mb-3 mr-3" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $key['kelas'] ?></h5>
                                    <p class="card-text">Kode/Nama Dosen Wali: <?= $key['kode_dosen'].' / '.$key['name'] ?></p>
                                    <h6 class="card-subtitle mb-2 text-muted">Ketua Kelas : <?= $key['nama_ketua_kelas'] ?></h6>
                                    <p class="card-text">Nomor Hp: <?= $key['nomor_ketua_kelas'] ?></p>
                                    <p class="card-text">Total Anggota: <?= $key['count_mahasiswa'] ?> Mahasiswa</p>
                                    <a href="<?= base_url("Dosen/listMahasiswa/$key[kid]") ?>" class="card-link">Detail</a>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <?php if (!$kelas): ?>
                            <h2>Tidak ada Mahasiswa di daftar Anda</h2>
                        <?php endif ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->