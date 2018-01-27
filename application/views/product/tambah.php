<section class="content">
  <form method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Tambah Product</h3>
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
            <div class="col-lg-6">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-md-3">Supplier</label>
                  <div class="col-md-6">
                    <select name="id_supplier" class="form-control">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listsupplier->result()) {
                        foreach ($listsupplier->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" ';
                          echo 'value="'.$key->id_supplier.'" ';
                          echo 'data-content="'.$key->supplier.'" ';
                          echo set_select('id_supplier',$key->id_supplier);
                          echo '>'.$key->supplier.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Jenis</label>
                  <div class="col-md-6">
                    <select name="id_jenis" class="form-control">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listjenis->result()) {
                        foreach ($listjenis->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" ';
                          echo 'value="'.$key->id_jenis.'" ';
                          echo 'data-content="'.$key->jenis.'" ';
                          echo set_select('id_jenis',$key->id_jenis);
                          echo '>'.$key->jenis.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Provider</label>
                  <div class="col-md-6">
                    <select name="id_provider" class="form-control">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listprovider->result()) {
                        foreach ($listprovider->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" ';
                          echo 'value="'.$key->id_provider.'" ';
                          echo 'data-content="'.$key->provider.'" ';
                          echo set_select('id_provider',$key->id_provider);
                          echo '>'.$key->provider.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Barang</label>
                  <div class="col-md-6">
                    <select name="id_barang" class="form-control">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listbarang->result()) {
                        foreach ($listbarang->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" ';
                          echo 'value="'.$key->id_barang.'" ';
                          echo 'data-content="'.$key->barang.'" ';
                          echo set_select('id_barang',$key->id_barang);
                          echo '>'.$key->barang.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Lokasi</label>
                  <div class="col-md-6">
                    <select name="id_lokasi" class="form-control">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listlokasi->result()) {
                        foreach ($listlokasi->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" ';
                          echo 'value="'.$key->id_lokasi.'" ';
                          echo 'data-content="'.$key->lokasi.'" ';
                          echo set_select('id_lokasi',$key->id_lokasi);
                          echo '>'.$key->lokasi.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Kode Barcode</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control disabled" name="kode" value="<?php echo set_value('kode')?>" placeholder="XXXXX" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-md-3">Harga Awal</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="harga_awal" id="harga_awal" value="<?php echo set_value('harga_awal')?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Harga jual</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="harga_jual" id="harga_jual" value="<?php echo set_value('harga_jual')?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Harga akhir</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="harga_akhir" id="harga_akhir" value="<?php echo set_value('harga_akhir')?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group" id="quantity">
                  <label class="control-label col-md-3">Quantity *</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="quantity" value="<?php echo set_value('quantity')?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <div class="col-md-offset-3 col-md-6">
                    <a class="btn btn-sm btn-primary btn-flat" id="btn-quantity">Quantity</a>
                    &nbsp;
                    <input type="submit" name="import" value="Import" class="btn btn-sm btn-info btn-flat">
                  </div>
                </div>
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