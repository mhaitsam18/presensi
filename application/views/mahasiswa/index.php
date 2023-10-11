        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

                	<div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-sticky-note"></i> Catatan
                        </div>
                        <div class="card-body">
                            <?php foreach ($catatan as $c): ?>
                                <h5 class="h4 card-title text-dark"><?= $c['subjek'].' - '.date('j F Y H:i:s', strtotime($c['waktu_post'])) ?></h5>
                                <p class="card-text"><?= $c['catatan'] ?></p>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <div class="card mb-3">
                		<div class="card-header">
                			My Perform
                		</div>
                		<div class="card-body">
                			<div class="row">
                				<label for="colFormLabelLg" class="col-sm-2">
                					Nama
                				</label>
                				<div class="col-sm-4" id="colFormLabelLg">
                					<?= $mahasiswa['name'] ?>
                				</div>
                				<label for="colFormLabelLg" class="col-sm-2">
                					IPK
                				</label>
                				<div class="col-sm-4" id="colFormLabelLg">
                					<?= $nilai_mahasiswa['ipk'] ?>
                				</div>
                			</div>
                			<div class="row">
                				<label for="colFormLabelLg" class="col-sm-2">
                					NIM
                				</label>
                				<div class="col-sm-4" id="colFormLabelLg">
                					<?= $mahasiswa['nim'] ?>
                				</div>
                				<label for="colFormLabelLg" class="col-sm-2">
                					TAK
                				</label>
                				<div class="col-sm-4" id="colFormLabelLg">
                					<?= $nilai_mahasiswa['tak'] ?>
                				</div>
                			</div>
                			<div class="row">
                				<label for="colFormLabelLg" class="col-sm-2">
                					Kelas
                				</label>
                				<div class="col-sm-4" id="colFormLabelLg">
                					<?= $mahasiswa['kelas'] ?>
                				</div>
                				<label for="colFormLabelLg" class="col-sm-2">
                					Total SKS
                				</label>
                				<div class="col-sm-4" id="colFormLabelLg">
                					<?= $sum_sks['sum_sks'] ?>
                				</div>
                			</div>
                            <div class="row">
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Nilai Semester
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#performaModal">
                                        Lihat IP Semester
                                    </button>
                                </div>
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Lihat Pencapaian TAK
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#performa2Modal">
                                        Lihat Pencapaian TAK
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Presensi
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#presensiModal">
                                        Lihat Presensi
                                    </button>
                                </div>
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Nilai Semester
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ipkModal">
                                        Lihat IPK
                                    </button>
                                </div>
                            </div>
                			
                		</div>
                	</div>

                	<div class="card mb-4">
                        <div class="card-header"><i class="fas fa-table mr-1"></i>Tabel Admin</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Mata Kuliah</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>SKS</th>
                                            <th>Indeks</th>
                                            <th>Presensi</th>
                                            <th>Semester</th>
                                            <th>Nilai Mutu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php $no = 1; ?>
                                    	<?php foreach ($nilai_mata_kuliah as $key): ?>
                                    		<tr>
                                    			<th><?= $no ?></th>
                                    			<td><?= $key['kode_mata_kuliah'] ?></td>
                                    			<td><?= $key['nama_mata_kuliah'] ?></td>
                                    			<td><?= $key['sks'] ?></td>
                                    			<td><?= $key['indeks'] ?></td>
                                    			<td><?= ($key['presensi']*100).'%' ?></td>
                                    			<td><?= $key['nmk_semester'] ?></td>
                                    			<td><?= nilaiMutuIndeks($key['indeks'], $key['sks']) ?></td>
                                    			<td>
                                    				<a href="<?= base_url("mahasiswa/detail/$key[nmkid]?id_mahasiswa=$key[mid]&nama_mata_kuliah=$key[nama_mata_kuliah]") ?>" class="badge badge-primary">Detail</a>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Button trigger modal -->
            <!-- Modal -->
            <div class="modal fade" id="performaModal" tabindex="-1" aria-labelledby="performaModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="performaModalLabel">Performaku</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<div class="modal-body">
                			<canvas id="myChart" width="400" height="400"></canvas>
            			</div>
            			<div class="modal-footer">
            				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            				<a href="" type="button" class="btn btn-outline-success">
                                <i class="fas fa-print"></i>
                                Cetak PDF
                            </a>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="modal fade" id="ipkModal" tabindex="-1" aria-labelledby="ipkModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ipkModalLabel">IPK Mahasiswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <canvas id="myIPK" width="400" height="400"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="<?= base_url('dosen/print/').$mahasiswa['mid'] ?>" type="button" class="btn btn-outline-success" target="_blank">
                                <i class="fas fa-print"></i>
                                Print
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="performa2Modal" tabindex="-1" aria-labelledby="performa2ModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="performa2ModalLabel">Pencapaian TAK</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"><?php 
                            $pencapaian_tak = $nilai_mahasiswa['tak']/45*100;
                            if ($nilai_mahasiswa['tak'] <= 0) {
                                $color = 'danger';
                                $keterangan = 'TAK masih Kosong';
                            } elseif ($nilai_mahasiswa['tak'] <= 10) {
                                $color = 'secondary';
                                $keterangan = 'TAK jauh dari target';
                            } elseif ($nilai_mahasiswa['tak'] < 45) {
                                $color = 'primary';
                                $keterangan = 'TAK mendekati target';
                            } elseif ($nilai_mahasiswa['tak'] == 45) {
                                $color = 'success';
                                $keterangan = 'Selamat! TAK mencapai target';
                            } else{
                                $color = 'info';
                                $keterangan = 'Selamat! TAK melampaui target';
                            }
                             ?>
                            <h4 class="small font-weight-bold">TAK: <?= $nilai_mahasiswa['tak'] ?> / 45<span class="float-right"><?= number_format($pencapaian_tak,2) ?>%</span></h4>
                            <div class="progress mb-1">
                                <div class="progress-bar bg-<?= $color  ?>" role="progressbar" style="width: <?= $pencapaian_tak ?>%" aria-valuenow="<?= $pencapaian_tak ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <h4 class="small font-weight-bold"><span class="float-right text-<?= $color ?>"><?= $keterangan ?></span></h4>
                            <!-- <canvas id="myPerforma" width="400" height="400"></canvas> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="" type="button" class="btn btn-outline-success">
                                <i class="fas fa-print"></i>
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="detailNilaiModal" tabindex="-1" aria-labelledby="detailNilaiModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="detailNilaiModalLabel">Detail Nilai</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<div class="modal-body">

            			</div>
            			<div class="modal-footer">
            				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            				<button type="button" class="btn btn-primary">Save changes</button>
            			</div>
            		</div>
            	</div>
            </div>

            <div class="modal fade" id="presensiModal" tabindex="-1" aria-labelledby="presensiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="presensiModalLabel">Presensi Mahasiswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <canvas id="myPresence" width="400" height="400"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="<?= base_url('mahasiswa/print/').$mahasiswa['mid']; ?>" type="button" class="btn btn-outline-success">
                                <i class="fas fa-print"></i>
                                Print
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <script src="<?= base_url('assets/'); ?>js/Chart.js"></script>
            <script type="text/javascript">
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Semester I", "Semester II", "Semester III", "Semester IV", "Semester V", "Semester VI"],
                        datasets: [{
                            label: 'IP Semester',
                            data: [
                            <?php 
                            for ($i=0; $i < 6; $i++) { 
                                echo $ip[$i],", ";
                            }
                             ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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

            <script type="text/javascript">
                var ctx = document.getElementById("myIPK").getContext('2d');
                var myIPK = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Semester I", "Semester II", "Semester III", "Semester IV", "Semester V", "Semester VI"],
                        datasets: [{
                            label: '#IPK',
                            data: [
                            <?php 
                            for ($i=0; $i < 6; $i++) { 
                                echo $ipk[$i],", ";
                            }
                             ?>
                            ],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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

            <script type="text/javascript">
                var ctx = document.getElementById("myPresence").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Semester I", "Semester II", "Semester III", "Semester IV", "Semester V", "Semester VI"],
                        datasets: [{
                            label: '# Presensi %',
                            data: [
                            <?php
                            foreach ($presensi_semester as $key) {
                                $hasil = $key['sum_presensi']/$key['count_presensi']*100;
                                echo "$hasil, ";
                            }
                             ?>
                            ],
                            backgroundColor: [
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(153, 102, 255, 1)',
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                display: true,
                                position: 'left',
                                ticks: {
                                    max: 100,
                                    beginAtZero:true,
                                    callback: function(value) {
                                        return value + "%";
                                    }
                                },
                                scaleLabel:{
                                    position: 'top',
                                    display: true,
                                    labelString: 'Persentase kehadiran Mahasiswa',
                                    fontColor: "#546372"
                                }
                            }]
                        }
                    }
                });
            </script>
            
            <script type="text/javascript">
                var ctx = document.getElementById("myPerforma").getContext('2d');
                var myPerforma = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["TAK", "IPK", "Presensi"],
                        datasets: [{
                            label: '# of Votes',
                            data: [
                            <?php
                            $tak = $nilai_mahasiswa['tak']/20;
                            $ipk = $nilai_mahasiswa['ipk']/4*10;
                            $presence = ($presensi['sum_presensi']/$presensi['count_presensi'])*10;
                            echo "$tak, $ipk, $presence";
                             ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
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