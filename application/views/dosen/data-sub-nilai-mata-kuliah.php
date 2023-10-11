        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('nama_penilaian','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('bobot','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('nilai','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('id_nilai_mata_kuliah','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="" class="btn btn-primary mb-3 newSubNilaiMataKuliahModalButton" data-toggle="modal" data-target="#newSubNilaiMataKuliahModal">Add New Score</a>
                            <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Data Sub Nilai Mata Kuliah</div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">NIM</th>
                                                <th scope="col">Kelas</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Kode Dosen</th>
                                                <th scope="col">Nama Penilaian</th>
                                                <th scope="col">Bobot</th>
                                                <th scope="col">Nilai</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; ?>
                                            <?php foreach ($sub_nilai_mata_kuliah as $key): ?>
                                                <tr>
                                                    <th scope="row"><?= $no ?></th>
                                                    <td><?= $key['name'] ?></td>
                                                    <td><?= $key['nim'] ?></td>
                                                    <td><?= $key['kelas'] ?></td>
                                                    <td><?= $key['nama_mata_kuliah'] ?></td>
                                                    <td><?= $key['kode_dosen'] ?></td>
                                                    <td><?= $key['nama_penilaian'] ?></td>
                                                    <td><?= $key['bobot'] ?></td>
                                                    <td><?= $key['nilai'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url("Dosen/updateSubNilaiMataKuliah/$key[snmkid]/data"); ?>" class="badge badge-success updateSubNilaiMataKuliahModalButton" data-toggle="modal" data-target="#newSubNilaiMataKuliahModal" data-id="<?=$key['snmkid']?>">Edit</a>
                                                        <a href="<?= base_url("Dosen/deleteSubNilaiMataKuliah/$key[snmkid]/$key[id_nilai_mahasiswa]/data"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php $no++; ?>
                                            <?php endforeach ?>
                                            <?php if (!$sub_nilai_mata_kuliah): ?>
                                                <tr>
                                                    <th colspan="10" style="text-align: center;">Tidak ada Mahasiswa di Kelas Anda</th>
                                                </tr>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Modal -->
            <div class="modal fade" id="newSubNilaiMataKuliahModal" tabindex="-1" aria-labelledby="newSubNilaiMataKuliahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newSubNilaiMataKuliahModalLabel">Add New Score</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url("Dosen/").$this->uri->segment(2)."/data" ?>" method="post">
                            <input type="hidden" name="id" id="id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <select class="form-control" name="id_nilai_mahasiswa" id="id_nilai_mahasiswa">
                                        <option value="">Select Student</option>
                                        <?php foreach ($nilai_mahasiswa as $key): ?>
                                            <option value="<?= $key['nmid'] ?>"><?= $key['nim'].' | '.$key['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_nilai_mahasiswa','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_pengampu" id="id_pengampu">
                                        <option value="">Select Course</option>
                                        <?php foreach ($pengampu as $key): ?>
                                            <option value="<?= $key['pid'] ?>"><?= $key['kode_dosen'].' | '.$key['nama_mata_kuliah'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_pengampu','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_nilai_mata_kuliah" id="id_nilai_mata_kuliah">
                                        <option value="">Select Value</option>
                                        <?php foreach ($nilai_mata_kuliah as $key): ?>
                                            <option value="<?= $key['nmkid'] ?>"><?= $key['name'].' | '.$key['nama_mata_kuliah'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_nilai_mata_kuliah','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_penilaian" name="nama_penilaian" placeholder="Score Name">
                                    <?= form_error('nama_penilaian','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" step="0.01" id="bobot" name="bobot" placeholder="Value">
                                    <?= form_error('bobot','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" step="0.01" id="nilai" name="nilai" placeholder="Score">
                                    <?= form_error('nilai','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>