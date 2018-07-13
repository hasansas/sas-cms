<?php if (!defined('basePath')) exit('No direct script access allowed'); ?>

<?php $this->getHeader()?>
<?php $this->widget('content')?>

<?php
if($this->thisModuleID()!='1'){
	if($this->thisModule()=='posts'){
		?>
		<div class="container">
			<div class="content">
				<div class="row">
					<div class="col-md-8">
						<div class="content-wrapper">
							<?php echo $this->getContent(); ?>
						</div>
					</div>
					<div class="col-md-4 sidebar">
						<?php $this->widget('right')?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	else{
		echo $this->getContent();
	}
}
?>

<?php $this->getFooter()?>
