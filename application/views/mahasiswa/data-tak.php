        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <h2><?= $user['name']."'s TAK" ?></h2>
                    <?= $this->session->flashdata('message'); ?>
                    <?= form_error('aktivitas','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('deskripsi','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('semester','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('tahun_ajaran','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('poin','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-12">
                    		<a href="" class="btn btn-primary mb-3 newTakModalButton" data-toggle="modal" data-target="#newTakModal">Add New TAK</a>
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                    					<th scope="col">Aktivitas</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Tahun Ajaran</th>
                                        <th scope="col">Poin</th>
                                        <th scope="col">Date Create</th>
                                        <th scope="col">Date Update</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($tak as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
	                    					<td><?= $key['aktivitas'] ?></td>
                                            <td><?= $key['deskripsi'] ?></td>
                                            <td><?= $key['semester'] ?></td>
                                            <td><?= $key['tahun_ajaran'] ?></td>
                                            <td><?= $key['poin'] ?></td>
                                            <td><?= date('d F Y', $key['date_create']) ?></td>
                                            <td><?= date('d F Y', $key['date_update']) ?></td>
	                    					<td>
	                    						<a href="<?= base_url("Mahasiswa/updateTak/$key[id]"); ?>" class="badge badge-success updateTakModalButton" data-toggle="modal" data-target="#newTakModal" data-id="<?=$key['id']?>">Edit</a>
	                    						<a href="<?= base_url("Mahasiswa/deleteTak/$key[id]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
            <div class="modal fade" id="newTakModal" tabindex="-1" aria-labelledby="newTakModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newTakModalLabel">Add New TAK</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('Mahasiswa/Tak') ?>" method="post">
            				<input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_nilai_mahasiswa" id="id_nilai_mahasiswa" value="<?= $nilai_mahasiswa['nmid'] ?>">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<input type="text" class="form-control" id="aktivitas" name="aktivitas" placeholder="Activity">
                                    <?= form_error('aktivitas','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Description">
                                    <?= form_error('deskripsi','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="semester" name="semester" placeholder="Semester">
                                    <?= form_error('semester','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Academy Year">
                                    <?= form_error('tahun_ajaran','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="poin" name="poin" placeholder="Point">
                                    <?= form_error('poin','<small class="text-danger pl-3">','</small>'); ?>
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

            