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
				Halaman ini menampilkan daftar email yang masuk dari halaman '.$this->pageTitle().'
			</div>
		</div>
		
		<div class="help-item">
			<div class="help-title">Menu Tabel</div>
			<div class="help-content">
				<li>Pilih angka pada <b>Display</b> untuk menampilkan banyak data per tabel (10,25,50,100)</li>
				<li>Masukkan kata kunci pada form <b>Search</b> lalu tekan Enter untuk mencari data</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Membalas email</div>
			<div class="help-content">
				<li>Klik icon <b>Reply</b><a class="blue" title="Reply" href="#">
<i class="fa fa-reply bigger-130"></i>
</a> untuk membalas pesan
				</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Status</div>
			<div class="help-content">
				<li>Menunjukkan status email sudah dibalas atau belum</li>
				<li>Status <b>Replied</b> sudah dibalas, <b>Not Replied</b> belom dibalas.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menghapus Data</div>
			<div class="help-content">
				<li>Klik icon 
					<a class="red"  href="#">
						<i class="fa fa-trash bigger-130"></i>
					</a> untuk menghapus data
				</li>
				<li>Beri tanda centang pada sebelah kiri data yang ingin dihapus lalu klik tombol <button class="btn btn-sm btn-danger">Delete Selected</button untuk menghapus data sekaligus</li>
			</div>
		</div>
	</div>';
	?>