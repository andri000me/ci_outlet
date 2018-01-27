<section class="content">
  <form method="post" enctype="multipart/form-data">
  	<div class="row">
  		<div class="col-md-12">
  			<div class="box box-warning">
  				<div class="box-header">
  					<h3 class="box-title">Import</h3>
            <div class="box-tools pull-right" style="display: -webkit-inline-box">
            	<?php echo anchor('barang','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
            </div>
  				</div>
  				<div class="box-body">
            <?php
              $msg=$this->session->flashdata('msg');
              if($msg!=NULL)
              echo $msg;
            ?>
            <div class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-3">File Excel</label>
                <div class="col-md-6 input-group">
                  <span class="input-group-btn">
                    <div class="btn btn-default btn-flat">
                      <span class="">Browse</span>
                      <input type="file" accept="application/vnd.ms-excel,text/plain" name="userfile"/>
                    </div>
                  </span>
                  <input type="text" class="form-control url">
                </div>
              </div>
            </div>
  				</div>
  				<div class="box-footer clearfix">
            <input type="submit" name="batal" value="Batal" class="btn btn-sm btn-default btn-flat pull-left" data-toggle="tooltip" data-placement="top" title="Batal">
            <input type="submit" name="simpan" value="Simpan" class="btn btn-sm btn-info btn-flat pull-right" data-toggle="tooltip" data-placement="top" title="Simpan">
          </div>
  			</div>
  		</div>
  	</div>
  </form>
</section>