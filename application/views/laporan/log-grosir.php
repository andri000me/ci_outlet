<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Barang</h3>
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
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th width="1">#</th>
                  <th>Tanggal</th>
                  <th>No Faktur</th>
                  <th>Total Belanja (Rp)</th>
                  <th width="1">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($listdata->result()) {
                  foreach ($listdata->result() as $val) {
                    echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val->tanggal.'</td>
                    <td>'.$val->no_faktur.'</td>
                    <td>'.$val->total.'</td>
                    <td>';
                    echo anchor('laporan/log-grosir/detail/'.encrypts($val->id_faktur),'<i class="fa fa-fw fa-file-text"></i>', array('class'=>'text-green','title'=>'Detail', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                    echo '</td>
                    </tr>';
                    $no++;
                  }
                }
                else echo '<tr><td colspan="5" class="center bg-red">Data Kosong</td></tr>';
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