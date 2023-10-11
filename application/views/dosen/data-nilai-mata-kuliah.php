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
                                <form method='post' action="<?= base_url("Dosen/uploadNilaiMataKuliah/".$this->uri->segment(3))?>">
                                    <div style='color: red;' id='kosong'>
                                    Semua data belum diisi, Ada <span id="jumlah_kosong"></span> data yang belum diisi.
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th colspan='5'>Preview Data</th>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Indeks</th>
                                            <th>Presensi</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Semester</th>
                                            <th>ID Pengampu</th>
                                        </tr>
                                        <?php

                                    $numrow = 1;
                                    $kosong = 0;

                                // Lakukan perulangan dari data yang ada di excel
                                // $sheet adalah variabel yang dikirim dari controller
                                foreach($sheet as $row){
                                    // Ambil data pada excel sesuai Kolom
                                    $nim = $row['A']; // Ambil data NIS
                                    $indeks = $row['B']; // Ambil data nama
                                    $presensi = $row['C']; // Ambil data jenis kelamin
                                    $tahun_ajaran = $row['D']; // Ambil data NIS
                                    $semester = $row['E']; // Ambil data nama
                                    $id_pengampu = $row['F']; // Ambil data jenis kelamin

                                    // Cek jika semua data tidak diisi
                                    if($nim == "" && $indeks == "" && $presensi == "" && $tahun_ajaran == "" && $semester == "" && $id_pengampu == "")
                                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                    // Cek $numrow apakah lebih dari 1
                                    // Artinya karena baris pertama adalah nama-nama kolom
                                    // Jadi dilewat saja, tidak usah diimport
                                    if($numrow > 1){
                                        // Validasi apakah semua data telah diisi
                                        $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                        $indeks_td = ( ! empty($indeks))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $presensi_td = ( ! empty($presensi))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        $tahun_ajaran_td = ( ! empty($tahun_ajaran))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        $semester_td = ( ! empty($semester))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        $id_pengampu_td = ( ! empty($id_pengampu))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        
                                        // Jika salah satu data ada yang kosong
                                        if($nim == "" or $indeks == "" or $presensi == "" or $tahun_ajaran == "" or $semester == "" or $id_pengampu == ""){
                                            $kosong++; // Tambah 1 variabel $kosong
                                        }

                                        echo "<tr>";
                                        echo "<td".$nim_td.">".$nim."</td>";
                                        echo "<td".$indeks_td.">".$indeks."</td>";
                                        echo "<td".$presensi_td.">".$presensi."</td>";
                                        echo "<td".$tahun_ajaran_td.">".$tahun_ajaran."</td>";
                                        echo "<td".$semester_td.">".$semester."</td>";
                                        echo "<td".$id_pengampu_td.">".$id_pengampu."</td>";
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
                                    echo "<a href='".base_url("Dosen/nilaiMataKuliah/".$this->uri->segment(3))."' class='btn btn-secondary mb-3  mr-1'>Cancel</a>";
                                    echo "<button type='submit' name='import' class='btn btn-success mb-3 mr-1'>Import</button>";

                                    form_error('id_dosen','<div class="alert alert-danger" role="alert">','</div>');
                                    form_error('id_mata_kuliah','<div class="alert alert-danger" role="alert">','</div>');
                                
                                }

                                echo "</form>";
                            }
                            ?>
                            <?php if ($this->uri->segment(3) != ''): ?>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        Data Mahasiswa
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <label for="colFormLabelLg" class="col-sm-3">
                                                NIM
                                            </label>
                                            <div class="col-sm-9" id="colFormLabelLg">
                                                <?= $mhs['nim'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="colFormLabelLg" class="col-sm-3">
                                                Nama Lengkap
                                            </label>
                                            <div class="col-sm-9" id="colFormLabelLg">
                                                <?= $mhs['name'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="colFormLabelLg" class="col-sm-3">
                                                Kelas
                                            </label>
                                            <div class="col-sm-9" id="colFormLabelLg">
                                                <?= $mhs['kelas'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php endif ?>
                            <a href="" class="btn btn-primary mb-3 newNilaiMataKuliahModalButton" data-toggle="modal" data-target="#newNilaiMataKuliahModal">Add New Course Score</a>
                            <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#newUploadNilaiMataKuliahModal">
                                <i class="fas fa-upload"></i>
                                Upload 
                            </button>
                            <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Data Nilai Mata Kuliah</div>
                                <div class="card-body">
                                    <table class="table table-hover table-responsive" id="">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <!-- <th scope="col">NIM</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Kelas</th> -->
                                                <th scope="col">KodeMata Kuliah</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Indeks</th>
                                                <th scope="col">SKS</th>
                                                <th scope="col">Presensi</th>
                                                <th scope="col">Tahun Ajaran</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Dosen Pengampu</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; ?>
                                            <?php foreach ($nilai_mata_kuliah as $key): ?>
                                                <tr>
                                                    <th scope="row"><?= $no ?></th>
                                                    <!-- <td><?= $key['nim'] ?></td>
                                                    <td><?= $key['name'] ?></td>
                                                    <td><?= $key['kelas'] ?></td> -->
                                                    <td><?= $key['kode_mata_kuliah'] ?></td>
                                                    <td><?= $key['nama_mata_kuliah'] ?></td>
                                                    <td><?= $key['indeks'] ?></td>
                                                    <td><?= $key['sks'] ?></td>
                                                    <td><?= $key['presensi']*100 . '%' ?></td>
                                                    <td><?= $key['tahun_ajaran'] ?></td>
                                                    <td><?= $key['nmk_semester'] ?></td>
                                                    <td><?= $key['kode_dosen'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url("Dosen/detailSubNilaiMataKuliah/$key[nmkid]"); ?>" class="badge badge-primary">Detail</a>
                                                        <a href="<?= base_url("Dosen/updateNilaiMataKuliah/$key[nmkid]"); ?>" class="badge badge-success updateNilaiMataKuliahModalButton" data-toggle="modal" data-target="#newNilaiMataKuliahModal" data-id="<?=$key['nmkid']?>">Edit</a>
                                                        <a href="<?= base_url("Dosen/deleteNilaiMataKuliah/$key[nmkid]/$key[id_nilai_mahasiswa]"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php $no++; ?>
                                            <?php endforeach ?>
                                            <?php if (!$nilai_mata_kuliah): ?>
                                                <tr>
                                                    <th colspan="12" style="text-align: center;">Tidak ada Mahasiswa di Kelas Anda</th>
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
            <div class="modal fade" id="newNilaiMataKuliahModal" tabindex="-1" aria-labelledby="newNilaiMataKuliahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newNilaiMataKuliahModalLabel">Add New Student Score</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url("Dosen/").$this->uri->segment(2) ?>" method="post">
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
                                    <select class="form-control" name="indeks" id="indeks">
                                        <option>Select Index</option>
                                        <option value="A">A</option>
                                        <option value="AB">AB</option>
                                        <option value="B">B</option>
                                        <option value="BC">BC</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="T">T</option>
                                    </select>
                                    <?= form_error('indeks','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="number" class="form-control" name="presensi1" id="presensi1" placeholder="Total Course">
                                            <?= form_error('presensi2','<small class="text-danger pl-3">','</small>'); ?>
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" name="presensi2" id="presensi2" placeholder="Total Presence">
                                            <?= form_error('presensi1','<small class="text-danger pl-3">','</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="presensi" name="presensi" placeholder="Presence" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Academic Year">
                                    <?= form_error('tahun_ajaran','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="semester" name="semester" placeholder="Semester">
                                    <?= form_error('semester','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_pengampu" id="id_pengampu">
                                        <option value="">Select Lecturer's Course</option>
                                        <?php foreach ($pengampu as $key): ?>
                                            <option value="<?= $key['pid'] ?>"><?= $key['nama_mata_kuliah'].' | '.$key['kode_dosen'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_pengampu','<small class="text-danger pl-3">','</small>'); ?>
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
            <div class="modal fade" id="newUploadNilaiMataKuliahModal" tabindex="-1" aria-labelledby="newUploadNilaiMataKuliahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newUploadNilaiMataKuliahModalLabel">Upload Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('Dosen/nilaiMataKuliah') ?>" method="post" enctype="multipart/form-data">
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
                                <a href="<?= base_url('excel/format_nilai_matkul.xlsx') ?>" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i>
                                    Download Format Excel
                                </a>
                                <a href="<?= base_url('Dosen/downloadDataPengampu') ?>" target="_blank" class="btn btn-danger">
                                    <i class="fas fa-file-pdf"></i>
                                    Download Data ID Pengampu PDF
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>