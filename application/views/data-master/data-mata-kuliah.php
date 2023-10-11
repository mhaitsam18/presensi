        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('kode_mata_kuliah','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('nama_mata_kuliah','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('sks','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('semester','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-11">
                    		<a href="" class="btn btn-primary mb-3 newMataKuliahModalButton" data-toggle="modal" data-target="#newMataKuliahModal">Add New Course</a>
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                    					<th scope="col">Kode Mata Kuliah</th>
                                        <th scope="col">Nama Mata Kuliah</th>
                                        <th scope="col">SKS</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Prodi</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($mataKuliah as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
	                    					<td><?= $key['kode_mata_kuliah'] ?></td>
                                            <td><?= $key['nama_mata_kuliah'] ?></td>
                                            <td><?= $key['sks'] ?></td>
                                            <td><?= $key['semester'] ?></td>
                                            <td><?= $key['nama_prodi'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("DataMaster/updateMataKuliah/$key[mid]"); ?>" class="badge badge-success updateMataKuliahModalButton" data-toggle="modal" data-target="#newMataKuliahModal" data-id="<?=$key['mid']?>">Edit</a>
	                    						<a href="<?= base_url("DataMaster/deleteMataKuliah/$key[mid]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
            <div class="modal fade" id="newMataKuliahModal" tabindex="-1" aria-labelledby="newMataKuliahModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newMataKuliahModalLabel">Add New Mata Kuliah</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('DataMaster/MataKuliah') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<input type="text" class="form-control" id="kode_mata_kuliah" name="kode_mata_kuliah" placeholder="Courses Code">
                                    <?= form_error('kode_mata_kuliah','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_mata_kuliah" name="nama_mata_kuliah" placeholder="Courses Name">
                                    <?= form_error('nama_mata_kuliah','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="sks" name="sks" placeholder="SKS">
                                    <?= form_error('sks','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="semester" name="semester" placeholder="Semester">
                                    <?= form_error('semester','<small class="text-danger pl-3">','</small>'); ?>
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

            