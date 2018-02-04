<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Nota</title>
	<link rel="stylesheet" href="">
	<style>
		body {
			font-size: 0.7em;
			font-family: "Consolas";
			left: 20px;
	    right: 20px;
	    padding: 14px 0;
	    margin-left: 0;
	    position: fixed;
		}
		section {
			padding: 5px 0;
		}
		table {
			font-size: 0.77em;
			font-family: "Consolas";
	    border-spacing: 0;
	    border-collapse: collapse;
	  }

		.center {
		  text-align: center;
		}
		.left {
		  text-align: left;
		}
		.right {
		  text-align: right;
		}
		.head, .footer {
		  text-align: center;
		}
		.logdate {
	    border-top: 1px dashed;
	    border-bottom: 1px dashed;
		}
		.border {
			border-top: 1px dashed;
			border-bottom: 1px dashed;
			padding: 5px 0;
		}

	  @media print {
		  .prlogo {
		    content: url(<?php echo 'data:image/*;base64,'.base64_encode($set->row()->logo)?>);
		  }
		}
	</style>
</head>
<body>
	<section class="head">
		<span>
			<?php if (@$set->row()->logo) {
				echo '<div class="prlogo"></div>';
				}
				else {
					echo @$set->row()->nama;
			}?>
		</span><br>
		<span><?php echo $set->row()->alamat?></span><br>
		<table width="100%">
			<tr>
				<?php
					if(@$set->row()->ig) echo '<td class="center">IG: '.$set->row()->ig.'</td>';
					if(@$set->row()->pin) echo '<td class="center">PIN: '.$set->row()->pin.'</td>';
					if(@$set->row()->telp) echo '<td class="center">TELP: '.$set->row()->telp.'</td>';
				?>
			</tr>
		</table>
	</section>
	<section class="logdate">
		<table width="100%">
			<tr>
				<td class="left">Nota: <?php echo $no_faktur;?></td>
				<td class="center"><?php echo $waktu_transaksi;?></td>
				<td class="right"><?php echo user_name();?></td>
			</tr>
		</table>
	</section>
	<section id="listbelanja">
		<table width="100%">
			<?php if ($listdata->result()) {
				foreach ($listdata->result() as $value) {
					if (msisdn($value->kode_stock)) {
						echo '<tr>
						<td>MSISDN: '.msisdn($value->kode_stock).'</td>
						</tr>';
					}
					echo '<tr>
					<td>'.$value->kode_stock.'</td>
					</tr>';
					echo '<tr>
					<td>'.$value->nama_product.'</td>
					<td class="right" width="1">'.$value->totalitem.'</td>
					<td class="right">'.$value->harga_satuan.'</td>
					<td class="right">'.$value->totalitem*$value->harga_satuan.'</td>
					</tr>';
				}
			}
			else {
				echo '<tr>
				<td>0</td>
				<td class="right">0</td>
				<td class="right">0</td>
				<td class="right">0</td>
				</tr>';
			}
			?>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="right border">Total Harga</td>
				<td class="right border"><?php echo $totalbelanja;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="right">Total belanja</td>
				<td class="right"><?php echo $totalbelanja;?></td>
			</tr>
		</table>
	</section>
	<section class="footer">
		<span style="font-size: 0.68em;">*** TERIMA KASIH. SELAMAT BELANJA KEMBALI ***</span>
		<br>
		<span><?php echo @$set->row()->keterangan;?></span>
	</section>
</body>
</html>