<?php if (!defined('basePath')) exit('No direct script access allowed');
$navbar = 'navbar-light';
$navbar = $this->thisModuleID()=='1' && !$this->device->isMobile()?'navbar-trasparent':$navbar;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $this->head();?>

    <!-- Bootstrap core CSS -->
    <?php echo $this->load_css($this->themeURL().'vendor/bootstrap/css/bootstrap.min.css');?>

    <!-- Font -->
    <?php echo $this->load_css($this->themeURL().'assets/css/linearicons.min.css');?>
    <?php echo $this->load_css($this->themeURL().'assets/css/socicon.min.css');?>

    <!-- Plugin style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/select2.min.css');?>
    <?php echo $this->load_css($this->themeURL().'assets/css/owl.carousel.min.css');?>
    <?php echo $this->load_css($this->themeURL().'assets/css/owl.theme.default.min.css');?>

    <!-- Custom styles for this template -->
    <?php echo $this->load_css($this->themeURL().'assets/css/book.min.css');?>
    <?php echo $this->load_css($this->themeURL().'assets/css/style.css');?>

</head>

<body>

    <!-- Navigation -->
    <nav id="<?php echo $navbar; ?>" class="navbar navbar-expand-lg navbar-default fixed-top <?php echo $navbar; ?>">
        <div class="container">
            <a class="navbar-brand" href="<?php echo baseURL; ?>"><img src="<?php echo uploadURL.'modules/siteconfig/thumbs/small/'.$this->site->logo(); ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <?=$this->getMenu('top', 'navbar-nav ml-auto')?>
            </div>
        </div>
    </nav>

    <header>
        <?php $this->widget('top')?>
    </header>
