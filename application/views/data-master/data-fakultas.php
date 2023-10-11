        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('kode_fakultas','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('nama_fakultas','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-6">
                    		<a href="" class="btn btn-primary mb-3 newFakultasModalButton" data-toggle="modal" data-target="#newFakultasModal">Add New Faculty</a>
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                    					<th scope="col">Kode Fakultas</th>
                                        <th scope="col">Nama Fakultas</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($fakultas as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
	                    					<td><?= $key['kode_fakultas'] ?></td>
                                            <td><?= $key['nama_fakultas'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("DataMaster/updateFakultas/$key[id]"); ?>" class="badge badge-success updateFakultasModalButton" data-toggle="modal" data-target="#newFakultasModal" data-id="<?=$key['id']?>">Edit</a>
	                    						<a href="<?= base_url("DataMaster/deleteFakultas/$key[id]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
            <div class="modal fade" id="newFakultasModal" tabindex="-1" aria-labelledby="newFakultasModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newFakultasModalLabel">Add New Fakultas</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('DataMaster/fakultas') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<input type="text" class="form-control" id="kode_fakultas" name="kode_fakultas" placeholder="Fakultas Code">
                                    <?= form_error('kode_fakultas','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_fakultas" name="nama_fakultas" placeholder="Fakultas Name">
                                    <?= form_error('nama_fakultas','<small class="text-danger pl-3">','</small>'); ?>
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

            