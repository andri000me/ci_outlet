<!DOCTYPE html>
<html>
<head>
	<title>:: <?php echo set()['nama']?> ::</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/sweetalert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/mite.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.css">
	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datepicker/datepicker3.css"> -->
	<script type="text/javascript">var app={base_url:'<?php echo base_url();?>'}</script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/slimScroll/jquery.slimscroll.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/fastclick/fastclick.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/dist/js/app.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/i18n/datepicker.en.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
	<?php if(@$js!=NULL) echo '<script type="text/javascript" src="'.base_url().'assets/core/'.$js.'.js"></script>';?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">

	    <!-- Logo -->
	    <a href="<?php echo base_url()?>" class="logo">
	      <!-- mini logo for sidebar mini 50x50 pixels -->
	      <span class="logo-mini"><b><i class="fa fa-user-circle"></i></b></span>
	      <!-- logo for regular state and mobile devices -->
	      <span class="logo-lg"><b><?php echo set()['nama']?></b></span>
	    </a>

	    <!-- Header Navbar: style can be found in header.less -->
	    <nav class="navbar navbar-static-top">
	      <!-- Sidebar toggle button-->
	      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	        <span class="sr-only">Toggle navigation</span>
	      </a>
	      <!-- Navbar Right Menu -->
	      <div class="navbar-custom-menu">
	        <ul class="nav navbar-nav">
	          <!-- Notifications: style can be found in dropdown.less -->
	          <li class="dropdown notifications-menu">
	          	<?php 
	          	if(array_sum(expired_count())!=0) $tt = 'Ada '.array_sum(expired_count()).' Pemberitahuan';
	          	else $tt = 'Tidak ada Pemberitahuan';
	          	?>
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo $tt; ?>">
	              <?php
	              if (!empty(expired())) {
              		echo '<i class="fa fa-bell faa-ring animated"></i>';
	              	echo '<span class="label label-danger">'.array_sum(expired_count()).'</span>';
	              }
	              else echo '<i class="fa fa-bell-o"></i>';
	              ?>
	            </a>
	            <ul class="dropdown-menu">
	              <li class="header">You have <?php echo array_sum(expired_count());?> limited stock</li>
	              <?php
	              	if (expired_count()) {
	              		echo '<li>';
	              		echo '<ul class="menu">';
	              		foreach (expired() as $value) {
				              echo '<li style="padding: 5px 10px;">'.$value['product'].'<span class="pull-right">'.$value['expired'].'</span></li>';
				            }
				            echo '</ul>';
				            echo '</li>';
	              	}
	              ?>
	              </li>
	            </ul>
	          </li>
	          <!-- User Account: style can be found in dropdown.less -->
	          <li class="dropdown user user-menu">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	              <img src="<?php 
	              if(my_photo()) echo 'data:image/*;base64,'.base64_encode(my_photo());
	              else echo base_url().'assets/dist/img/avatar5.png';
	              ?>
	              " class="user-image" alt="User Image">
	              <span class="hidden-xs"><?php echo user_name();?></span>
	            </a>
	            <ul class="dropdown-menu">
	              <!-- User image -->
	              <li class="user-header">
	                <img src="<?php 
		              if(my_photo()) echo 'data:image/*;base64,'.base64_encode(my_photo());
		              else echo base_url().'assets/dist/img/avatar5.png';
		              ?>
		              " class="img-circle" alt="User Image">
	                <p>
	                  <?php echo user_name();?>
	                  <small><?php echo my_level();?></small>
	                </p>
	              </li>
	              <!-- Menu Body -->
	              <li class="user-body">
	                <?php echo 'Lokasi : '.get_lokasi(my_location())?> <span><small class="label pull-right bg-green">Online</small></span>
	              </li>
	              <!-- Menu Footer-->
	              <li class="user-footer">
	                <div class="pull-left">
	                 	<?php echo anchor('profile','Profile',array('class'=>'btn btn-default btn-flat'));?>
	                </div>
	                <div class="pull-right">
	                  <a href="<?php echo base_url();?>signout" class="btn btn-default btn-flat">Sign out</a>
	                </div>
	              </li>
	            </ul>
	          </li>
	          <!-- Control Sidebar Toggle Button -->
	          <?php if (my_level()!='Seles') { ?>
	          <li>
	            <a href="<?php echo base_url();?>setting"><i class="fa fa-gears"></i></a>
	          </li>
	          <?php } ?>
	        </ul>
	      </div>

	    </nav>
	  </header>

	  <aside class="main-sidebar">
	    <!-- sidebar: style can be found in sidebar.less -->
	    <section class="sidebar">
	      <!-- Sidebar user panel -->
	      <div class="user-panel">
	        <div class="pull-left image">
	          <img src="<?php 
            if(my_photo()) echo 'data:image/*;base64,'.base64_encode(my_photo());
            else echo base_url().'assets/dist/img/avatar5.png';
            ?>
            " class="img-circle" alt="User Image">
	        </div>
	        <div class="pull-left info">
	          <p><?php echo user_name();?></p>
	          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
	        </div>
	      </div>

	      <!-- sidebar menu: : style can be found in sidebar.less -->
	      <ul class="sidebar-menu">
	        <li class="header">MAIN NAVIGATION</li>
					<?php if (my_level()==null || my_level()=='Admin') { ?>
	        <li <?php if(@$dashboard) echo $dashboard;?> ><?php echo anchor('dashboard','<i class="fa fa-dashboard"></i> <span>Dashboard</span>'); ?></li>
					<?php } ?>
					<?php if (my_level()==null || my_level()=='Admin') { ?>
					<li <?php if(@$users) echo $users;?> ><?php echo anchor('users','<i class="fa fa-users"></i> <span>Users</span>'); ?></li>
					<?php } ?>
					<?php if (my_level()==null || my_level()=='Admin') { ?>
					<li class="treeview <?php if(@$jenis || @$supplier || @$barang || @$product || @$provider || @$lokasi) echo 'active'; ?>">
	          <a href="#">
	            <i class="fa fa-database"></i> <span>Data</span>
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	            <li <?php if(@$supplier) echo $supplier;?> ><?php echo anchor('supplier','<i class="fa fa-circle-o"></i> Supplier'); ?></li>
	            <li <?php if(@$jenis) echo $jenis;?> ><?php echo anchor('jenis','<i class="fa fa-circle-o"></i> Jenis'); ?></li>
	            <li <?php if(@$provider) echo $provider;?> ><?php echo anchor('provider','<i class="fa fa-circle-o"></i> Provider'); ?></li>
	            <li <?php if(@$lokasi) echo $lokasi;?> ><?php echo anchor('lokasi','<i class="fa fa-circle-o"></i> Lokasi'); ?></li>
	            <li <?php if(@$barang) echo $barang;?> ><?php echo anchor('barang','<i class="fa fa-circle-o"></i> Barang'); ?></li>
	            <li class="devider"></li>
	            <li <?php if(@$product) echo $product;?> ><?php echo anchor('product/data','<i class="fa fa-circle-o"></i> Stock'); ?></li>
	          </ul>
	        </li>
					<?php } ?>
					
					<?php if (my_level()=='Seles') { ?>
					<li <?php if(@$stock_product) echo $stock_product;?> ><?php echo anchor('product/stock-product','<i class="fa fa-shopping-basket"></i> <span>Stock Product</span>'); ?></li>
					<?php } ?>

					<?php if (my_level()==null || my_level()=='Admin') { ?>
					<li <?php if(@$mutasi) echo $mutasi;?> ><?php echo anchor('mutasi','<i class="fa fa-random"></i> <span>Mutasi</span>'); ?></li>
					<?php } ?>
					<?php if (my_level()==null || my_level()=='Admin' || my_level()=='Seles') { ?>
					<li class="treeview <?php if(@$laporan_stock || @$log_transaksi || @$log_grosir) echo 'active'; ?>">
	          <a href="#">
	            <i class="fa fa-clipboard"></i> <span>Laporan</span>
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	          	<?php //if (my_level()!='Seles') { ?>
	            <li <?php if(@$laporan_stock) echo $laporan_stock;?> >
		            <?php echo anchor('laporan/index/laporan-stock','<i class="fa fa-circle-o"></i> Product'); ?>
	            </li>
	            <?php //}?>
	            <li <?php if(@$log_transaksi) echo $log_transaksi;?> >
		            <?php echo anchor('laporan/index/log-transaksi','<i class="fa fa-circle-o"></i> Log Transaksi'); ?>
	            </li>
	            <li <?php if(@$log_grosir) echo $log_grosir;?> >
		            <?php echo anchor('laporan/index/log-grosir','<i class="fa fa-circle-o"></i> Log Transaksi Grosir'); ?>
	            </li>
	          </ul>
	        </li>
					<?php } ?>
					<?php if (my_level()=='Seles') { ?>
					<li <?php if(@$penjualan) echo $penjualan;?> ><?php echo anchor('penjualan','<i class="fa fa-shopping-cart"></i> <span>Penjualan</span>'); ?></li>
					<?php } ?>
					<?php if (my_level()=='Seles') { ?>
					<li <?php if(@$retur) echo $retur;?> ><?php echo anchor('retur/index/transaksi','<i class="fa fa-rotate-left"></i> <span>Product Retur</span>'); ?></li>
					<?php } ?>
					<?php if (my_level()==null || my_level()=='Admin') { ?>
					<li <?php if(@$retur) echo $retur;?> ><?php echo anchor('retur/index/product','<i class="fa fa-rotate-left"></i> <span>Product Retur</span>'); ?></li>
					<?php } ?>
	      </ul>
	    </section>
	    <!-- /.sidebar -->
	  </aside>

		<div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        <?php if(@$title) echo $title; ?>&nbsp;
	        <small><?php if(@$subtitle) echo $subtitle; ?> &nbsp;</small>
	      </h1>
	    </section>

	    <!-- Main content -->
	    <?php if(@$page) $this->load->view($page); ?>
	    <!-- /.content -->
	  </div>

		<footer class="main-footer">
	    <div class="pull-right hidden-xs">
	      <b>Version</b> 2.3.12
	    </div>
	    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
	    reserved.
	  </footer>
	  <div class="control-sidebar-bg"></div>
	</div>
	<!--script type="text/javascript" src="<?php echo base_url();?>assets/dist/js/pages/dashboard2.js"></script-->
	<script>
		$(function() {
			$('#datepicker').datepicker({
	      autoclose: true,
	      language: 'en'
	    });
	    $('#datepicker1').datepicker({
	      autoclose: true,
	      language: 'en'
	    });
	    $('#datepicker2').datepicker({
	      autoclose: true,
	      language: 'en'
	    });
		});
	</script>
</body>
</html>