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
				Halaman ini menampilkan daftar '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Letak Banner</div>
			<div class="help-content">
				<li>Pilih letak banner di pojok kanan atas tabel(top,bottom,left,right)</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menu Table</div>
			<div class="help-content">
				<li>Klik <b>Add New</b> untuk menambah data baru</li>
				<li>Pilih angka pada <b>Display</b> untuk menampilkan banyak data per tabel (10,25,50,100)</li>
				<li>Masukkan kata kunci pada form <b>Search</b> lalu tekan Enter untuk mencari data</li>
				<li>Ubah kolom <b>Order</b> mulai dari 0 untuk letak banner pertama. Urutan banner selanjutnya dari nomor terkecil ke besar</li>
				<li>Ubah kolom posisi untuk ganti letak banner</li>
			</div>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Mengedit Data</div>
			<div class="help-content">
				<li>Klik <a class="green" title="Edit" href="#">
						<i class="fa fa-pencil bigger-130"></i>
						</a> untuk mengedit data
				</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Publish Data</div>
			<div class="help-content">
				<li>Beri tanda centang pada kolom data lalu klik <button class="btn btn-sm btn-primary">Save All Changes</button> untuk menyimpan data</li>
				<li>Tanda centang pada kolom Publish tidak aktif artinya data tidak ditampilkan pada website</li>
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
				<li>Beri tanda centang pada sebelah kiri data yang ingin dihapus lalu klik tombol <button class="btn btn-sm btn-danger">Delete Selected</button> untuk menghapus data sekaligus</li>
			</div>
		</div>
	</div>';
	?>