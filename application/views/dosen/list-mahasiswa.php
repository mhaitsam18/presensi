        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Performa Mahasiswa - <?= $kelas['kelas'] ?> (
                <?php if ($kelas['semester_kelas'] > 6): ?>
                    Lulus
                <?php else: ?>
                    Semester <?= $kelas['semester_kelas'] ?>
                <?php endif ?>
            )</h1>
            <div class="row">
                <div class="col-lg-6">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>
            <div class="row mb-3">
                <button onclick="cek_ip()" class="btn btn-primary">Cek Mahasiswa dengan IP Tertinggi</button>
                <!-- <button onclick="cek_tinggi()" class="btn btn-primary">Cek Mahasiswa dengan IP Tertinggi</button> -->
            </div>
            <style type="text/css">
                .hide_aja{
                    <?php if ($this->uri->segment(4) == ''): ?>
                        display: none;
                    <?php endif ?>
                }
            </style>
            <div class="hide_aja" id="IP">
                <div class="form-group">
                    <?php $x = 1; ?>
                    <?php $smt = ''; ?>
                    <?php while ($x <= 6) { ?>
                        <?php switch ($x) {
                            case 1: $smt = "Semester I";  break;
                            case 2: $smt = "Semester II";  break;
                            case 3: $smt = "Semester III";  break;
                            case 4: $smt = "Semester IV";  break;
                            case 5: $smt = "Semester V";  break;
                            case 6: $smt = "Semester VI";  break;
                            default: $smt = "All Semester"; break;
                        } ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="semester<?= $x ?>" value="<?= "$kelas[id]/$x" ?>">
                            <label class="form-check-label" for="semester<?= $x ?>"><?= $smt ?></label>
                        </div>
                    <?php $x++; } ?>
                </div>
                <?php if ($this->uri->segment(3) != ''): ?>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort By
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/nim') ?>">NIM</a>
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/name') ?>">Nama Mahasiswa</a>
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/ip_sebelum') ?>">IP Semester Sebelumnya</a>
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/ip') ?>">IP Terbaru</a>
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/selisih') ?>">Selisih</a>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($this->uri->segment(4) != ''): ?>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($this->uri->segment(5) != 'ASC'): ?>
                                A - Z
                            <?php elseif($this->uri->segment(5) != 'DESC'): ?>
                                Z - A
                            <?php endif ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/ASC') ?>">A-Z</a>
                            <a class="dropdown-item" href="<?= base_url('Dosen/listMahasiswa/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/DESC') ?>">Z-A</a>
                        </div>
                    </div>
                <?php endif ?>
                <div id="ctn">
                    <h5>5 Mahasiswa dengan IP Tertinggi</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama Mahasiswa</th>
                                <th scope="col">IP Terbaru</th>
                                <th scope="col">IP Semester Sebelumnya</th>
                                <th scope="col">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1; ?>
                            <?php foreach ($mahasiswa_ip_tertinggi as $key): ?>
                                <?php $ip_past = $this->db->get_where('ip_semester', [
                                    'id_nilai_mahasiswa' => $key['nmid'],
                                    'semester' => $kelas['semester_kelas']-1,
                                ])->row_array(); ?>
                                <tr class="table-success">
                                    <th><?= $n++; ?></th>
                                    <td><?= $key['nim'] ?></td>
                                    <td><?= $key['name'] ?></td>
                                    <td><?= $key['ip'] ?></td>
                                    <td><?php if (!$ip_past) {echo 0;} else{echo $ip_past['ip'];} ?></td>
                                    <td><?= $key['ip'] - $ip_past['ip'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <h5>5 Mahasiswa dengan IP Terendah</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama Mahasiswa</th>
                                <th scope="col">IP Terbaru</th>
                                <th scope="col">IP Semester Sebelumnya</th>
                                <th scope="col">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1; ?>
                            <?php foreach ($mahasiswa_ip_terendah as $key): ?>
                                <?php $ip_past = $this->db->get_where('ip_semester', [
                                    'id_nilai_mahasiswa' => $key['nmid'],
                                    'semester' => $kelas['semester_kelas']-1,
                                ])->row_array(); ?>
                                <tr class="table-danger">
                                    <th><?= $n++; ?></th>
                                    <td><?= $key['nim'] ?></td>
                                    <td><?= $key['name'] ?></td>
                                    <td><?= $key['ip'] ?></td>
                                    <td><?php if (!$ip_past) {echo 0;} else{echo $ip_past['ip'];} ?></td>
                                    <td><?= $key['ip'] - $ip_past['ip'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Content Row -->
           <!--  <div class="row"> -->
                <!-- Area Chart -->
                <!-- <div class="col-xl-4 col-lg-4"> --><!-- Project Card Example -->
                    <!-- <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pendidikan Terakhir Wali Mahasiswa</h6>
                        </div>
                        <div class="card-body">
                            <?php 
                            foreach ($pendidikan_wali as $row) { ?>
                                <?php
                                $persentase_pendidikan =  $row['count_pendidikan']*100/$count_pendidikan['count_pendidikan'] ?>
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
                    
                </div> -->
               <!--  <div class="col-xl-4 col-lg-4">
                    <div class="card shadow mb-4"> -->
                        <!-- Card Header - Dropdown -->
                        <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                        Card Body
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
                                        <i class="fas fa-circle" style="color: <?= '#'.$warna ?>;"></i><?= $row['asal_daerah'].' '.($row['count_asal']*100/$count_asal['count_asal']).' %' ?>
                                    </span>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- Pie Chart -->
               <!--  <div class="col-xl-4 col-lg-4">
                    <div class="card shadow mb-4"> -->
                        <!-- Card Header - Dropdown -->
                        <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">pekerjaan Wali Mahasiswa</h6>
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
                        </div> -->
                        <!-- Card Body -->
                       <!--  <div class="card-body">
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
                                        <i class="fas fa-circle" style="color: <?= '#'.$warna ?>;"></i><?= $row['pekerjaan_wali'].' '.($row['count_pekerjaan']*100/$count_pekerjaan['count_pekerjaan']).' %' ?>
                                    </span>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Content Row -->
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="h3 mb-4 text-gray-800">List Mahasiswa</h1>
                </div>
            </div>
            <div class="row">
                <?php foreach ($mahasiswa as $key): ?>
                    <div class="card mr-3 mb-3" style="width: 18rem;">
                        <img src="<?= base_url('assets/img/profile/') . $key['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $key['name'] ?></h5>
                            <p class="card-text"><?= $key['nim'] ?></p>
                            <a href="<?= base_url("Dosen/performaMahasiswa/$key[mid]") ?>" class="btn btn-primary">Lihat Performa</a>
                        </div>
                    </div>
                <?php endforeach ?>
                <?php if (!$mahasiswa): ?>
                        <h2>Tidak ada Mahasiswa di Kelas Anda</h2>
                <?php endif ?>
            </div>

        </div>
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

        function cek_ip() {
          var x = document.getElementById("IP");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }

        function cek_tinggi() {
          var x = document.getElementById("IPTinggi");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }

        function cek_rendah() {
          var x = document.getElementById("IPRendah");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }

        
    </script>


<script type="text/javascript">
    // ambil elements yg di buutuhkan
    <?php $x= 1; 
    while ($x <= 6){ ?>
        var keyword<?= $x ?> = document.getElementById('semester<?= $x ?>');
    <?php $x++; } ?>
    var container = document.getElementById('ctn');
    // var btn = document.getElementById('button-addon2');

    // tambahkan event ketika keyword ditulis
    <?php $n= 1;
    while ($n <= 6){ ?>
        keyword<?= $n ?>.addEventListener('change', function () {


            //buat objek ajax
            var xhr = new XMLHttpRequest();

            // cek kesiapan ajax
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    container.innerHTML = xhr.responseText;
                }
            }

            xhr.open('GET', '<?= base_url('Dosen/topSemester/') ?>' + keyword<?= $n ?>.value + '/<?= $this->uri->segment(4) ?>/<?= $this->uri->segment(5) ?>', true);
            xhr.send();


        })
    <?php $n++; } ?>
</script>