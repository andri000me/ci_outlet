<section class="content">
	<div class="row">
		<!-- <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Manual <span class="small label label-primary">Coming Soon</span></h3>
        </div>
        <div class="box-body">
              <?php
                // $msg_manual1=validation_errors();
                // if($msg_manual1!=NULL)
                // echo msg_warning($msg_manual1);
              
                // $msg_manual2=$this->session->flashdata('msg');
                // if($msg_manual2!=NULL)
                // echo $msg_manual2;
              ?>
              <div class="form-inline">
                <form method="post">
                  <fieldset disabled>
                  <div class="form-group">
                    <label class="sr-only">Barcode</label>
                    <input type="text" class="form-control" placeholder="Barcode" name="barcode" data-toggle="tooltip" data-placement="top" title="Barcode">
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Nominal</label>
                    <input type="text" class="form-control" placeholder="Nominal" name="nominal" data-toggle="tooltip" data-placement="top" title="Nominal">
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Status</label>
                    <input type="text" class="form-control" placeholder="Status" name="status" data-toggle="tooltip" data-placement="top" title="Status">
                  </div>
                  <input type="submit" name="submit" value="Submit" class="btn btn-flat btn-info" data-content="submit_manual">
                  </fieldset>
                </form>
              </div>
        </div>
        <div class="box-footer clearfix">
              &nbsp;
            </div>
      </div>
    </div> -->

    <div class="col-md-12">
      <div class="box box-info bg-thorque">
        <div class="box-header">
          <h3 class="box-title">Scan</h3>
        </div>
        <div class="box-body">
          <div class="form-inline">
            <div class="form-group">
              <label class="sr-only">Barcode</label>
              <input type="text" id="sb" class="form-control" placeholder="Barcode" name="barcode" data-toggle="tooltip" data-placement="top" title="Barcode">
            </div>
            <div class="form-group">
              <label class="sr-only">Product</label>
              <input type="text" id="sp" class="form-control" placeholder="Product" name="product" data-toggle="tooltip" data-placement="top" title="Product">
            </div>
            <input type="submit" name="submit_scn" id="submit_scn" value="Submit" class="btn btn-flat btn-info">
          </div>
        </div>
        <div class="box-footer clearfix">
          &nbsp;
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box box-warning bg-thorque">
        <div class="box-header">
          <h3 class="box-title">Grosir</h3>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <div class="form-inline">
            <div class="form-group">
              <label class="sr-only">Barcode</label>
              <input type="text" id="gb" class="form-control" placeholder="Barcode" name="barcode" data-toggle="tooltip" data-placement="top" title="Barcode">
            </div>
            <div class="form-group">
              <label class="sr-only">Product</label>
              <input type="text" id="gp" class="form-control" placeholder="Product" name="product" data-toggle="tooltip" data-placement="top" title="Product">
            </div>
            <input type="submit" name="submit_gsr" id="submit_gsr" value="Submit" class="btn btn-flat btn-info">
          </div>
          <br>
          <table class="table table-bordered no-margin">
            <tbody>
              <tr>
                <th>Product</th>
                <th>Harga @</th>
                <th>Jumlah</th>
                <th>Diskon (%)</th>
                <th>Total</th>
                <th width="50" class="center">Opsi</th>
              </tr>
            </tbody>
            <tbody id="grosir_list">
              <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th width="50" class="center"><a href="javascript:void(0);" disabled="disabled"><i class="fa fa-trash text-red"></i></a></th>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <th colspan="4" class="text-right">Total Belanja</th>
                <th class="text-right"><span id="total">&nbsp;</span></th>
                <th width="50" class="center">Opsi</th>
              </tr>
            </tbody>
          </table>
          <table class="table">
            <tr>
              <td><button id="bersihkan_gsr" class="btn btn-flat btn-info">Bersihkan</button></td>
              <td width="50%">
                <input type="hidden" id="gsrtotal">
                <input type="text" name="gsrbayar" id="gsrbayar" placeholder="Bayar" class="form-control text-right" style="
                    font-size: xx-large;
                    width: 100%;
                    height: 50px;
                ">
                <br>
                <input type="text" name="gsrkembalian" id="gsrkembalian" placeholder="Kembali" class="form-control text-right" style="
                    font-size: xx-large;
                    width: 100%;
                    height: 50px;
                ">
              </td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>&nbsp;</td>
              <td width="1"><button id="print_gsr" class="btn btn-flat btn-info">Print</button></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
	</div>
</section>
