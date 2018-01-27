<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Detail Barang</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('barang','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
				</div>
				<div class="box-body">
          <?php
            $msg=validation_errors();
            if($msg!=NULL)
            echo msg_warning($msg);
          ?>
          <table class="table">
            <tbody>
              <tr>
                <td width="120">Kode</td>
                <td>: <?php if(empty($listdata->row()->kode)) {echo '-';} else echo $listdata->row()->kode;?></td>
              </tr>
              <tr>
                <td>barang</td>
                <td>: <?php if(empty($listdata->row()->barang)) {echo '-';} else echo $listdata->row()->barang;?></td>
              </tr>
              <tr>
                <td>Keteranga</td>
                <td>: <?php if(empty($listdata->row()->keterangan)) {echo '-';} else echo $listdata->row()->keterangan;?></td>
              </tr>
            </tbody>
          </table>
				</div>
				<div class="box-footer clearfix">
          <?php echo anchor('barang','Kembali', array('class'=>'btn btn-sm btn-default btn-flat pull-left','title'=>'Kembali', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
        </div>
			</div>
		</div>
	</div>
</section>