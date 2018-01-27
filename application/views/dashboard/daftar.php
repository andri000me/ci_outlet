<section class="content">
  <div class="row">
    <div class="col-md-12">
    	<?php if($set->row()->tips!='' || !empty($set->row()->tips)) {   echo '
      <div class="col-lg-12">
        <div class="callout callout-info">
          <h4>Tip!</h4>
          <p>'.$set->row()->tips.'</p>
        </div>
      </div>';}
      ?>



      <?php if (my_level()==null || my_level()=='Admin') {?>
      <!-- <div class="col-lg-3">
        small box
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>44</h3>
      
            <p>Registrations</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div> -->
      <?php }?>

      <?php if (my_level()==null || my_level()=='Admin') {?>
      <!-- <div class="col-lg-3">
        small box
        <div class="small-box bg-green">
          <div class="inner">
            <h3>44</h3>
      
            <p>User Registrations</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div> -->
      <?php }?>
      
      <?php if (my_level()==null || my_level()=='Admin') {?>
      <div class="col-lg-6">
        <div class="box box-warning">
					<div class="box-header">
						<h3 class="box-title">User Online</h3>
					</div>
					<div class="box-body">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th width="1">#</th>
                  <th>Username</th>
                  <th>Lokasi</th>
                  <th>Time</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($online->result()) {
                  $no=1;
                  foreach ($online->result() as $value) {
                    if ($value->status=='online') $status = '<span><small class="label pull-right bg-green">Online</small></span>';
                    elseif ($value->status=='offline') $status = '<span><small class="label pull-right bg-red">Offline</small></span>';
                    echo '
                    <tr>
                    <td>'.$no.'</td>
                    <td>'.get_username($value->id_user).'</td>
                    <td>'.get_lokasi($value->id_lokasi).'</td>
                    <td>'.$value->datetime.'</td>
                    <td>'.$status.'</td>
                    </tr>
                    ';
                    $no++;
                  }
                }
                else echo '<tr><td class="center" colspan="5">Tidak ada user online</td></tr>';
                ?>
              </tbody>
            </table>
					</div>
				</div>
      </div>
      <?php } ?>     
    </div>
  </div>
</section>

