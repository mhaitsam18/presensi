        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Mahasiswa</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $value_mahasiswa['jml_mhs'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Rata-rata IPK</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($value_mahasiswa2['avg_ipk'],2) ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata TAK
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= number_format($value_mahasiswa2['avg_tak']) ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Kehadiran</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($value_mahasiswa3['avg_presensi']*100,2) ?> %</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row col-xl-12">
                        <div class="dropdown mb-4">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownTahunAjaran" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if (!empty($cur_tahun_ajaran)): ?>
                                    Tahun Ajaran <?= $cur_tahun_ajaran; ?>
                                <?php else: ?>
                                    Periode Akademik
                                <?php endif ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownTahunAjaran">
                                <a class="dropdown-item" href="<?= base_url('Kaprodi/') ?>">All school years</a>
                                <?php foreach ($tahun_ajaran as $row): ?>
                                    <?php $tahun = str_replace('/', '_', $row['tahun_ajaran']) ?>
                                    <?php if ($this->uri->segment(3) == $tahun): ?>
                                        <a class="dropdown-item active" href="<?= base_url('Kaprodi/index/').$tahun ?>"><?= $row['tahun_ajaran'] ?></a>
                                    <?php else: ?>
                                        <a class="dropdown-item" href="<?= base_url('Kaprodi/index/').$tahun ?>"><?= $row['tahun_ajaran'] ?></a>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <?php if ($this->uri->segment(2) !=''): ?>
                            
                        <div class="dropdown mb-4 ml-3">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownSemester" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if (!empty($cur_semester)): ?>
                                    Semester <?= $cur_semester; ?>
                                <?php else: ?>
                                    Pilih Semester
                                <?php endif ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownSemester">
                                <a class="dropdown-item" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/' ?>">All Semester</a>
                                <?php $tahun = str_replace('/', '_', $row['tahun_ajaran']) ?>
                                <?php if ($this->uri->segment(4) == 'Ganjil'): ?>
                                    <a class="dropdown-item active" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/Ganjil' ?>">Ganjil</a>
                                    <a class="dropdown-item" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/Genap' ?>">Genap</a>
                                <?php elseif ($this->uri->segment(4) == 'Genap'): ?>
                                    <a class="dropdown-item" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/Ganjil' ?>">Ganjil</a>
                                    <a class="dropdown-item active" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/Genap' ?>">Genap</a>
                                <?php else: ?>

                                    <a class="dropdown-item" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/Ganjil' ?>">Ganjil</a>
                                    <a class="dropdown-item" href="<?= base_url('Kaprodi/index/').$this->uri->segment(3).'/Genap' ?>">Genap</a>
                                <?php endif ?>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>

                    <?php if ($this->uri->segment(3) != ''): ?>
                        <div class="row col-xl-12 mb-4">
                            <?php foreach ($angkatan as $a): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input cek_angkatan" type="checkbox" name="angkatan" id="angkatan_<?= $a['angkatan']; ?>" value="<?= $a['angkatan']; ?>" <?= cek_angkatan($a['angkatan'], $arr_angkatan); ?>>
                                    <label class="form-check-label" for="angkatan_<?= $a['angkatan']; ?>">Angkatan <?= $a['angkatan']; ?></label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Rata-rata IPK Per Semester</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="ipkChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Pekerjaan Orang Tua</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="pekerjaanChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <?php $a = 0; ?>
                                        <?php foreach ($pekerjaan_wali as $row): ?>
                                            <?php $warna = ""; 
                                            $nilai = "1234567890abcdef";
                                                for($i = 0;$i <6;$i++){
                                                    $warna .= $nilai[rand(0,strlen($nilai) - 1)];
                                                }
                                                $color_pekerjaan[$a] = $warna;
                                                $a++;
                                                 ?>
                                            <span class="mr-2">
                                                <i class="fas fa-circle" style="color: <?= '#'.$warna ?>;"></i><?= $row['pekerjaan_wali'].' '.number_format(($row['count_pekerjaan']*100/$count_pekerjaan['count_pekerjaan'])).' %'; ?>
                                            </span>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Pendidikan Terakhir Orang Tua</h6>
                                </div>
                                <div class="card-body">
                                    <?php 
                                    foreach ($pendidikan_wali as $row) { ?>
                                        <?php
                                        $persentase_pendidikan =  number_format($row['count_pendidikan']*100/$count_pendidikan['count_pendidikan']) ?>
                                        <h4 class="small font-weight-bold"><?= $row['pendidikan'] ?><span class="float-right"><?= $persentase_pendidikan ?>%</span></h4>
                                        <div class="progress mb-4">
                                            <?php switch ($row['pid']) {
                                                case 1: $color = "danger"; break;
                                                case 2: $color = "warning"; break;
                                                case 3: $color = "dark"; break;
                                                case 4: $color = "success"; break;
                                                case 5: $color = "info"; break;
                                                case 6: $color = "secondary"; break;
                                                case 7: $color = "primary"; break;
                                                case 8: $color = "danger"; break;
                                                case 9: $color = "dark"; break;
                                                default: $color = "secondary"; break;
                                            } ?>
                                            <div class="progress-bar bg-<?=$color ?>  " role="progressbar" style="width: <?= $persentase_pendidikan ?>%"
                                                aria-valuenow="<?= $persentase_pendidikan ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <?php
                                    }
                                     ?>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Rata-rata Kehadiran Per Semester</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="presensiChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Daerah Asal Mahasiswa</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="asalChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <?php $a = 0; ?>
                                        <?php foreach ($asal_daerah as $row): ?>
                                            <?php $warna = ""; 
                                            $nilai = "1234567890abcdef";
                                                for($i = 0;$i <6;$i++){
                                                    $warna .= $nilai[rand(0,strlen($nilai) - 1)];
                                                }
                                                $color_asal[$a] = $warna;
                                                $a++;
                                                 ?>
                                            <span class="mr-2">
                                                <i class="fas fa-circle" style="color: <?= '#'.$warna ?>;"></i><?= $row['asal_daerah'].' '.number_format(($row['count_asal']*100/$count_asal['count_asal'])).' %'; ?>


                                            </span>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Rata-rata TAK Per Semester</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="takChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Mahasiswa</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="statusChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <?php $a = 0; ?>
                                        <?php foreach ($status as $row): ?>
                                            <?php $warna = ""; 
                                            $nilai = "1234567890abcdef";
                                                for($i = 0;$i <6;$i++){
                                                    $warna .= $nilai[rand(0,strlen($nilai) - 1)];
                                                }
                                                $color_status[$a] = $warna;
                                                $a++;
                                                 ?>
                                            <span class="mr-2">
                                                <i class="fas fa-circle" style="color: <?= '#'.$warna ?>;"></i><?= $row['status'].' '.number_format(($row['count_status']*100/$count_status['count_status'])).' %'; ?>
                                            </span>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>

                            <!-- TAK Chart -->
                           <!--  <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $konten3['header'] ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="<?= base_url('assets/') ?>img/undraw_posting_photo.svg" alt="">
                                    </div>
                                    <?= $konten3['content'] ?>
                                </div>
                            </div> -->

                            <!-- Approach -->
                          <!--   <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <?= $konten4['content'] ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> -->
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Page level plugins -->
            <script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>

            <script type="text/javascript">
                // Set new default font family and font color to mimic Bootstrap's default styling
                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                function number_format(number, decimals, dec_point, thousands_sep) {
                  // *     example: number_format(1234.56, 2, ',', ' ');
                  // *     return: '1 234,56'
                  number = (number + '').replace(',', '').replace(' ', '');
                  var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                      var k = Math.pow(10, prec);
                      return '' + Math.round(n * k) / k;
                    };
                  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                  if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                  }
                  if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                  }
                  return s.join(dec);
                }

                // Area Chart Example
                var ctx = document.getElementById("ipkChart");
                var myLineChart = new Chart(ctx, {
                  type: 'line',
                  data: {
                    labels: [
                    <?php 
                    // if ($this->uri->segment(4)=='Ganjil') {
                    //     echo "'Semester I', 'Semester III', 'Semester V'";
                    // } elseif($this->uri->segment(4)=='Genap'){
                    //     echo "'Semester II', 'Semester IV', 'Semester VI'";
                    // } else{
                    //     echo "'Semester I', 'Semester II', 'Semester III', 'Semester IV', 'Semester V', 'Semester VI'";
                    // } 
                    foreach ($distinct_semester_ip_ipk as $key) {
                            echo "'Semester ".convertRomawi($key['smt'])."', ";
                        }
                    ?>
                    ],
                    datasets: [{
                      label: "Earnings",
                      lineTension: 0.3,
                      backgroundColor: "rgba(78, 115, 223, 0.05)",
                      borderColor: "rgba(78, 115, 223, 1)",
                      pointRadius: 3,
                      pointBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointBorderColor: "rgba(78, 115, 223, 1)",
                      pointHoverRadius: 3,
                      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                      pointHitRadius: 10,
                      pointBorderWidth: 2,
                      data: [<?php
                      foreach ($ip_ipk_mahasiswa_semester as $key) {
                          echo number_format($key['avg_ipk'],2).", ";
                      }
                      ?>],
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    layout: {
                      padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                      }
                    },
                    scales: {
                      xAxes: [{
                        time: {
                          unit: 'date'
                        },
                        gridLines: {
                          display: false,
                          drawBorder: false
                        },
                        ticks: {
                          maxTicksLimit: 7
                        }
                      }],
                      yAxes: [{
                        ticks: {
                          min: 0,
                          max: 4,
                          maxTicksLimit: 5,
                          padding: 10,
                          // Include a dollar sign in the ticks
                          callback: function(value, index, values) {
                            return value;
                          }
                        },
                        gridLines: {
                          color: "rgb(234, 236, 244)",
                          zeroLineColor: "rgb(234, 236, 244)",
                          drawBorder: false,
                          borderDash: [2],
                          zeroLineBorderDash: [2]
                        }
                      }],
                    },
                    legend: {
                      display: false
                    },
                    tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      titleMarginBottom: 10,
                      titleFontColor: '#6e707e',
                      titleFontSize: 14,
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      intersect: false,
                      mode: 'index',
                      caretPadding: 10,
                      callbacks: {
                        label: function(tooltipItem, chart) {
                          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                          return datasetLabel + ': ' + tooltipItem.yLabel;
                        }
                      }
                    }
                  }
                });

                // Bar Chart Example
                var ctx = document.getElementById("takChart");
                var myBarChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: [
                    <?php 
                    // if ($this->uri->segment(4)=='Ganjil') {
                    //     echo "'Semester I', 'Semester III', 'Semester V'";
                    // } elseif($this->uri->segment(4)=='Genap'){
                    //     echo "'Semester II', 'Semester IV', 'Semester VI'";
                    // } else{
                    //     echo "'Semester I', 'Semester II', 'Semester III', 'Semester IV', 'Semester V', 'Semester VI'";
                    // } 
                        // foreach ($distinct_semester as $key) {
                        //     echo "'Semester ".convertRomawi($key['semester'])."', ";
                        // }
                    $n = 1;
                    $smt = "";
                    foreach ($hitung_tak as $vms){
                        switch ($vms['semester_kelas']) {
                            case 1: $smt = "Semester I"; break;
                            case 2: $smt = "Semester II"; break;
                            case 3: $smt = "Semester III"; break;
                            case 4: $smt = "Semester IV"; break;
                            case 5: $smt = "Semester V"; break;
                            case 6: $smt = "Semester VI"; break;
                            default: $smt = ''; break;
                        }
                        echo "'".$smt." ".$vms['jml_mhs']." Orang', ";
                        $n++;
                    } ?>],
                    datasets: [{
                      label: "Revenue",
                      backgroundColor: "#12c3c9",
                      hoverBackgroundColor: "#2e59d9",
                      borderColor: "#12c3c9",
                      data: [<?php
                      foreach ($hitung_tak as $key) {
                          echo $key['avg_tak'].", ";
                      }
                      ?>],
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    layout: {
                      padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                      }
                    },
                    scales: {
                      xAxes: [{
                        time: {
                          unit: 'month'
                        },
                        gridLines: {
                          display: false,
                          drawBorder: false
                        },
                        ticks: {
                          maxTicksLimit: 6
                        },
                        maxBarThickness: 25,
                      }],
                      yAxes: [{
                        ticks: {
                          beginAtZero:true,
                          // Include a dollar sign in the ticks
                          callback: function(value, index, values) {
                            return number_format(value);
                          }
                        },
                        gridLines: {
                          color: "rgb(234, 236, 244)",
                          zeroLineColor: "rgb(234, 236, 244)",
                          drawBorder: false,
                          borderDash: [2],
                          zeroLineBorderDash: [2]
                        }
                      }],
                    },
                    legend: {
                      display: false
                    },
                    tooltips: {
                      titleMarginBottom: 10,
                      titleFontColor: '#6e707e',
                      titleFontSize: 14,
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      caretPadding: 10,
                      callbacks: {
                        label: function(tooltipItem, chart) {
                          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                          return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                      }
                    },
                  }
                });

                // Bar Chart Example
                var ctx = document.getElementById("presensiChart");
                var myBarChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: [<?php 
                    // if ($this->uri->segment(4)=='Ganjil') {
                    //     echo "'Semester I', 'Semester III', 'Semester V'";
                    // } elseif($this->uri->segment(4)=='Genap'){
                    //     echo "'Semester II', 'Semester IV', 'Semester VI'";
                    // } else{
                    //     echo "'Semester I', 'Semester II', 'Semester III', 'Semester IV', 'Semester V', 'Semester VI'";
                    // }
                    foreach ($distinct_semester as $key) {
                            echo "'Semester ".convertRomawi($key['semester'])."', ";
                        } 
                    ?>],
                    datasets: [{
                      label: "Revenue",
                      backgroundColor: "#4e73df",
                      hoverBackgroundColor: "#2e59d9",
                      borderColor: "#4e73df",
                      data: [<?php
                      foreach ($value_mahasiswa_semester as $key) {
                          echo ($key['avg_presensi']*100).", ";
                      }
                      ?>],
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    layout: {
                      padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                      }
                    },
                    scales: {
                      xAxes: [{
                        time: {
                          unit: 'month'
                        },
                        gridLines: {
                          display: false,
                          drawBorder: false
                        },
                        ticks: {
                          maxTicksLimit: 6
                        },
                        maxBarThickness: 25,
                      }],
                      yAxes: [{
                        ticks: {
                          max: 100,
                          beginAtZero:true,
                          // Include a dollar sign in the ticks
                          callback: function(value, index, values) {
                            return number_format(value) + '%';
                          }
                        },
                        gridLines: {
                          color: "rgb(234, 236, 244)",
                          zeroLineColor: "rgb(234, 236, 244)",
                          drawBorder: false,
                          borderDash: [2],
                          zeroLineBorderDash: [2]
                        }
                      }],
                    },
                    legend: {
                      display: false
                    },
                    tooltips: {
                      titleMarginBottom: 10,
                      titleFontColor: '#6e707e',
                      titleFontSize: 14,
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      caretPadding: 10,
                      callbacks: {
                        label: function(tooltipItem, chart) {
                          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                          return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' %';
                        }
                      }
                    },
                  }
                });
                var ctx = document.getElementById("pekerjaanChart");
                var myPieChart = new Chart(ctx, {
                  type: 'doughnut',
                  data: {
                    labels: [<?php 
                        foreach ($pekerjaan_wali as $row) {
                            echo "'".$row['pekerjaan_wali']."', ";
                        }
                     ?>],
                    datasets: [{
                      data: [<?php 
                        foreach ($pekerjaan_wali as $row) {
                            echo ($row['count_pekerjaan']).', ';
                        }
                        ?>],
                      backgroundColor: [
                      <?php
                            for($i = 0;$i < count($pekerjaan_wali);$i++){
                                echo "'#".$color_pekerjaan[$i]."', ";
                            }?>],
                      hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      caretPadding: 10,
                    },
                    legend: {
                      display: false
                    },
                    cutoutPercentage: 80,
                  },
                });
                // Pie Chart Example
                var ctx = document.getElementById("asalChart");
                var myPieChart = new Chart(ctx, {
                  type: 'doughnut',
                  data: {
                    labels: [<?php 
                        foreach ($asal_daerah as $row) {
                            echo "'".$row['asal_daerah']."', ";
                        }
                     ?>],
                    datasets: [{
                      data: [<?php 
                        foreach ($asal_daerah as $row) {
                            echo ($row['count_asal']).', ';
                        }
                        ?>],
                      backgroundColor: [<?php
                            for($i = 0;$i < count($asal_daerah);$i++){
                                echo "'#".$color_asal[$i]."', ";
                            }?>],
                      hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      caretPadding: 10,
                    },
                    legend: {
                      display: false
                    },
                    cutoutPercentage: 80,
                  },
                });

                var ctx = document.getElementById("statusChart");
                var myPieChart = new Chart(ctx, {
                  type: 'pie',
                  data: {
                    labels: [<?php 
                        foreach ($status as $row) {
                            echo "'".$row['status']."', ";
                        }
                     ?>],
                    datasets: [{
                      data: [<?php 
                        foreach ($status as $row) {
                            echo ($row['count_status']).', ';
                        }
                        ?>],
                      backgroundColor: [<?php
                            for($i = 0;$i < count($status);$i++){
                                echo "'#".$color_status[$i]."', ";
                            }?>],
                      hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      caretPadding: 10,
                    },
                    legend: {
                      display: false
                    },
                    cutoutPercentage: 80,
                  },
                });


            </script>

            <!-- Page level custom scripts -->
            <!-- <script src="<?= base_url('assets/') ?>js/chart/presensi.js"></script>
            <script src="<?= base_url('assets/') ?>js/chart/ipk.js"></script>
            <script src="<?= base_url('assets/') ?>js/chart/tak.js"></script>
            <script src="<?= base_url('assets/') ?>js/chart/pekerjaan.js"></script>
             <script src="<?= base_url('assets/') ?>js/chart/asal.js"></script>
             -->
            <script src="<?= base_url('assets/') ?>js/demo/chart-area-demo.js"></script>
            <script src="<?= base_url('assets/') ?>js/demo/chart-pie-demo.js"></script>
            