<section class="content">
  <form method="post" enctype="multipart/form-data">
	<div class="row">
    <div class="col-md-12">
      <?php
        $msg=$this->session->flashdata('msg');
        if($msg!=NULL)
        echo $msg;
      ?>
    </div>
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Setting Apps</h3>
        </div>
        <div class="box-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-md-3">Tips</label>
              <div class="col-md-6">
                <textarea name="tips" class="form-control" id="tips" cols="30" rows="3"><?php echo $listdata->row()->tips; ?></textarea>
              </div>
            </div>
            <br>
          </div>
        </div>
        <div class="box-footer clearfix">
          <input type="submit" name="simpan" value="Simpan" class="btn btn-sm btn-primary btn-flat pull-right">
        </div>
      </div>
    </div>
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Setting Nota</h3>
				</div>
				<div class="box-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-md-3">Nama</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="nama" value="<?php echo $listdata->row()->nama; ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Alamat</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="alamat" value="<?php echo $listdata->row()->alamat; ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Telp</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="telp" value="<?php echo $listdata->row()->telp; ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">PIN</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="pin" value="<?php echo $listdata->row()->pin; ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Instagram</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="ig" value="<?php echo $listdata->row()->ig; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Keterangan</label>
              <div class="col-md-6">
                <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"><?php echo $listdata->row()->keterangan; ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Logo</label>
              <div class="input-group col-md-6">
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
          <input type="submit" name="simpan" value="Simpan" class="btn btn-sm btn-primary btn-flat pull-right">
        </div>
			</div>
		</div>
	</div>
  </form>
</section>