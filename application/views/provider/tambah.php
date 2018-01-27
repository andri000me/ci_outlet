<section class="content">
  <form method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Tambah Provider</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('provider','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
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
              <label class="control-label col-md-3">Kode</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="kode" value="<?php echo set_value('kode'); ?>" placeholder="xx" maxlength="2">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Provider</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="provider" value="<?php echo set_value('provider'); ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Keterangan</label>
              <div class="col-md-6">
                <textarea name="keterangan" rows="10" class="form-control"><?php echo set_value('keterangan'); ?></textarea>
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