<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Product</h3>
          <!-- <div class="box-tools pull-right" style="display: -webkit-inline-box">
            <?php echo anchor('fashion-product/tambah','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Tambah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
            <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
            <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Barcode"><i class="fa fa-barcode"></i></a>
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-database"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><?php echo anchor('fashion-product/template','Download Template');?></li>
                <li><?php echo anchor('fashion-product/import','Import Data');?></li>
                <li class="divider"></li>
                <li><?php echo anchor('fashion-product/export','Export Data');?></li>
              </ul>
            </div>
          </div> -->
				</div>
				<div class="box-body">
          <?php
            $msg=$this->session->flashdata('msg');
            if($msg!=NULL)
            echo $msg;
          ?>
          <div class="form-inline">
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Kode</label>
              <input type="text" name="kode" class="form-control" placeholder="Kode">
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Quantity</label>
              <input type="text" name="quantity" class="form-control" placeholder="Quantity">
            </div>
            <button class="btn btn-flat" name="submit">Submit</button>
          </div>
          <br>
					<div class="table-responsive">
            <table class="table no-margin">
              <thead>
	              <tr>
	                <th width="1">#</th>
                  <th>Kode</th>
                  <th>Product</th>
                  <th>Stock</th>
                  <th width="100" class="center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if ($listdata->result()) {
                    $no=1;
                    foreach ($listdata->result() as $key) {
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$key->kode.'</td>';
                      echo '<td>'.$key->product.'</td>';
                      echo '<td>'.$key->quantity.'</td>';
                      echo '<td class="center">';
                      echo '<a href="javascript:void(0);" class="text-red" onclick="hapus(\''.encrypts($key->id_stock).'\','.$no.')" title="Hapus" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-trash"></i></a>';
                      echo '</td>';
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
          <button class="btn btn-flat btn-primary pull-right" <?php if (!$listdata->result()) echo 'disabled="disabled"';?> name="verifikasi">Verifikasi</button>
        </div>
			</div>
		</div>
	</div>
</section>