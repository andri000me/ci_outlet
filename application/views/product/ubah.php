<section class="content">
  <form method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Ubah Product</h3>
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
                    <select name="id_supplier" class="form-control" readonly="readonly">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listsupplier->result()) {
                        foreach ($listsupplier->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" value="'.$key->id_supplier.'" ';
                          if ($listdata->row()->id_supplier==$key->id_supplier) echo 'selected="selected"';
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
                    <select name="id_jenis" class="form-control" readonly="readonly">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listjenis->result()) {
                        foreach ($listjenis->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" value="'.$key->id_jenis.'" ';
                          if ($listdata->row()->id_jenis==$key->id_jenis) echo 'selected="selected"';
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
                    <select name="id_provider" class="form-control" readonly="readonly">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listprovider->result()) {
                        foreach ($listprovider->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" value="'.$key->id_provider.'" ';
                          if ($listdata->row()->id_provider==$key->id_provider) echo 'selected="selected"';
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
                    <select name="id_barang" class="form-control" readonly="readonly">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listbarang->result()) {
                        foreach ($listbarang->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" value="'.$key->id_barang.'" ';
                          if ($listdata->row()->id_barang==$key->id_barang) echo 'selected="selected"';
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
                    <select name="id_lokasi" class="form-control" readonly="readonly">
                      <option data-val="" value="">-- --</option>
                      <?php if ($listlokasi->result()) {
                        foreach ($listlokasi->result() as $key) {
                          echo '<option data-val="'.$key->kode.'" value="'.$key->id_lokasi.'" ';
                          if ($listdata->row()->id_lokasi==$key->id_lokasi) echo 'selected="selected"';
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
                    <input type="text" class="form-control" name="kode" value="<?php echo $listdata->row()->kode;?>" placeholder="XXXXX" readonly="readonly">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-md-3">Harga Awal</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="harga_awal" id="harga_awal" value="<?php echo $listdata->row()->harga_awal;?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Harga Pcs</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="harga_jual" id="harga_jual" value="<?php echo $listdata->row()->harga_jual;?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="control-label col-md-3">Harga Grosir</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="harga_akhir" id="harga_akhir" value="<?php echo $listdata->row()->harga_akhir;?>" placeholder="0000">
                  </div>
                </div>
                <br>
                <div class="form-group" id="quantity">
                  <label class="control-label col-md-3">Quantity *</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="quantity" value="<?php echo $listdata->row()->quantity;?>" placeholder="0000">
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
          <br>
          <table class="table no-margin" for="stock">
            <thead>
              <tr>
                <th width="1">#</th>
                <th>Kode Barcode</th>
                <th>msisdn</th>
                <th>Expired</th>
                <th>Keterangan</th>
                <th width="100" class="center">Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($listdetailstock->result()) {
                  foreach ($listdetailstock->result() as $key) {
                    echo '<tr>';
                    echo '<td>'.$no.'</td>';
                    echo '<td>'.$key->kode.'</td>';
                    echo '<td>'.$key->msisdn.'</td>';
                    echo '<td>'.$key->exp.'</td>';
                    echo '<td>'.$key->keterangan.'</td>';
                    echo '<td class="center">';
                    echo '<a href="javascript:void(0);" class="text-blue" onclick="javascript:edit(\''.$key->id_pdetail.'\',\''.$key->kode.'\',\''.$key->msisdn.'\',\''.$key->exp.'\',\''.encrypts($listdata->row()->id_product).'\')" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-edit"></i></a>';
                    echo '<a href="javascript:void(0);" class="text-red" onclick="hapus(\''.$key->id_pdetail.'\',\''.$no.'\',\''.encrypts($listdata->row()->id_product).'\')" title="Hapus" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-trash"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                    $no++;
                  }
                }
                else {
                  echo '<tr><td colspan="6" class="center bg-red">Data Kosong</td></tr>';
                }
              ?>
            </tbody>
          </table>
          <?php if(@$pagination) echo $pagination;?>
        </div>
        <div class="box-footer clearfix">
          <input type="submit" name="batal" value="Batal" class="btn btn-sm btn-default btn-flat pull-left" data-toggle="tooltip" data-placement="top" title="Batal">
          <input type="submit" name="simpan" value="Simpan" class="btn btn-sm btn-info btn-flat pull-right" data-toggle="tooltip" data-placement="top" title="Simpan">
        </div>
      </div>
    </div>
  </div>
  </form>
  <div id="mymodal" class="modal fade">
    <script>
      $(function() {
        $('#mdate').datepicker({
          language: 'en'
        });
      });
    </script>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="mtitle"></h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Kode</label>
            <input type="hidden" id="mid">
            <input type="hidden" id="mkey">
            <input type="text" class="form-control" id="mkode">
          </div>
          <div class="form-group">
            <label>MSISDN</label>
            <input type="text" class="form-control" id="mmsisdn">
          </div>
          <div class="form-group">
            <label>Expired</label>
            <input type="text" class="form-control" id="mdate" data-date-format="yyyy-mm-dd">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea id="mketerangan" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" onclick="javascript:simpan()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</section>