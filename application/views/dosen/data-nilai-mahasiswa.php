        <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
        <script>
            $(document).ready(function(){
                // Sembunyikan alert validasi kosong
                $("#kosong").hide();
            });
        </script>
        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                    	<div class="col-lg-12">
                            <?php
                            if(isset($_POST['upload'])){ // Jika user menekan tombol Preview pada form
                                // Buat sebuah tag form untuk proses import data ke database
                                ?>
                                <form method='post' action="<?= base_url("Dosen/uploadNilaiMahasiswa/".$this->uri->segment(3))?>">
                                    <div style='color: red;' id='kosong'>
                                    Semua data belum diisi, Ada <span id="jumlah_kosong"></span> data yang belum diisi.
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th colspan='5'>Preview Data</th>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <th>IPK</th>
                                            <th>TAK</th>
                                        </tr>
                                        <?php

                                    $numrow = 1;
                                    $kosong = 0;

                                // Lakukan perulangan dari data yang ada di excel
                                // $sheet adalah variabel yang dikirim dari controller
                                foreach($sheet as $row){
                                    // Ambil data pada excel sesuai Kolom
                                    $nim = $row['A']; // Ambil data NIS
                                    $ipk = $row['B']; // Ambil data nama
                                    $tak = $row['C']; // Ambil data jenis kelamin
                                    
                                    // Cek jika semua data tidak diisi
                                    if($nim == "" && $ipk == "" && $tak == "")
                                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                    // Cek $numrow apakah lebih dari 1
                                    // Artinya karena baris pertama adalah nama-nama kolom
                                    // Jadi dilewat saja, tidak usah diimport
                                    if($numrow > 1){
                                        // Validasi apakah semua data telah diisi
                                        $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                        $ipk_td = ( ! empty($ipk))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $tak_td = ( ! empty($tak))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        
                                        // Jika salah satu data ada yang kosong
                                        if($nim == "" or $ipk == "" or $tak == ""){
                                            $kosong++; // Tambah 1 variabel $kosong
                                        }

                                        echo "<tr>";
                                        echo "<td".$nim_td.">".$nim."</td>";
                                        echo "<td".$ipk_td.">".$ipk."</td>";
                                        echo "<td".$tak_td.">".$tak."</td>";
                                        echo "</tr>";
                                    }

                                    $numrow++; // Tambah 1 setiap kali looping
                                }

                                echo "</table>";

                                // Cek apakah variabel kosong lebih dari 0
                                // Jika lebih dari 0, berarti ada data yang masih kosong
                                if($kosong > 0){
                                ?>
                                    <script>
                                    $(document).ready(function(){
                                        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                                        $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                                        $("#kosong").show(); // Munculkan alert validasi kosong
                                    });
                                    </script>
                                <?php
                                }else{ // Jika semua data sudah diisi
                                    echo "<hr>";

                                    // Buat sebuah tombol untuk mengimport data ke database
                                    echo "<a href='".base_url("Dosen/nilaiMahasiswa/".$this->uri->segment(3))."' class='btn btn-secondary mb-3  mr-1'>Cancel</a>";
                                    echo "<button type='submit' name='import' class='btn btn-success mb-3 mr-1'>Import</button>";

                                    form_error('id_mahasiswa','<div class="alert alert-danger" role="alert">','</div>');
                                    form_error('ipk','<div class="alert alert-danger" role="alert">','</div>');
                                    form_error('tak','<div class="alert alert-danger" role="alert">','</div>');
                                
                                }

                                echo "</form>";
                            }
                            ?>
                    		<!-- <a href="" class="btn btn-primary mb-3 newNilaiMahasiswaModalButton" data-toggle="modal" data-target="#newNilaiMahasiswaModal">Add New Student Score</a>
                    		<a href="" class="btn btn-success mb-3 newUploadNilaiMahasiswaModalButton" data-toggle="modal" data-target="#newUploadNilaiMahasiswaModal">
                                <i class="fas fa-upload"></i>
                                <span>Upload Data</span>
                            </a> -->
                            <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Data Nilai Mahasiswa</div>
                                <div class="card-body">
                                    
                                    <table class="table table-hover" id="dataTable">
                            			<thead>
                            				<tr>
                            					<th scope="col">#</th>
                                                <th scope="col">NIM</th>
                            					<th scope="col">Nama</th>
                                                <th scope="col">Kelas</th>
                                                <th scope="col">IPK</th>
                                                <th scope="col">TAK</th>
                                                <th scope="col">Total SKS</th>
                            					<th scope="col">Action</th>
                            				</tr>
                            			</thead>
                            			<tbody>
                        					<?php $no=1; ?>
                            				<?php foreach ($nilai_mahasiswa as $key): ?>
                                				<tr>
                                					<th scope="row"><?= $no ?></th>
                                					<td><?= $key['nim'] ?></td>
                                                    <td><?= $key['name'] ?></td>
                                                    <td><?= $key['kelas'] ?></td>
                                                    <td><?= $key['ipk'] ?></td>
                                                    <td><?= $key['tak'] ?></td>
                                                    <td><?= $key['sum_sks'] ?></td>
                                					<td>
                                						<a href="" class="badge badge-warning"><i class="fas fa-download"></i></a>
                                                        <a href="<?= base_url("Dosen/nilaiMataKuliah/$key[nmid]"); ?>" class="badge badge-primary">Detail</a>
                                                        <a href="<?= base_url("Dosen/updateNilaiMahasiswa/$key[nmid]"); ?>" class="badge badge-success updateNilaiMahasiswaModalButton" data-toggle="modal" data-target="#newNilaiMahasiswaModal" data-id="<?=$key['nmid']?>">Edit</a>
                                						<a href="<?= base_url("Dosen/deleteNilaiMahasiswa/$key[nmid]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                					</td>
                                				</tr>
                                			<?php $no++; ?>
                            				<?php endforeach ?>
                                            <?php if (!$nilai_mahasiswa): ?>
                                                <tr>
                                                    <th colspan="8" style="text-align: center;">Tidak ada Mahasiswa di Kelas Anda</th>
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
            <div class="modal fade" id="newNilaiMahasiswaModal" tabindex="-1" aria-labelledby="newNilaiMahasiswaModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newNilaiMahasiswaModalLabel">Add New Student Score</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('Dosen/nilaiMahasiswa') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
                                    <select class="form-control" name="id_mahasiswa" id="id_mahasiswa">
                                        <option value="">Select Student</option>
                                        <?php foreach ($mahasiswa as $key): ?>
                                            <option value="<?= $key['mid'] ?>"><?= $key['nim'].' | '.$key['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_mahasiswa','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <input type="number" class="form-control" step="0.01" id="ipk" name="ipk" placeholder="IPK">
                                    <?= form_error('ipk','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="tak" name="tak" placeholder="TAK">
                                    <?= form_error('tak','<small class="text-danger pl-3">','</small>'); ?>
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

            <div class="modal fade" id="newUploadNilaiMahasiswaModal" tabindex="-1" aria-labelledby="newUploadNilaiMahasiswaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newUploadNilaiMahasiswaModalLabel">Upload Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('Dosen/nilaiMahasiswa') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            <div class="modal-body">
                                <label for="inputGroupFile02">
                                    Upload Data Excel
                                </label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file">
                                        <label class="custom-file-label" for="file" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload">
                                <a href="<?= base_url('excel/format_nilai_mahasiswa.xlsx') ?>" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i>
                                    Download Format Excel
                                </a>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            