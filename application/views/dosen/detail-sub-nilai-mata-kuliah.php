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
                    <div class="card mb-3">
                        <div class="card-header">
                            Nilai Mata Kuliah <?= $nilai_mata_kuliah['nama_mata_kuliah'] ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Nama
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $nilai_mata_kuliah['name'] ?>
                                </div>
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Indeks
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $nilai_mata_kuliah['indeks'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <label for="colFormLabelLg" class="col-sm-2">
                                    NIM
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $nilai_mata_kuliah['nim'] ?>
                                </div>
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Presensi
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $nilai_mata_kuliah['presensi']*100 ?>%
                                </div>
                            </div>
                            <div class="row">
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Kelas
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $nilai_mata_kuliah['kelas'] ?>
                                </div>
                                <label for="colFormLabelLg" class="col-sm-2">
                                    SKS
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $nilai_mata_kuliah['sks'] ?>
                                </div>
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#presensiModal">
                                Lihat Presensi
                            </button>
                        </div>
                    </div>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            if(isset($_POST['upload'])){ // Jika user menekan tombol Preview pada form
                                // Buat sebuah tag form untuk proses import data ke database
                                ?>
                                <form method='post' action="<?= base_url("Dosen/uploadDetailSubNilaiMataKuliah/".$this->uri->segment(3))?>">
                                    <div style='color: red;' id='kosong'>
                                    Semua data belum diisi, Ada <span id="jumlah_kosong"></span> data yang belum diisi.
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th colspan='5'>Preview Data</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Penilaian</th>
                                            <th>Bobot</th>
                                            <th>Nilai</th>
                                        </tr>
                                        <?php

                                    $numrow = 1;
                                    $kosong = 0;

                                // Lakukan perulangan dari data yang ada di excel
                                // $sheet adalah variabel yang dikirim dari controller
                                foreach($sheet as $row){
                                    // Ambil data pada excel sesuai Kolom
                                    $nama_penilaian = $row['A']; // Ambil data NIS
                                    $bobot = $row['B']; // Ambil data nama
                                    $nilai = $row['C']; // Ambil data jenis kelamin

                                    // Cek jika semua data tidak diisi
                                    if($nama_penilaian == "" && $bobot == "" && $nilai == "")
                                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                    // Cek $numrow apakah lebih dari 1
                                    // Artinya karena baris pertama adalah nama-nama kolom
                                    // Jadi dilewat saja, tidak usah diimport
                                    if($numrow > 1){
                                        // Validasi apakah semua data telah diisi
                                        $nama_penilaian_td = ( ! empty($nama_penilaian))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                        $bobot_td = ( ! empty($bobot))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $nilai_td = ( ! empty($nilai))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        
                                        // Jika salah satu data ada yang kosong
                                        if($nama_penilaian == "" or $bobot == "" or $nilai == ""){
                                            $kosong++; // Tambah 1 variabel $kosong
                                        }

                                        echo "<tr>";
                                        echo "<td".$nama_penilaian_td.">".$nama_penilaian."</td>";
                                        echo "<td".$bobot_td.">".$bobot."</td>";
                                        echo "<td".$nilai_td.">".$nilai."</td>";
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
                                    echo "<a href='".base_url("Dosen/detailSubNilaiMataKuliah/".$this->uri->segment(3))."' class='btn btn-secondary mb-3  mr-1'>Cancel</a>";
                                    echo "<button type='submit' name='import' class='btn btn-success mb-3 mr-1'>Import</button>";

                                    form_error('nama_penilaian','<div class="alert alert-danger" role="alert">','</div>');
                                    form_error('bobot','<div class="alert alert-danger" role="alert">','</div>');
                                    form_error('nilai','<div class="alert alert-danger" role="alert">','</div>');
                                    form_error('id_nilai_mata_kuliah','<div class="alert alert-danger" role="alert">','</div>');
                                
                                }

                                echo "</form>";
                            }
                            ?>
                            <a href="" class="btn btn-primary mb-3 newDetailSubNilaiMataKuliahModalButton" data-toggle="modal" data-target="#newDetailSubNilaiMataKuliahModal">Add New Score</a>
                            <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#newUploadDetailSubNilaiMataKuliahModal">
                                <i class="fas fa-upload"></i>
                                Upload
                            </button>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Penilaian</th>
                                        <th scope="col">Bobot</th>
                                        <th scope="col">Nilai</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; ?>
                                    <?php foreach ($sub_nilai_mata_kuliah as $key): ?>
                                        <tr>
                                            <th scope="row"><?= $no ?></th>
                                            <td><?= $key['nama_penilaian'] ?></td>
                                            <td><?= $key['bobot']*100 ?>%</td>
                                            <td><?= $key['nilai'] ?></td>
                                            <td>
                                                <a href="<?= base_url("Dosen/updateSubNilaiMataKuliah/$key[id]/detail"); ?>" class="badge badge-success updateDetailSubNilaiMataKuliahModalButton" data-toggle="modal" data-target="#newDetailSubNilaiMataKuliahModal" data-id="<?=$key['id']?>">Edit</a>
                                                <a href="<?= base_url("Dosen/deleteSubNilaiMataKuliah/$key[id]/$nilai_mata_kuliah[nmkid]/detail"); ?>" class="badge badge-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php $no++; ?>
                                    <?php endforeach ?>
                                    <?php if (!$sub_nilai_mata_kuliah): ?>
                                        <tr>
                                            <th colspan="5" style="text-align: center;">Data Nilai Mahasiswa masih kosong</th>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Modal -->
            <div class="modal fade" id="newDetailSubNilaiMataKuliahModal" tabindex="-1" aria-labelledby="newDetailSubNilaiMataKuliahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newDetailSubNilaiMataKuliahModalLabel">Add New Score</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url("Dosen/").$this->uri->segment(2)."/".$this->uri->segment(3)."/detail" ?>" method="post">
                            <input type="hidden" name="id" id="id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <select class="form-control" name="id_nilai_mata_kuliah" id="id_nilai_mata_kuliah">
                                        <option value="">Select Component Score</option>
                                        <option value="<?= $nilai_mata_kuliah['nmkid'] ?>"><?= $nilai_mata_kuliah['name'].' | '.$nilai_mata_kuliah['nama_mata_kuliah'].$nilai_mata_kuliah['nmkid'] ?></option>
                                    </select>
                                    <?= form_error('id_nilai_mata_kuliah','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_penilaian" name="nama_penilaian" placeholder="Score Name">
                                    <?= form_error('nama_penilaian','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" step='0.01' id="bobot" name="bobot" placeholder="Value">
                                    <?= form_error('bobot','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" step="0.01" id="nilai" name="nilai" placeholder="Score">
                                    <?= form_error('nilai','<small class="text-danger pl-3">','</small>'); ?>
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
            <!-- Modal -->
            <div class="modal fade" id="presensiModal" tabindex="-1" aria-labelledby="presensiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="presensiModalLabel">Presensi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <canvas id="myChart" width="400" height="400"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <a href="" type="button" class="btn btn-success">
                                Cetak PDF <i class="fas fa-print"></i>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?= base_url('assets/'); ?>js/Chart.js"></script>
            <script type="text/javascript">
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Hadir", "Alpa"],
                        datasets: [{
                            label: '# of Votes',
                            data: [<?php 
                                $a = $nilai_mata_kuliah['presensi'];
                                $b = 1 - $a;
                                $a = $a * 16;
                                $b = $b * 16;
                                echo "$a,$b";
                             ?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            </script>
            <div class="modal fade" id="newUploadDetailSubNilaiMataKuliahModal" tabindex="-1" aria-labelledby="newUploadDetailSubNilaiMataKuliahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newUploadDetailSubNilaiMataKuliahModalLabel">Upload Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('Dosen/detailSubNilaiMataKuliah/').$this->uri->segment(3) ?>" method="post" enctype="multipart/form-data">
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
                                <a href="<?= base_url('excel/format_sub_nilai.xlsx') ?>" class="btn btn-warning">
                                    <i class="fas fa-file-excel"></i>
                                    Download Format Excel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>