			<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
					<div class="row">
						<div class="col-lg-6">
							<?= $this->session->flashdata('message'); ?>
						</div>
					</div>
					<div class="card" style="width: 32rem;">
						<div class="card-body">
							<h5 class="card-title">Nilai <?= $nama_mata_kuliah; ?> </h5>
							<h6 class="card-subtitle mb-2 text-muted"><?= $mahasiswa['name']; ?></h6>
							<?php foreach ($sub_nilai_mata_kuliah as $key): ?>
								<div class="row">
									<div class="col-sm-4">
										<?= $key['nama_penilaian'] ?>
									</div>
									<div class="col-sm-1">
										:
									</div>
									<div class="col-sm-7">
										<?= $key['nilai'] ?>
									</div>
								</div>
							<?php endforeach ?>
							<a href="<?= base_url("dosen/performaMahasiswa/$mahasiswa[mid]") ?>" class="card-link">Kembali</a>
							<a href="<?= base_url("dosen/detailSubNilaiMataKuliah/$id_nilai_mata_kuliah") ?>" class="card-link">Another link</a>
						</div>
					</div>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



