<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Barcode Product</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.css">
	<style>
		section.header {
	    text-align: center;
		}
		.title {
	    font-product: 24px;
	    font-weight: bold;
	    text-decoration: underline;
		}
		.subtitle {
	    font-product: 18px;
		}
	</style>
</head>
<body>
	<section class="header">
		<div class="title"></div>
		<div class="subtitle"></div>
	</section>
	<section class="content">
		<div class="row">
		<?php
      if ($listdata->result()) {
      	$no = 1;
        foreach ($listdata->result() as $key) {
        	echo "<style>@media print {.bbcode$no {content:url(<?php echo 'data:image/*;base64,'.base64_encode(generate_barcode($key->kode))?>);}}</style>";
					echo '<div class="col-sm-3"><img class="bbcode'.$no.'" src="data:image/png;base64,'.generate_barcode($key->kode).'"/></div>';
          $no++;
        }
      }
    ?>
    </div>
	</section>
	<section class="footer">
	</section>
</body>
</html>