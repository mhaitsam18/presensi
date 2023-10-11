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
                            <form class="user" method="post" action="<?= base_url('auth/formDosen') ?>">
                                <input type="hidden" name="id_user" id="id_user" value="<?= $this->session->userdata('form') ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="kode_dosen" name="kode_dosen" placeholder="Lecturer's Code" value="<?= set_value('kode_dosen') ?>">
                                    <?= form_error('kode_dosen','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user"
                                        id="nidn" name="nidn" placeholder="NIDN">
                                    <?= form_error('nidn','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user"
                                        id="nip" name="nip" placeholder="NIP">
                                    <?= form_error('nip','<small class="text-danger pl-3">','</small>') ?>
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