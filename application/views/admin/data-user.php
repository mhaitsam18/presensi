        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif ?>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                    	<div class="col-lg">
                            <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Data User</div>
                                <div class="card-body">
                            		<table class="table table-hover" id="dataTable">
                            			<thead>
                            				<tr>
                            					<th scope="col">#</th>
                            					<th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Date Created</th>
                                                <th scope="col">Image</th>
                            					<th scope="col">Action</th>
                            				</tr>
                            			</thead>
                            			<tbody>
                        					<?php $no=1; ?>
                            				<?php foreach ($user_data as $key): ?>
        	                    				<tr>
        	                    					<th scope="row"><?= $no ?></th>
        	                    					<td><?= $key['name'] ?></td>
                                                    <td><?= $key['email'] ?></td>
                                                    <td><?= $key['role'] ?></td>
                                                    <td>
                                                        <?php
                                                    if ($key['is_active']==1) {
                                                        echo "Active";
                                                    } else{
                                                        echo "Deactive";
                                                    } 
                                                     ?>     
                                                    </td>
                                                    <td><?= $key['date_created'] ?></td>
                                                    <td><img src="<?= base_url('assets/img/profile/').$key['image'] ?>" class="img-thumbnail"></td>
        	                    					<td>
        	                    						<a href="" class="badge badge-warning setRoleButton" data-toggle="modal" data-target="#setRoleModal" data-id="<?=$key['uid']?>">Set Role</a>
                                                        <?php if ($key['is_active']==1): ?>
                                                            <a href="<?= base_url('Auth/activated/'.$key['uid'].'/0') ?>" class="badge badge-danger">Deactive</a>
                                                        <?php else: ?>
                                                            <a href="<?= base_url('Auth/activated/'.$key['uid'].'/1') ?>" class="badge badge-success">Active</a>
                                                        <?php endif ?>
        	                    					</td>
        	                    				</tr>
        	                    			<?php $no++; ?>
                            				<?php endforeach ?>
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
            <div class="modal fade" id="setRoleModal" tabindex="-1" aria-labelledby="setRoleLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="setRoleLabel">Set User Role</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('admin/setRole/') ?>" method="post">
                            <input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<input type="text" class="form-control" id="name" name="name" readonly>
	            				</div>
                                <div class="form-group">
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option value="">Select Role</option>
                                        <?php foreach ($role as $r): ?>
                                            <option value="<?= $r['id'] ?>"><?= $r['role'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
	            			</div>
	            			<div class="modal-footer">
	            				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	            				<button type="submit" class="btn btn-primary">Save</button>
	            			</div>
            			</form>
            		</div>
            	</div>
            </div>