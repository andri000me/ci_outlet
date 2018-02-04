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
					echo '<tr>
					<td>'.$value->product.'</td>
					<td class="right" width="1">'.$value->jumlah.'</td>
					<td class="right">'.$value->hargasatuan.'</td>
					<td class="right">'.$value->total.'</td>
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
				<td colspan="2" class="right border">Total Belanja</td>
				<td class="right border"><?php echo $total;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="right">Potongan</td>
				<td class="right"><?php echo $potongan;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="right">Total Akhir</td>
				<td class="right"><?php echo $totalbelanja;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="right">Bayar</td>
				<td class="right"><?php echo $bayar;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="right">Kembali</td>
				<td class="right"><?php echo $kembalian;?></td>
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