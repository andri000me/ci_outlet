<!DOCTYPE html>
<html>
<head>
	<title>:: 4171 CARD ::</title>
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
  <script type="text/javascript">var app={base_url:'<?php echo base_url();?>'}</script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#refresh').click(function(event) {
        $.get('<?php echo base_url().'signin/refresh'; ?>', function(data){
            $('#captImg').html(data);
        });
      });
    });
  </script>
  <style>
    .bg-weetasphal {
      background: rgba(52, 73, 94,1.0);
    }
    .bg-clouds {
      background: rgba(236, 240, 241,0.5);
    }
    .cubix {
      margin-top: 25%;
      padding: 20px;
      border-radius: 5px;
      border: 5px solid rgba(189, 195, 199,0.7);
    }
  </style>
</head>
<body class="bg-weetasphal">
  <div class="container">
  	<div class="row">
      <div class="col-md-4">&nbsp;</div>
      <div class="col-md-4">
        <div class="bg-clouds cubix">
          <form method="post">
            <legend>Login</legend>
            <?php
              $try=$this->session->userdata('try');
              $msg=validation_errors();
              if($msg!=NULL)
              echo msg_warning($msg);
            ?>
            <div class="form-group">
              <label for="username-email">E-mail or Username</label>
              <input name="username" id="username-email" placeholder="E-mail or Username" type="text" class="form-control" />
            </div>
            <div class="form-group">
              <label for="username-email">Lokasi</label>
              <select name="id_lokasi" class="form-control">
                <option value="">-- Lokasi --</option>
                <?php if($lokasi->result()){
                  foreach ($lokasi->result() as $key) {
                    echo '<option value="'.$key->id_lokasi.'"';
                    set_select('id_lokasi', $key->id_lokasi);
                    echo '>'.$key->lokasi.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input name="password" type="password" id="password" placeholder="Password" type="text" class="form-control" />
            </div>
            <?php if($try>2) { ?>
            <div class="form-group">
              <span id="captImg"><?php echo $captchaIMG; ?></span>
              <button id="refresh" class="btn btn-link btn-xs"><i class="fa fa-refresh"></i></button>
            </div>
            <div class="form-group">
              <label for="password">Captcha</label>
              <input type="text" class="form-control" name="captcha"/>
            </div>
            <?php }?>
            <div class="form-group text-center">
              <!-- <button class="btn btn-danger btn-cancel-action btn-flat">Cancel</button> -->
              <input type="submit" class="btn btn-success btn-login-submit btn-flat btn-block" name="signin" value="Sign in" />
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-4">&nbsp;</div>
    </div>
  </div>
</body>
</html>