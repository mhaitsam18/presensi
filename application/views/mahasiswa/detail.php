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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Lihat Presensi
                            </button>

                        </div>
                    </div>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Penilaian</th>
                                        <th scope="col">Bobot</th>
                                        <th scope="col">Nilai</th>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <canvas id="myChart" width="400" height="400"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="" type="button" class="btn btn-success">
                                Cetak PDF <i class="fas fa-print"></i>
                            </a>
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