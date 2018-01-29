<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('blog/tambah','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Tambah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
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
	                <th>Product</th>
                  <th>Diskripsi</th>
	                <th width="100" class="center">Opsi</th>
	              </tr>
              </thead>
              <tbody>
                <?php
                  if ($listdata->result()) {
                    $no=1;
                    foreach ($listdata->result() as $val) {
                      echo '<tr>
                      <td>'.$no.'</td>
                      <td>'.$val->product.'</td>
                      <td>'.$val->diskripsi.'</td>
                      <td class="center">';

                      echo anchor('blog/edit/'.encrypts($val->id), '<i class="fa fa-fw fa-edit"></i>', array('class'=>'text-blue','title'=>'Ubah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo '&nbsp';
                      echo '<a href="javascript:void(0);" class="text-red" onclick="hapus(\''.encrypts($val->id).'\','.$no.')" title="Hapus" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-trash"></i></a>';

                      echo '</td>
                      </tr>';
                      $no++;
                    }
                  }
                  else {
                    echo '<tr><td colspan="4" class="center text-red">DATA KOSONG</td></tr>';
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