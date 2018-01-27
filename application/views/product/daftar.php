<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Stock</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
            <?php echo anchor('product/tambah','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Tambah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
            <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
            <!-- <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Barcode"><i class="fa fa-barcode"></i></a> -->
            <div class="btn-group">
              <button jenis="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-database"></i></button>
              <ul class="dropdown-menu" role="menu">
                <!-- <li><?php echo anchor('product/template','Download Template');?></li>
                <li><?php echo anchor('product/import','Import Data');?></li>
                <li class="divider"></li> -->
                <li><?php echo anchor('product/export','Export Data');?></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="box-body">
          <?php
            $msg=$this->session->flashdata('msg');
            if($msg!=NULL)
            echo $msg;
          ?>
          <div class="form-inline">
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Supplier</label>
              <select name="id_supplier" class="form-control">
                <option value="">-- Supplier --</option>
                <?php if($listsupplier->result()){
                  foreach ($listsupplier->result() as $key) {
                    echo '<option value="'.$key->id_supplier.'"';
                    if($this->session->userdata('id_supplier')==$key->id_supplier) echo 'selected="selected"';
                    echo '>'.$key->supplier.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Jenis</label>
              <select name="id_jenis" class="form-control">
                <option value="">-- jenis --</option>
                <?php if($listjenis->result()){
                  foreach ($listjenis->result() as $key) {
                    echo '<option value="'.$key->id_jenis.'"';
                    if($this->session->userdata('id_jenis')==$key->id_jenis) echo 'selected="selected"';
                    echo '>'.$key->jenis.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Provider</label>
              <select name="id_provider" class="form-control">
                <option value="">-- provider --</option>
                <?php if($listprovider->result()){
                  foreach ($listprovider->result() as $key) {
                    echo '<option value="'.$key->id_provider.'"';
                    if($this->session->userdata('id_provider')==$key->id_provider) echo 'selected="selected"';
                    echo '>'.$key->provider.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <?php if(my_level()==NULL){?>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Lokasi</label>
              <select name="id_lokasi" class="form-control">
                <option value="">-- lokasi --</option>
                <?php if($listlokasi->result()){
                  foreach ($listlokasi->result() as $key) {
                    echo '<option value="'.$key->id_lokasi.'"';
                    if($this->session->userdata('id_lokasi')==$key->id_lokasi) echo 'selected="selected"';
                    echo '>'.$key->lokasi.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <?php }?>
            <button class="btn btn-primary" name="tampilkan">Tampilkan</button>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th width="1">#</th>
                  <th>Barcode Product</th>
                  <th>Product</th>
                  <th>Stock</th>
                  <th width="100" class="center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if ($listdata->result()) {
                    foreach ($listdata->result() as $key) {
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$key->kode.'</td>';
                      echo '<td>'.$key->product.'</td>';
                      echo '<td>'.stock($key->id_product).'</td>';
                      echo '<td class="center">';
                      echo anchor('product/detail/'.encrypts($key->id_product),'<i class="fa fa-fw fa-file-text"></i>', array('class'=>'text-green','title'=>'Detail', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo anchor('product/ubah/'.encrypts($key->id_product),'<i class="fa fa-fw fa-edit"></i>', array('class'=>'text-blue','title'=>'Ubah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo '<a href="javascript:void(0);" class="text-red" onclick="hapus(\''.encrypts($key->id_product).'\','.$no.')" title="Hapus" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-trash"></i></a>';
                      echo '</td>';
                      echo '</tr>';
                      $no++;
                    }
                  }
                  else {
                    echo '<tr><td colspan="5" class="center bg-red">Data Kosong</td></tr>';
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer clearfix">
          <?php if(@$pagination) echo $pagination;
          else echo '&nbsp;'; ?>
        </div>
      </div>
    </div>
  </div>
</section>