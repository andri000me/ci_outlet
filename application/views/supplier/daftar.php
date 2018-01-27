<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Supplier</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
            <?php echo anchor('supplier/tambah','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Tambah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
            <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-database"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><?php echo anchor('supplier/template','Download Template');?></li>
                <li><?php echo anchor('supplier/import','Import Data');?></li>
                <li class="divider"></li>
                <li><?php echo anchor('supplier/export','Export Data');?></li>
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
					<div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
	              <tr>
	                <th width="1">#</th>
                  <th>Kode</th>
	                <th>Supplier</th>
                  <th>Telp 1</th>
                  <th>Telp 2</th>
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
                      echo '<td>'.$key->supplier.'</td>';
                      echo '<td>'.$key->telp1.'</td>';
                      echo '<td>'.$key->telp2.'</td>';
                      echo '<td class="center">';
                      echo anchor('supplier/detail/'.encrypts($key->id_supplier),'<i class="fa fa-fw fa-file-text"></i>', array('class'=>'text-green','title'=>'Detail', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo anchor('supplier/ubah/'.encrypts($key->id_supplier),'<i class="fa fa-fw fa-edit"></i>', array('class'=>'text-blue','title'=>'Ubah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo '<a href="javascript:void(0);" class="text-red" onclick="hapus(\''.encrypts($key->id_supplier).'\','.$no.')" title="Hapus" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-trash"></i></a>';
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