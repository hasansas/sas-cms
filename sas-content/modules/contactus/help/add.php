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
				halaman ini untuk menyeting halaman '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menyeting Location di google map</div>
			<div class="help-content">
				<li>Isikan alamat lokasi</li>
				<li>Klik tombol "get map", dan sistem akan mencari posisi sesuai dengan alamat yang diinputkan.</li>
				<li>Jika posisi kurang tepat sesuai lokasinya, klik icon lokasi dan geser sesuai dengan lokasi yang semestinya.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Contact Fields</div>
			<div class="help-content">
				<li>Pilih data apa saja yang diperlukan bagi user yang akan mengisikan form Contact Us dengan cara memberi check mark di form.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menyimpan data</div>
			<div class="help-content">
			<li>Jika sudah terisi semua , tekan tombol<button id="save_facility" class="btn btn-sm btn-primary" name="save_facility" type="submit">
<i class="fa fa-plus"></i>
Save All Changes 
</button></li>
			</div>
		</div>
		
	</div>';
	?>