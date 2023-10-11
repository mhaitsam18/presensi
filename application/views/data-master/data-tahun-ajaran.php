        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('tahun_ajaran','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="" class="btn btn-primary mb-3 newTahunAjaranModalButton" data-toggle="modal" data-target="#newTahunAjaranModal">Add New School Years</a>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tahun Ajaran</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; ?>
                                    <?php foreach ($tahun_ajaran as $key): ?>
                                        <tr>
                                            <th scope="row"><?= $no ?></th>
                                            <td><?= $key['tahun_ajaran'] ?></td>
                                            <td>
                                                <a href="<?= base_url("DataMaster/updateTahunAjaran/$key[id]"); ?>" class="badge badge-success updateTahunAjaranModalButton" data-toggle="modal" data-target="#newTahunAjaranModal" data-id="<?=$key['id']?>">Edit</a>
                                                <a href="<?= base_url("DataMaster/deleteTahunAjaran/$key[id]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php $no++; ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Modal -->
            <div class="modal fade" id="newTahunAjaranModal" tabindex="-1" aria-labelledby="newTahunAjaranModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newTahunAjaranModalLabel">Add New Education</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('DataMaster/tahunAjaran') ?>" method="post">
                            <input type="hidden" name="id" id="id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="School Years">
                                    <?= form_error('tahun_ajaran','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            