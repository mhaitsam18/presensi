    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
        	<div class="col-lg-6">
        		<table class="table table-hover">
        			<thead>
        				<tr>
        					<th scope="col">#</th>
                            <th scope="col">ID Pengampu</th>
        					<th scope="col">Kode Dosen</th>
                            <th scope="col">Nama Mata Kuliah</th>
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

<script type="text/javascript">
    window.print();
</script>