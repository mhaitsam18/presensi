    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
                            </div>
                            <?= $this->session->flashdata('message'); ?>
                            <form class="user" method="post" action="<?= base_url('auth/formMahasiswa') ?>">
                                <input type="hidden" name="id_user" id="id_user" value="<?= $this->session->userdata('form') ?>">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="nim" name="nim" placeholder="NIM" value="<?= set_value('nim') ?>">
                                    <?= form_error('nim','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_kelas" id="id_kelas">
                                        <option value="">Select Class</option>
                                        <?php foreach ($kelas as $row): ?>
                                            <option value="<?= $row['id'] ?>"><?= ucwords($row['kelas']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_kelas','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user"
                                        id="angkatan" name="angkatan" placeholder="Generation">
                                    <?= form_error('angkatan','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                        id="nama_wali" name="nama_wali" placeholder="guardian's name">
                                    <?= form_error('nama_wali','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                        id="pekerjaan_wali" name="pekerjaan_wali" placeholder="Guardian's job">
                                    <?= form_error('pekerjaan_wali','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="pendidikan_wali" id="pendidikan_wali">
                                        <option value="">Select Parent Education</option>
                                        <?php foreach ($pendidikan as $row): ?>
                                            <option value="<?= $row['id'] ?>"><?= ucwords($row['pendidikan']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_kelas','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                        id="asal_daerah" name="asal_daerah" placeholder="Origin">
                                    <?= form_error('asal_daerah','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <button typer="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>