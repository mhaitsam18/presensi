        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?= base_url("assets/img/profile/$user[image]") ?>" class="card-img" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $user['name']; ?></h5>
                                    <p class="card-text">Email : <?= $user['email']; ?></p>
                                    <p class="card-text">Agama : <?= $user['agama']; ?></p>
                                    <?php if (isset($mahasiswa)): ?>
                                        <p class="card-text">NIM : <?= $mahasiswa['nim'] ?></p>
                                    <?php elseif(isset($dosen)): ?>
                                        <p class="card-text">Kode Dosen : <?= $dosen['kode_dosen'] ?></p>
                                        <p class="card-text">NIP : <?= $dosen['nip'] ?></p>
                                        <p class="card-text">No Handphone : <?= $user['phone_number'] ?></p>
                                        <p class="card-text">Jenis Kelamin : <?= $user['gender'] ?></p>
                                        <p class="card-text">Tempat Lahir : <?= $user['place_of_birth'] ?></p>
                                        <p class="card-text">Tanggal Lahir : <?= $user['birthday'] ?></p>
                                        <p class="card-text">Alamat : <?= $user['address'] ?></p>
                                    <?php endif ?>
                                    <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']) ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->