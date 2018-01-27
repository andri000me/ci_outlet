<section class="content">
  <form method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Bayar</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
            <?php echo anchor('penjualan/transaksi_barang/'.$id_faktur,'<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
        </div>
        <div class="box-body">
          <?php
            $msg=validation_errors();
            if($msg!=NULL)
            echo msg_warning($msg);

            $msg2=$this->session->flashdata('msg');
            if($msg2!=NULL)
            echo $msg2;
          ?>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-md-3">Total Belanja</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="total_belanja" value="<?php echo @$total; ?>">
              </div>
            </div>
            <br>
            <div class="form-group">
              <label class="control-label col-md-3">Tunai</label>
              <div class="col-md-6">
                <input type="text" name="tunai" class="form-control" <?php if(isset($tunai)){ if($tunai!='0'){echo 'value="'.$tunai.'"'; }} ?> placeholder="Tunai">
              </div>
            </div>
            <br>
            <div class="form-group has-error" id="kembalian">
              <label class="control-label col-md-3">Kembali</label>
              <div class="col-md-6">
                <input type="text" name="kembalian" class="form-control" placeholder="Kembalian">
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer clearfix">
          <input type="submit" name="batal" value="Batal" class="btn btn-sm btn-default btn-flat pull-left" data-toggle="tooltip" data-placement="top" title="Batal">
          <input type="submit" name="bayar" value="BAYAR" class="btn btn-sm btn-info btn-flat pull-right" data-toggle="tooltip" data-placement="top" title="BAYAR">
        </div>
      </div>
    </div>
  </div>
  </form>
</section>