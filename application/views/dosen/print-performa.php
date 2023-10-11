        <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                	<div class="card mb-3">
                		<div class="card-header">
                			Data Mahasiswa
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
                                    Nama Wali
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $mahasiswa['nama_wali'] ?>
                                </div>
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Pekerjaan Wali
                                </label>
                                <div class="col-sm-4" id="colFormLabelLg">
                                    <?= $mahasiswa['pekerjaan_wali'] ?>
                                </div>
                            </div>
                           <div class="row">
                                <label for="colFormLabelLg" class="col-sm-2">
                                    Asal
                                </label>
                                <div class="col-sm-10" id="colFormLabelLg">
                                    <?= $mahasiswa['asal_daerah'] ?>
                                </div>
                            </div>
                		</div>
                	</div>
                	<div class="card mb-4">
                        <div class="card-header"><i class="fas fa-table mr-1"></i>Tabel Admin</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
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
                                    		</tr>
                                    		<?php $no++; ?>
                                    	<?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>TAK</div>
                                <div class="card-body">
                                    <?php 
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
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Grafik IP Mahasiswa</div>
                                <div class="card-body">
                                    <div class="row">
                                        <canvas id="myChart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Grafik IPK Mahasiswa</div>
                                <div class="card-body">
                                    <div class="row">
                                    <canvas id="myIPK" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">    
                            <div class="card mb-4">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Grafik Presensi</div>
                                <div class="card-body">
                                    <div class="row">
                                        <canvas id="myPresence" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <script src="<?= base_url('assets/'); ?>js/Chart.js"></script>
            <script type="text/javascript">
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Semester I", "Semester II", "Semester III", "Semester IV", "Semester V", "Semester VI"],
                        datasets: [{
                            label: '#IP',
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
                        animation: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    },
                    animation: {
                        duration: 0, 
                    }, 
                    hover: {
                        animationDuration: 0, 
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
                        animation: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    },
                    animation: {
                        duration: 0, 
                    }, 
                    hover: {
                        animationDuration: 0, 
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
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        animation: false,
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
                    },
                    animation: {
                        duration: 0, 
                    }, 
                    hover: {
                        animationDuration: 0, 
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
                            label: '#Performa',
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
                        animation: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    },
                    animation: {
                        duration: 0, 
                    }, 
                    hover: {
                        animationDuration: 0, 
                    }
                });
            </script>

            <script type="text/javascript">
                window.print();
            </script>