<?php if (!defined('basePath')) exit('No direct script access allowed'); ?>


<!-- /.Footer
================================================== -->
<footer>
    <div class="footer-section">
        <div class="container">
            <div class="footer-widget text-center">
                <h3><?php echo $this->site->title(); ?><span class="head-line"></span></h3>
                <?php
                $getSocial = '';
                foreach($this->site->social_media() as $socialID => $socialUrl){

                    if(!empty($socialUrl)){
                        $socialIcon	= str_replace('_','',$socialID);
                        $socialTitle = ucwords(str_replace('_',' ',$socialID));
                        $getSocial  .= '<li><a href="'.$socialUrl.'" target="_blank" class="'.$socialIcon.'" title="'.$socialTitle.'" rel="tooltip" data-placement="bottom"><i class="socicon-'.$socialIcon.'"></i></a></li>';
                    }
                }
                ?>
                <ul class="social-icon">
                    <?php echo $getSocial; ?>
                </ul>
                <br>
                <p>&copy; 2018 <?php echo $this->site->title(); ?> -  All Rights Reserved </p>
                <p><?php echo $this->copyright()?></p>
            </div>

        </div>
    </div>
</footer>
<!-- /.Footer -->

<!-- Bootstrap core JavaScript -->
<?php echo $this->load_js($this->themeURL().'vendor/jquery/jquery-1.10.1.min.js', 'asinyc');?>

<!-- <script src="vendor/jquery/jquery.min.js"></script> -->
<?php echo $this->load_js($this->themeURL().'vendor/bootstrap/js/bootstrap.bundle.min.js', 'asinyc');?>

<!-- Plugin script for this template -->
<?php echo $this->load_js($this->themeURL().'assets/js/select2.full.min.js', 'asinyc');?>
<?php echo $this->load_js($this->themeURL().'assets/js/owl.carousel.min.js', 'asinyc');?>

<!-- Custom script for this template -->
<?php echo $this->load_js($this->themeURL().'assets/js/script.js');?>
<?php
if($this->thisModule()=='contactus'){

  $contactSettings = $this->getParams('contact');
  $markerInfo		 = base64_decode($contactSettings['content']);
  $markerInfo		 = '<h4>'.$this->site->company_name().'</h4>'.$this->site->company_address();
  ?>

  <!-- Map -->
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=<?php echo $this->config['googleKey'] ?>"></script>
  <script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($){

    /* Listing map */
    var image = themeURL+'assets/img/pin.png';
    var latLng = new google.maps.LatLng(<?php echo $contactSettings['geolocation'] ?>);
    var map = new google.maps.Map(document.getElementById("map-canvass"), {
      zoom: 15,
      scaleControl: false,
      scrollwheel: false,
      center: latLng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    /* Add Marker */
    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      icon: image
    });

    /* Add Info window */
    var contentString = '<?=$markerInfo?>';
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });

    var infowindow = new google.maps.InfoWindow({
      content: contentString
    });
  });
  </script>
  <?
}
?>
</body>

</html>
