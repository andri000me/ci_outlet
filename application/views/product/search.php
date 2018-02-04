<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Hasil Pencarian</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
            <?php if (my_level()==null || my_level()=='Admin') { 
            	echo anchor('product','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
            }
            else {
              echo anchor('product/stock-product','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
            }
            ?>
          </div>
				</div>
				<div class="box-body">
          <div class="callout callout-info">
            <p>Hasil pencarian dari " <?php echo @$search ?> " ditemukan sebanyak " <?php echo sizeof($listdata->result()); ?> "</p>
          </div>
          <table class="table no-margin table-bordered" for="search">
            <thead>
              <tr>
                <th width="1">#</th>
                <th>Kode</th>
                <th>Product</th>
                <th>MSISDN</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <thbody>
              <?php 
              if ($listdata->result()) {
                $no=1;
                foreach ($listdata->result() as $val) {
                  echo "<tr>
                  <td>$no</td>
                  <td>$val->kode</td>
                  <td>$val->product</td>
                  <td>$val->msisdn</td>
                  <td>";


                  echo "</td>
                  </tr>";
                  $no++;
                }
              }
              else echo '<tr><td colspan="5" class="text-center text-red">DATA TIDAK DITEMUKAN</td></tr>' ;
              ?>
              
            </thbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>