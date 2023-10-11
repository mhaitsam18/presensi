<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Contoh Tampilan <?= $title ?> Untuk Mahasiswa</h1>
        <?= $this->session->flashdata('message1'); ?>
        <div class="row">
            <div class="col-lg-8">
                <form action="<?= base_url('user/updateMahasiswa') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?= $mahasiswa['mid'] ?>">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nim" name="nim" value="<?= $mahasiswa['nim'] ?>">
                            <?= form_error('nim','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_kelas" class="col-sm-2 col-form-label">Class</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_kelas" id="id_kelas">
                                <option value="">Select Class</option>
                                <?php foreach ($kelas as $row): ?>
                                    <?php if ($row['id']== $mahasiswa['id_kelas']): ?>
                                        <option value="<?= $row['id'] ?>" selected>
                                            <?= $row['kelas']; ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="<?= $row['id'] ?>">
                                            <?= $row['kelas']; ?>
                                        </option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('id_kelas','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="angkatan" class="col-sm-2 col-form-label">Generation</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="angkatan" name="angkatan" value="<?= $mahasiswa['angkatan'] ?>">
                            <?= form_error('angkatan','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_dosen" class="col-sm-2 col-form-label">Guardian Lecturer</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?= $mahasiswa['nama_dosen'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_wali" class="col-sm-2 col-form-label">Guardian Parent</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_wali" name="nama_wali" value="<?= $mahasiswa['nama_wali'] ?>">
                            <?= form_error('nama_wali','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pekerjaan_wali" class="col-sm-2 col-form-label">Parent Jobs</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" value="<?= $mahasiswa['pekerjaan_wali'] ?>">
                            <?= form_error('pekerjaan_wali','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pendidikan_wali" class="col-sm-2 col-form-label">Parent Education</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pendidikan_wali" id="pendidikan_wali">
                                <option value="">Select Education</option>
                                <?php foreach ($pendidikan as $row): ?>
                                    <?php if ($row['id'] == $mahasiswa['pendidikan_wali']): ?>
                                        <option value="<?= $row['id'] ?>" selected>
                                            <?= $row['pendidikan']; ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="<?= $row['id'] ?>">
                                            <?= $row['pendidikan']; ?>
                                        </option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('pendidikan_wali','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="asal_daerah" class="col-sm-2 col-form-label">Place of Origin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="asal_daerah" name="asal_daerah" value="<?= $mahasiswa['asal_daerah'] ?>">
                            <?= form_error('asal_daerah','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary float-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Contoh Tampilan <?= $title ?> Untuk Dosen</h1>
        <?= $this->session->flashdata('message2'); ?>
        <div class="row">
            <div class="col-lg-8">
                <form action="<?= base_url('user/updateDosen') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?= $dosen['id'] ?>">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_dosen" class="col-sm-2 col-form-label">Lecturer Code</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kode_dosen" name="kode_dosen" value="<?= $dosen['kode_dosen'] ?>">
                            <?= form_error('kode_dosen','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nidn" name="nidn" value="<?= $dosen['nidn'] ?>">
                            <?= form_error('nidn','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nip" name="nip" value="<?= $dosen['nip'] ?>">
                            <?= form_error('nip','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary float-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

