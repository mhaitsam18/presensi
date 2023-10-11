<div class="row mb-3">
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
					'semester' => $cur_semester-1,
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
</div>
<div class="row">
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
					'semester' => $cur_semester-1,
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