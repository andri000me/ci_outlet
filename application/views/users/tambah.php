<section class="content">
  <form method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Tambah User</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('users','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
				</div>
				<div class="box-body">
          <?php
            $msg=validation_errors();
            if($msg!=NULL)
            echo msg_warning($msg);
          ?>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-md-3">Username</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password_new">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Ulang Password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="re_password">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Level</label>
              <div class="col-md-6">
                <select name="level" class="form-control">
                  <option value="Admin">Admin</option>
                  <option value="Seles">Seles</option>
                </select>
              </div>
            </div>
            <!-- <br>
            <div class="form-group">
              <label class="control-label col-md-3">Lokasi</label>
              <div class="col-md-6">
                <select name="id_lokasi" class="form-control">
                  <option value="">-- Lokasi --</option>
                  <?php /*if($listlokasi->result()){
                    foreach ($listlokasi->result() as $key) {
                      echo '<option value="'.$key->id_lokasi.'"';
                      set_select('id_lokasi', $key->id_lokasi);
                      echo '>'.$key->lokasi.'</option>';
                    }
                  }*/
                  ?>
                </select>
              </div>
            </div> -->
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Nama</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama'); ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Alamat</label>
              <div class="col-md-6">
                <textarea name="alamat" rows="10" class="form-control"><?php echo set_value('alamat'); ?></textarea>
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Telp 1</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="telp1" value="<?php echo set_value('telp1'); ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Telp 2</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="telp2" value="<?php echo set_value('telp2'); ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Photo</label>
              <div class="col-md-6 input-group">
                <span class="input-group-btn">
                  <div class="btn btn-default btn-flat">
                    <span class="">Browse</span>
                    <input type="file" accept="image/png, image/jpg" name="userfile"/>
                  </div>
                </span>
                <input type="text" class="form-control url">
              </div>
            </div>
          </div>
				</div>
				<div class="box-footer clearfix">
          <input type="submit" name="batal" value="Batal" class="btn btn-sm btn-default btn-flat pull-left" data-toggle="tooltip" data-placement="top" title="Batal">
          <input type="submit" name="simpan" value="Simpan" class="btn btn-sm btn-info btn-flat pull-right" data-toggle="tooltip" data-placement="top" title="Simpan">
        </div>
			</div>
		</div>
	</div>
  </form>
</section>