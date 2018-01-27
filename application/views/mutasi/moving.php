<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Mutasi Product</h3>
				</div>
				<div class="box-body">
					<table class="table">
            <tbody>
              <tr>
                <td width="120">Kode Product</td>
                <td>
                  : <?php if(empty($listdata->row()->kode)) {echo '-';} else echo $listdata->row()->kode;?>
                  <input type="hidden" name="id_product" value="<?php echo $listdata->row()->id_product?>" id="id_product">
                </td>
                <td width="120"></td>
                <td></td>
              </tr>
              <tr>
                <td>Product</td>
                <td>: <?php if(empty($listdata->row()->product)) {echo '-';} else echo $listdata->row()->product;?></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Lokasi Awal</td>
                <td>
                  <select name="lokasi_awal" id="lokasi_awal" <?php if(my_level()!=null) echo 'readonly';?> >
                    <option value="">Pilih Lokasi</option>
                    <?php if ($listlokasi->result()) {
                      foreach ($listlokasi->result() as $l) {
                        echo '<option value="'.$l->id_lokasi.'"';
                        if ($listdata->row()->id_lokasi==$l->id_lokasi) echo 'selected';
                        echo '>'.$l->lokasi.'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
                <td>Lokasi Akhir</td>
                <td>
                  <select name="lokasi_akhir" id="lokasi_akhir">
                    <option value="">Pilih Lokasi</option>
                    <?php if ($listlokasi->result()) {
                      foreach ($listlokasi->result() as $l) {
                        echo '<option value="'.$l->id_lokasi.'">'.$l->lokasi.'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
          <br>
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th width="1"><input type="checkbox" id="check_all" name="" value=""></th>
                  <th>Barcode Stock Product</th>
                  <th>Expired</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if ($listdetailstock->result()) {
                    foreach ($listdetailstock->result() as $key) {
                      echo '<tr>';
                      echo '<td><input type="checkbox" id="check" name="id_pdetail[]" value="'.$key->id_pdetail.'"></td>';
                      echo '<td>'.$key->kode.'</td>';
                      echo '<td>'.$key->exp.'</td>';
                      echo '</tr>';
                      $no++;
                    }
                  }
                  else {
                    echo '<tr><td colspan="4" class="center bg-red">Data Kosong</td></tr>';
                  }
                ?>
              </tbody>
            </table>
          </div>
				</div>
				<div class="box-footer clearfix">
          <div class="pull-left">
            <?php echo anchor('mutasi','Kembali', array('class'=>'btn btn-primary'))?>
            <button name="mutasi" id="submit_mutasi" class="btn btn-warning">Mutasi</button>
          </div>
          <div class="pull-right">
            <?php if(@$pagination) echo $pagination;
            else echo '&nbsp;'; ?>
          </div>
          <div class="clearfix"></div>
        </div>
			</div>
		</div>
	</div>
</section>=