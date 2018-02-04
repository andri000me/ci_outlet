<section class="content">
<form method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Tambah Stock Product</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('product','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
				</div>
				<div class="box-body">
          <?php
            $msg=validation_errors();
            if($msg!=NULL)
            echo msg_warning($msg);
          ?>
					<div class="row">
						<div class="form-group">
              <label class="control-label col-md-3">No. Barcode</label>
              <div class="col-md-6">
              	<input type="text" name="kode" class="form-control" placeholder="xxxxxxxxxxxxxxxxxxx">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">MSISDN</label>
              <div class="col-md-6">
              	<input type="text" name="msisdn" class="form-control" placeholder="000000000000">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Exp</label>
              <div class="col-md-6">
              	<input type="text" class="form-control" name="expired" id="datepicker" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Harga Pcs</label>
              <div class="col-md-6">
              	<input type="text" name="harga_awal" class="form-control" placeholder="000000">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Harga Grosir</label>
              <div class="col-md-6">
              	<input type="text" name="harga_akhir" class="form-control" placeholder="000000">
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