        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('kode_prodi','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('nama_prodi','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-12">
                    		<a href="" class="btn btn-primary mb-3 newProdiModalButton" data-toggle="modal" data-target="#newProdiModal">Add New Prodi</a>
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                    					<th scope="col">Kode Prodi</th>
                                        <th scope="col">Nama Prodi</th>
                                        <th scope="col">Fakultas</th>
                                        <th scope="col">Kaprodi</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($prodi as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
	                    					<td><?= $key['kode_prodi'] ?></td>
                                            <td><?= $key['nama_prodi'] ?></td>
                                            <td><?= $key['nama_fakultas'] ?></td>
                                            <td><?= $key['name'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("DataMaster/updateProdi/$key[pid]"); ?>" class="badge badge-success updateProdiModalButton" data-toggle="modal" data-target="#newProdiModal" data-id="<?=$key['pid']?>">Edit</a>
	                    						<a href="<?= base_url("DataMaster/deleteProdi/$key[pid]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
            <div class="modal fade" id="newProdiModal" tabindex="-1" aria-labelledby="newProdiModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newProdiModalLabel">Add New Prodi</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('DataMaster/prodi') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<input type="text" class="form-control" id="kode_prodi" name="kode_prodi" placeholder="Prodi Code">
                                    <?= form_error('kode_prodi','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" placeholder="Prodi Name">
                                    <?= form_error('nama_prodi','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_fakultas" id="id_fakultas">
                                        <option value="">Select Faculty</option>
                                        <?php foreach ($fakultas as $key): ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['nama_fakultas'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_kaprodi" id="id_kaprodi">
                                        <option value="">Select Kaprodi</option>
                                        <?php foreach ($dosen as $key): ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['kode_dosen'] ?></option>
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

            