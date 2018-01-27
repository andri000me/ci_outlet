<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Detail Supplier</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('supplier','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
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
                <td>Supplier</td>
                <td>: <?php if(empty($listdata->row()->supplier)) {echo '-';} else echo $listdata->row()->supplier;?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>: <?php if(empty($listdata->row()->alamat)) {echo '-';} else echo $listdata->row()->alamat;?></td>
              </tr>
              <tr>
                <td>Telp 1</td>
                <td>: <?php if(empty($listdata->row()->telp1)) {echo '-';} else echo $listdata->row()->telp1;?></td>
              </tr>
              <tr>
                <td>Telp 2</td>
                <td>: <?php if(empty($listdata->row()->telp2)) {echo '-';} else echo $listdata->row()->telp2;?></td>
              </tr>
              <tr>
                <td>Keteranga</td>
                <td>: <?php if(empty($listdata->row()->keterangan)) {echo '-';} else echo $listdata->row()->keterangan;?></td>
              </tr>
            </tbody>
          </table>
				</div>
				<div class="box-footer clearfix">
          <?php echo anchor('supplier','Kembali', array('class'=>'btn btn-sm btn-default btn-flat pull-left','title'=>'Kembali', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
        </div>
			</div>
		</div>
	</div>
</section>