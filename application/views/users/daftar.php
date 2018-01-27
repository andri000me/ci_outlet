<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar User</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('users/tambah','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Tambah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
            <?php echo anchor('users/export','<i class="fa fa-share-square-o"></i>', array('class'=>'btn btn-box-tool','title'=>'Export', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
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
	                <th>Nama</th>
                  <th>Username</th>
                  <th>Level</th>
                  <th>Email</th>
	                <th width="100" class="center">Opsi</th>
	              </tr>
              </thead>
              <tbody>
                <?php
                  if ($listdata->result()) {
                    foreach ($listdata->result() as $key) {
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$key->nama.'</td>';
                      echo '<td>'.$key->username.'</td>';
                      echo '<td>'.$key->level.'</td>';
                      echo '<td>'.$key->email.'</td>';
                      echo '<td class="center">';
                      echo anchor('users/detail/'.encrypts($key->id_user),'<i class="fa fa-fw fa-file-text"></i>', array('class'=>'text-green','title'=>'Detail', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo anchor('users/ubah/'.encrypts($key->id_user),'<i class="fa fa-fw fa-edit"></i>', array('class'=>'text-blue','title'=>'Ubah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo '<a href="javascript:void(0);" class="text-red" onclick="hapus(\''.encrypts($key->id_user).'\','.$no.')" title="Hapus" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-trash"></i></a>';
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