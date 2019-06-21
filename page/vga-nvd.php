<?php
include_once '../asset/database.php';
// require '../scrape/vgascrape.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
	<title>VGA</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/mystyle.css">
</head>
<body>
	<!-- NAVBAR -->
	<?php require '../asset/navbar.php' ?>

	<!-- BOX PENCARIAN -->
	<div class="container">
		<div class="mt-3">
			<center><h3>Membandingkan harga VGA Nvidia</h3></center>
		</div>

		<form action="" method="post">
			<div class="mt-4">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="search-input">Nama Barang</span>
					</div>
					<input type="text" name="search-input" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
				</div>
			</div>

			<select name="tipegt" class="custom-select mb-3" style="width: 125px">
				<option selected>Tipe GT</option>
				<option value="gt 210">GT 210</option>
				<option value="gt 710">GT 710</option>
				<option value="gt 730">GT 730</option>
				<option value="gt 1030">GT 1030</option>
			</select>

			<select name="tipegtx" class="custom-select mb-3" style="width: 125px">
				<option selected>Tipe GTX</option>
				<option value="gtx 1050">GTX 1050</option>
				<option value="gtx 1060">GTX 1060</option>
				<option value="gtx 1070">GTX 1070</option>
				<option value="gtx 1080">GTX 1080</option>
			</select>
			
			<select name="vram" class="custom-select mb-3" style="width: 125px">
				<option style="display: none">VRAM</option>
				<option value="1GB">1 GB</option>
				<option value="2GB">2 GB</option>
				<option value="3GB">3 GB</option>
				<option value="4GB">4 GB</option>
				<option value="6GB">6 GB</option>
				<option value="8GB">8 GB</option>
				<option value="11GB">11 GB</option>
			</select>	
			
			<!-- TOMBOL -->
			<div class="mt-2, mb-5">
				<center><button type="submit" name="search-button" id="search-button" style="width: 175px" class="btn btn-primary btn-lg btn-block">Cari Barang</button></center>
			</div>
		</form>

		<?php 			
		// tombol cari barang ditekan
		if (isset($_POST["search-button"])) {
			$search = $_POST['search-input'];
			$vendor = "nvidia|geforce";
			$vendorNvd = explode('|', $vendor);
			$tipegt = $_POST['tipegt'];
			$tipegtx = $_POST['tipegtx'];
			$selectVram = $_POST['vram'];
			
			$result2 = mysqli_query($koneksi,"SELECT * FROM vga_rn WHERE nama LIKE '%$search%' AND (nama LIKE '%$tipegt%' OR nama LIKE '%$tipegtx%') AND nama LIKE '%$vendorNvd[0]%' AND nama LIKE '%$selectVram%' ");
			$result = mysqli_query($koneksi,"SELECT * FROM vga_ek WHERE nama LIKE '%$search%' AND (nama LIKE '%$tipegt%' OR nama LIKE '%$tipegtx%') AND nama LIKE '%$vendorNvd[1]%' AND nama LIKE '%$selectVram%' ");

			/*$result2 = mysqli_query($koneksi,"SELECT * FROM vga_rn WHERE (nama LIKE '%$search%' OR nama LIKE '%$selectVram%' OR nama LIKE '%$search%') AND (nama LIKE '%$search%' OR nama LIKE '%$selectVram%' OR nama LIKE '%$search%') AND (nama LIKE '%$search%' OR nama LIKE '%$selectVram%' OR nama LIKE '%$search%') ");
			$result = mysqli_query($koneksi,"SELECT * FROM vga_ek WHERE (nama LIKE '%$search%' OR nama LIKE '%$selectVram%' OR nama LIKE '%$search%') AND (nama LIKE '%$search%' OR nama LIKE '%$selectVram%' OR nama LIKE '%$search%') AND (nama LIKE '%$search%' OR nama LIKE '%$selectVram%' OR nama LIKE '%$search%') ");*/

			if (!$result && !$result2) {
				printf("Error: %s\n", mysqli_error($koneksi));
				exit();
			}
			?>

			<!-- TABEL HASIL PENCARIAN -->
			<?php while($rnsearch = mysqli_fetch_array($result2) AND $eksearch = mysqli_fetch_array($result)) : ?> 
			<div class="mt-2">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th>Nama Barang</th>
								<th scope="col">Nama Toko</th>
								<th scope="col">Harga</th>
								<th scope="col">Link</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td rowspan="2">
									<div class="card" style="width: 25rem; margin-right:">
										<div class="card-body">
											<h5 class="card-title"><?= $eksearch['nama']; ?></h5>
										</div>
									</div>
								</td>
								<td><?= $eksearch['toko']; ?></td>
								<td>Rp <?php echo number_format($eksearch["harga"],0,".","."); ?>,-</td>
								<!-- <td> Rp  //$eksearch['harga']; </td> -->
								<td><a href="<?= $eksearch['link']; ?>" target="_blank">Beli disini</a></td>
							</tr>
							<tr>
								<td><?= $rnsearch['toko']; ?></td>
								<td>Rp <?= $rnsearch['harga']; ?></td>
								<td><a href="<?= $rnsearch['link']; ?>" target="_blank">Beli disini</a></td>
							</tr>							
							<!-- <tr>
								<td>Dummy</td>
								<td>Rp 99.999.999</td>
								<td><a href="">Beli disini</a></td>
							</tr> -->
							
						</tbody>
					</table>		
				</div>
			</div>
		<?php endwhile; ?>
	<?php } ?>
	
	<?php 
	// database connection close
	mysqli_close($koneksi);
	?>
</div>

<!-- JQuery dulu baru Javascript -->
<script
src="https://code.jquery.com/jquery-3.4.0.js"
integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
crossorigin="anonymous"></script>

<script src="js/mystyle.js"></script>	

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>