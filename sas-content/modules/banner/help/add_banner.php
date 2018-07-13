<style>
.help-container{ height:auto;max-height:100% !important;}
.help-maintitle{ font-size:16px;font-weight:bold;color:#000;}
.help-item{ padding:8px; }
.help-title{ font-size:14px;font-weight:bold;color:#FDA01E;}
.help-content{ margin-left:15px;font-size:12px;color:#707070;}
.help-desc{ font-size:12px;color:#707070;}
</style>
<?if (!defined('basePath')) exit('No direct script access allowed');
$help	= '<div class="help-container">
		<div class="help-maintitle">Bantuan</div>
		<div class="help-item">
			<div class="help-desc">
				Halaman ini untuk menambahkan data '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Upload Gambar Banner</div>
			<div class="help-content">
				<li>Arahkan mouse ke form upload, maka akan muncul icon <button id="button_add_image">
				<i class="fa fa-upload"></i>
				</button>dan klik, pilih file image dan klick open. tunggu sampai proses upload selesai. Indicatornya <div class="loading_add_image progress-upload progress progress-small progress-striped active" style="margin-top:10px;">
<div class="progress-bar progress-bar-warning" style="width: 100%;"></div>
</div> akan hilang.
				</li>
				<li>Maksimal size gambar yang akan diuupload adalah 2Mb. Jika melebihi batas tersebut maka upload akan gagal</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Tambah Name, url</div>
			<div class="help-content">
				<li>Isi kolom <b>Name</b> untuk nama banner</li>
				<li>Isi kolom <b>Link</b> untuk link tujuan banner</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menyimpan data</div>
			<div class="help-content">
				<li>Jika sudah terisi semua , tekan tombol<button id="save_post" class="btn btn-sm btn-primary" name="save_post" type="submit">
					<i class="fa fa-plus"></i>
					Add banner
				</button></li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menambahkan data lain</div>
			<div class="help-content">
			<li>Ulangi langkah diatas</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Kembali ke Halaman tabel data</div>
			<div class="help-content">
			<li>Tekan tombol <a class="btn btn-sm btn-success" href="#">
<i class="fa fa-check"></i>
Finish
</a></li>
			</div>
		</div>
	</div>';
	?>