<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Transaksi</h3>
        </div>
        <div class="box-body">
          <div class="form-inline">
            <?php if(my_level()!='Seles') { ?>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Lokasi</label>
              <select name="id_lokasi" id="id_lokasi" class="form-control">
                <option value="">-- Lokasi --</option>
                <?php if ($listlokasi->result()) {
                  foreach ($listlokasi->result() as $key) {
                    echo '<option value="'.$key->id_lokasi.'"';
                    if($this->session->userdata('id_lokasi')==$key->id_lokasi) echo 'selected="selected"';
                    echo '>'.$key->lokasi.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">User</label>
              <select name="id_user" id="id_user" class="form-control">
                <option value="">-- Seles --</option>
                <?php if ($listuser->result()) {
                  foreach ($listuser->result() as $key) {
                    echo '<option value="'.$key->id_user.'"';
                    if($this->session->userdata('id_user')==$key->id_user) echo 'selected="selected"';
                    echo '>'.$key->nama.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Tanggal Awal</label>
              <input type="text" class="form-control" name="tanggal_awal" id="datepicker1" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $this->session->userdata('tgl_awal')?>">
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Tanggal Akhir</label>
              <input type="text" class="form-control" name="tanggal_akhir" id="datepicker2" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $this->session->userdata('tgl_akhir')?>">
            </div>
            <button class="btn btn-flat btn-primary" name="tampilkan">Tampilkan</button>
            
          </div>
          <br>
          <div>
            <table class="table no-margin table-bordered" for="pcs_list">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>No Faktur</th>
                  <th>MSISDN/ Barcode</th>
                  <th>Product</th>
                  <th>Harga (Rp)</th>
                  <th>Quantity</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($listdata->result()) {
                  $no=1;
                  foreach ($listdata->result() as $val) {
                    echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val->tanggal.'</td>
                    <td>'.$val->no_faktur.'</td>
                    <td>'.msisdn($val->kode_stock).'<br>'.$val->kode_stock.'</td>
                    <td>'.$val->nama_product.'</td>
                    <td>'.$val->totalbelanja_akhir.'</td>
                    <td>'.$val->totalitem.'</td>
                    <td>
                    <a href="#" class="text-blue" title="Print" data-toggle="tooltip" data-placement="top" onclick="print('.$val->id_faktur.')"><i class="fa fa-fw fa-print"></i></a>
                    </td>
                    </tr>';
                    $no++;
                  }
                }
                else echo '<tr><td colspan="8" class="center bg-red">Data Kosong</td></tr>';
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