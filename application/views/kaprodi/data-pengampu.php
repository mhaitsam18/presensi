        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('id_dosen','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('id_mata_kuliah','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-6">
                    		<a href="" class="btn btn-primary mb-3 newPengampuModalButton" data-toggle="modal" data-target="#newPengampuModal">Add New Course lecturers</a>
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                                        <th scope="col">ID Pengampu</th>
                    					<th scope="col">Kode Dosen</th>
                                        <th scope="col">Nama Mata Kuliah</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($pengampu as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
	                    					<td><?= $key['pid'] ?></td>
                                            <td><?= $key['kode_dosen'] ?></td>
                                            <td><?= $key['nama_mata_kuliah'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("Kaprodi/updatePengampu/$key[id]"); ?>" class="badge badge-success updatePengampuModalButton" data-toggle="modal" data-target="#newPengampuModal" data-id="<?=$key['id']?>">Edit</a>
	                    						<a href="<?= base_url("Kaprodi/deletePengampu/$key[id]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
            <div class="modal fade" id="newPengampuModal" tabindex="-1" aria-labelledby="newPengampuModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newPengampuModalLabel">Add New Pengampu</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('Kaprodi/Pengampu') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
                                    <select class="form-control" name="id_dosen" id="id_dosen">
                                        <option value="">Select Lecturer</option>
                                        <?php foreach ($dosen as $key): ?>
                                            <option value="<?= $key['did'] ?>"><?= $key['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_dosen','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <select class="form-control" name="id_mata_kuliah" id="id_mata_kuliah">
                                        <option value="">Select Course</option>
                                        <?php foreach ($mata_kuliah as $key): ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['nama_mata_kuliah'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_mata_kuliah','<small class="text-danger pl-3">','</small>'); ?>
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

            