<section class="content">
	<div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Retur Satuan</h3>
        </div>
        <div class="box-body">
          <div class="form-groub">
            <lable class="control-label col-xs-2">Faktur</lable>
            <div class="col-xs-4">
              <input type="text" name="faktur_satuan" id="faktur_satuan" placeholder="0000000" class="form-control" data-toggle="tooltip" data-placement="top" title="No Faktur">
            </div>
          </div>
          <br><br>
        </div>
        <div class="box-footer clearfix">
          <div id="transaksi_satuan">
          	<table class="table table-bordered no-margin">
          		<tbody>
          			<tr>
          				<th>Tanggal</th>
          				<th>Barcode</th>
          				<th>Product</th>
          				<th>Harga</th>
          				<th>Quantity</th>
          			</tr>
          		</tbody>
          		<tbody id="tbl_transsatuan">
          			<tr>
          				<th>&nbsp;</th>
          				<th>&nbsp;</th>
          				<th>&nbsp;</th>
          				<th>&nbsp;</th>
          				<th>&nbsp;</th>
          			</tr>
          		</tbody>
          	</table>
          </div>
          <br><div id="opsiitem"></div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Retur Grosir</h3>
        </div>
        <div class="box-body">
          <div class="form-groub">
            <lable class="control-label col-xs-2">Faktur</lable>
            <div class="col-xs-4">
              <input type="text" name="faktur_grosir" id="faktur_grosir" placeholder="0000000" class="form-control" data-toggle="tooltip" data-placement="top" title="No Faktur">
            </div>
          </div>
          <br><br>
          <p id="faktur_trans"></p>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>Product</th>
                  <th>Harga @</th>
                  <th>Jumlah</th>
                  <th>Diskon (%)</th>
                  <th>Total</th>
                </tr>
              </tbody>
              <tbody id="tbl_transgrosir">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer clearfix">
          <div id="returgsr_scan"></div>
          <br>
          <div id="returgsr"></div>
        </div>
      </div>
    </div>

	</div>
</section>
