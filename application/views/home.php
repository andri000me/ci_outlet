<!DOCTYPE html>
<html>
<head>
	<title>:: <?php echo @$name; ?> ::</title>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="A description of the page">
	<meta name="robots" content="index,follow,noodp">
	<meta name="googlebot" content="index,follow">
	<meta name="google" content="nositelinkssearchbox">
	<meta name="google" content="notranslate">
	<!-- <meta name="google-site-verification" content="verification_token"> -->
	<meta name="subject" content="your website's subject">
	<meta name="abstract" content="your website's subject">
	<meta name="topic" content="">
	<meta name="summary" content="">
	<meta name="classification" content="business">
	<meta name="url" content="http://annykaselluler.com">
	<meta name="identifier-URL" content="http://annykaselluler.com">
	<meta name="directory" content="submission">
	<meta name="category" content="">
	<meta name="coverage" content="Worldwide">
	<meta name="distribution" content="Global">
	<meta name="rating" content="General">
	<meta name="referrer" content="never">
	<meta name="geo.placename" content="indonesia">
	<!-- <meta http-equiv="Content-Security-Policy" content="img-src 'self' data:; default-src 'self' http://my.project.host/4171/"> -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/materialize.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/scroll.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/sweetalert2/dist/sweetalert2.min.css">
</head>
<body>
	<nav class="indigo lighten-1">
    <div class="nav-wrapper">
      <a href="<?php echo base_url() ?>" class="brand-logo"><?php echo @$name; ?></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="<?php echo base_url() ?>">Home</a></li>
        <li><a href="#product">Product</a></li>
        <?php 
        	if(is_login()) {
        		echo '<li>'.anchor('dashboard', 'Dashboard').'</li>';
        		echo '<li>'.anchor('signout', 'Logout').'</li>';
        	}
        	else {
        		echo '<li>'.anchor('signin', 'Login').'</li>';
        	}
        ?>
      </ul>
    </div>
  </nav>
	<section class="indigo home">
	  <div class="container center">
		  <div class="col s12 l12">
	    	<?php
	    		if ($name) echo '<h1 class="header white-text">'.$name.'</h1>'; else echo 'Your Site Name';
	    		echo '<p class="white-text">';
	    		if ($address) echo $address.'<br>';
	    		if ($telp) echo ' <i class="fa fa-fw fa-phone"></i> '.$telp.' ';
	    		if ($pin) echo ' <i class="fa fa-fw fa-weixin"></i> '.$pin.' ';
	    		if ($ig) echo ' <i class="fa fa-fw fa-instagram"></i> '.$ig.' ';
	    		echo '<p>';
	    	?>
		  </div>
	  </div>
	</section>
	<section class="grey lighten-1">
		<div class="scroll-left"><?php if ($info) echo '<p class="materialize-red-text text-darken-4">'.$info.'</p>'; ?></div>
	</section>
  <section class="skills center" id="product">
    <div class="container">
    	<div class="row">
	    	<?php 
	    	if ($product->result()) {
	    		echo '<div class="col s12 l12"><h2 class="grey-text text-darken-4">Hot Promo</h2></div>';
	    		foreach ($product->result() as $val) {
	    			echo '<div class="col m3">
			      <img src="data:'.$val->mime.';base64,'.base64_encode($val->img).'" alt="" class="catalog-thump">
			      <h4>'.$val->product.'</h4>
			      <p>'.$val->diskripsi.'</p>
			      </div>';
	    		}
	    	}
	    	?>
	    </div>
    </div>
  </section>
  <footer class="page-footer teal center">
    <div class="footer-copyright">
      <div class="container center">
      <p>© 2018 <a href="<?php echo base_url() ?>"><?php echo @$name ?></a>. <a href="www.remithzu.com" class="right">Remithzu</a>.</p>
      </div>
    </div>
  </footer>
</body>
</html>
