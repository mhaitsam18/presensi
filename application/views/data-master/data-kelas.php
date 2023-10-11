        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('kelas','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('nama_ketua_kelas','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('nomor_ketua_kelas','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-12">
                    		<a href="" class="btn btn-primary mb-3 newKelasModalButton" data-toggle="modal" data-target="#newKelasModal">Add New Class</a>
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                    					<th scope="col">Kelas</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Nama Ketua Kelas</th>
                                        <th scope="col">Nomor Ketua Kelas</th>
                                        <th scope="col">Dosen Wali</th>
                                        <th scope="col">Prodi</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($kelas as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
	                    					<td><?= $key['kelas'] ?></td>
                                            <td><?= $key['semester_kelas'] ?></td>
                                            <td><?= $key['nama_ketua_kelas'] ?></td>
                                            <td><?= $key['nomor_ketua_kelas'] ?></td>
                                            <td><?= $key['name'] ?></td>
                                            <td><?= $key['nama_prodi'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("DataMaster/updateKelas/$key[kid]"); ?>" class="badge badge-success updateKelasModalButton" data-toggle="modal" data-target="#newKelasModal" data-id="<?=$key['kid']?>">Edit</a>
	                    						<a href="<?= base_url("DataMaster/deleteKelas/$key[kid]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
            <div class="modal fade" id="newKelasModal" tabindex="-1" aria-labelledby="newKelasModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newKelasModalLabel">Add New Kelas</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('DataMaster/Kelas') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<input type="text" class="form-control" id="kelas" name="kelas" placeholder="Class Code">
                                    <?= form_error('kelas','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="semester_kelas" name="semester_kelas" placeholder="Semester">
                                    <?= form_error('semester_kelas','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_ketua_kelas" name="nama_ketua_kelas" placeholder="Leader Class Name">
                                    <?= form_error('nama_ketua_kelas','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="nomor_ketua_kelas" name="nomor_ketua_kelas" placeholder="Phone Number Leader Class Name">
                                    <?= form_error('nomor_ketua_kelas','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_dosen_wali" id="id_dosen_wali">
                                        <option value="">Select Guardian Lecturer</option>
                                        <?php foreach ($dosen as $key): ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['kode_dosen'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_prodi" id="id_prodi">
                                        <option value="">Select Study Program</option>
                                        <?php foreach ($prodi as $key): ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['nama_prodi'] ?></option>
                                        <?php endforeach ?>
                                    </select>
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