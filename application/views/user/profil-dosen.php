<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
        <?= $this->session->flashdata('message2'); ?>
        <div class="row">
            <div class="col-lg-8">
                <form action="<?= base_url('user/updateDosen') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?= $dosen['id'] ?>">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_dosen" class="col-sm-2 col-form-label">Kode Dosen</label>
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
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->