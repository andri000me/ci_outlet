<section class="content">
	<div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Mutasi</h3>
        </div>
        <div class="box-body">
          <div class="form-groub">
            <lable class="control-label col-xs-2">Barcode</lable>
            <div class="col-xs-4">
              <input type="text" name="mutasi_scan" id="mutasi_scan" placeholder="0000000" class="form-control">
            </div>
          </div>
          <div class="form-groub">
            <lable class="control-label col-xs-2">Mutasi Tujuan</lable>
            <div class="col-xs-4">
              <select name="id_lokasi" id="id_lokasi" class="form-control">
                <option value="">-- Pilih Lokasi --</option>
                <?php
                if ($listlokasi->result()) {
                  foreach ($listlokasi->result() as $val) {
                    echo '<option value="'.$val->id_lokasi.'">'.$val->lokasi.'</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <br><br>
          <table class="table no-margin table-bordered">
            <thead>
              <tr>
                <th>Product</th>
                <th>Jumlah</th>
                <!-- <th>Expired</th> -->
                <th width="1" class="center">Opsi</th>
              </tr>
            </thead>
            <tbody id="list_mutasi">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <!-- <td>&nbsp;</td> -->
                <td width="1" class="center"><a href="javascript:void(0);" disabled="disabled"><i class="fa fa-trash text-red"></i></a></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="box-footer">
          <button id="bersihkan" class="btn btn-flat btn-primary pull-left">Bersihkan</button>
          <button id="mutasi_submit" class="btn btn-flat btn-primary pull-right">Mutasi</button>
        </div>
      </div>
    </div>

		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Product</h3>
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
            <button class="btn btn-flat" name="tampilkan">Tampilkan</button>
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
                      echo anchor('mutasi/riwayat/'.encrypts($key->id_product),'<i class="fa fa-fw fa-tasks"></i>', array('class'=>'text-green','title'=>'Riwayat', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
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