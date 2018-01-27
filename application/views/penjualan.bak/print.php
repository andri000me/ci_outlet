<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>print</title>
	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css"> -->
	<style>
		.center {
		  text-align: center;
		}
		.prlogo {
	    background: url(<?php echo 'data:image/*;base64,'.base64_encode($set->row()->logo)?>);
	    -moz-background-size: 100% 100%;
	    -webkit-background-size: 100% 100%;
	    background-size: 130px 35px;
	    background-position: center;
	    background-repeat: no-repeat;
	    width: 100%;
	    height: 50px;
	    border: 1px solid;
	    border-radius: 5px;
	  }
		body {
			font-family: "Consolas";
	    padding: 14px 0;
	    margin-left: 0;
	    position: fixed;
	    left: 0;
	    right: 55px;
	    font-size: 11px;
	    letter-spacing: -1px;
		}
		.pheader {
	    text-align: center;
	  }
	  .ptitle {
	    padding: 5px 0;
	  }
	  .pfooter p.center {
	    text-align: center;
	  }
	  table {
	    border-spacing: 0;
	    border-collapse: collapse;
	  }
	  .ptable {
	    width: 100%;
	    max-width: 100%;
	  }
	  .right {
	    text-align: right;
	  }
	  .fa-ig {
	  	background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAOCAYAAADwikbvAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAbhJREFUOE+FU0ursVEUfl63lBIpA6WkTBQTY7kkA0WYGJtjZuRPKBNm/ANDCWHmP0iSXGKgkFz3t9f6zqtzznc5T6322mu9z9prP2u/ipDodrtoNBpYLBbQ6/X4G+73O87nM9xuN0qlEuLxONDpdITM/Wg2m01kMhnh9Xp5z7xcLvfHh99NURTRbDapSTGfz9+FNKfTSeb/D8mB1Wpl3263Q6fTgXg6rVbLwe+o1+swmUw4HA4oFouoVCogbVarFbbbLYxGI5BMJrk1g8HwbnM8HnOLKgaDwTunWiqVEprr9YpAIABaCfl8HsFgkH0VkUgE2WyWfVmLFb/dbtBQQCUSXq/Xh/cVn+NEJDBZRTgcRqvVwnA4/Ij8Rr/fR7vdRjqd5iJ0OkGRwxYkwmQy4QSpeblcUK1WYbFYsNvtUC6XYTabsV6vuUufz8eGaDQq/H6/OB6PLM5msxGJROKLOPJEIYtwfr/fC6fTKWKxmAANmzbL5ZKTP2E2mwk5cyEFFEqv16Mq8Hg8cLlceDwedB18nv/z+eSV3r0kYzqdQvLAP8ZoNEKtVuM70ev5F6iww+FAoVBAKBTCL240NV8Ca08KAAAAAElFTkSuQmCC');
	  	-moz-background-size: 100% 100%;
	    -webkit-background-size: 100% 100%;
	    background-size: 12px 12px;
	    background-repeat: no-repeat;
			width: 15px;
			height: 13px;
			float: left;
	  }

	  .fa-call {
	  	background: url('data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA8Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2ODApLCBxdWFsaXR5ID0gOTAKAP/bAEMAAgEBAgEBAgICAgICAgIDBQMDAwMDBgQEAwUHBgcHBwYHBwgJCwkICAoIBwcKDQoKCwwMDAwHCQ4PDQwOCwwMDP/bAEMBAgICAwMDBgMDBgwIBwgMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDP/AABEIAA8ADwMBIgACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APpbTPjTJ+1r/wAFBv2atN+MXwt8OfE7wJ+1F4U1nxdoC+Jbo3WheFNLgge8021tNImzaT6gLT7LLeXMiS3Jl1FhG8NtbJFX0N+2JP4a/wCCLHwtuvjl4F0+TQ/hLok8Nr458B6fI66Sbe4b7NaXmk2efJsLuO+mtVkFuscM0E9wZY5JY4JI/Ff25fB/wd/ZP/Z28M/C39qC/wDFngn4d/DzVPtHwf8AjD4QneLVPDEaMwstOVbUS3lve2luVtt/2ea1uIYIJmdJmMMPO/sHfsg3f/BQj4HeJPCuqfG34s/H79mnxh4h/t7VPE/jqZY5fE6xRH7NpOl2rO93aQRXnlXdxPcLbqXs7aKC1KyzzIAf/9k=');
	  	-moz-background-size: 100% 100%;
	    -webkit-background-size: 100% 100%;
	    background-size: 12px 12px;
	    background-repeat: no-repeat;
			width: 15px;
			height: 13px;
			float: left;
	  }

	  .fa-bb {
	  	background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAOCAYAAADwikbvAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAGYktHRAD/AP8A/6C9p5MAAAFpSURBVDhPnZO7qsJAEIb/mICFxEKiIAZSpLBKb2mhlVhb+RBWVoLEKoViBMEXEETwMSwDYmVtKaKgIKjIujMnhhOOnNsHw87Mzi1DVvE8TxwOB2iaBiEEfkJRFNzvd1iWBXS7XZnzd/r9vkhIuOLlcsF+v2f9Bdnn8zm04tAEH5mSVCqFbDbLzt1uh8lkwnY6nUa5XA6j4kSd6czn8yiVSsjlclitVjAMgwu0222Omc1mmM/nrNOO0Ov1+BsejwefL67Xa8w3Ho9pmyymaYrpdCoSuq5jOBxCVVUeuVarceVkMhn5CNIbjQaazSaCIMDxeKTuGpbLJY+RyWTQ6XSw2Ww4gQpXq1XW6axUKrBtm+3b7Qa4rhsO9j0yPhLC930Rbfsz9XqdxyVZLBbYbre8xGKxiFarxTFyH+87y7tI1ut16I0zGAzed5Z3kTiOE3q/kuD2/4DylNFoJE6nE/8kv4H2QA+jUCjgCcBuKC7Bq+HUAAAAAElFTkSuQmCC');
	  	-moz-background-size: 100% 100%;
	    -webkit-background-size: 100% 100%;
	    background-size: 12px 12px;
	    background-repeat: no-repeat;
			width: 15px;
			height: 13px;
			float: left;
	  }

	  @media print {
		  .prlogo {
		    content:url(<?php echo 'data:image/*;base64,'.base64_encode($set->row()->logo)?>);
		  }
		  .fa-ig {
		  	content: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAOCAYAAADwikbvAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAbhJREFUOE+FU0ursVEUfl63lBIpA6WkTBQTY7kkA0WYGJtjZuRPKBNm/ANDCWHmP0iSXGKgkFz3t9f6zqtzznc5T6322mu9z9prP2u/ipDodrtoNBpYLBbQ6/X4G+73O87nM9xuN0qlEuLxONDpdITM/Wg2m01kMhnh9Xp5z7xcLvfHh99NURTRbDapSTGfz9+FNKfTSeb/D8mB1Wpl3263Q6fTgXg6rVbLwe+o1+swmUw4HA4oFouoVCogbVarFbbbLYxGI5BMJrk1g8HwbnM8HnOLKgaDwTunWiqVEprr9YpAIABaCfl8HsFgkH0VkUgE2WyWfVmLFb/dbtBQQCUSXq/Xh/cVn+NEJDBZRTgcRqvVwnA4/Ij8Rr/fR7vdRjqd5iJ0OkGRwxYkwmQy4QSpeblcUK1WYbFYsNvtUC6XYTabsV6vuUufz8eGaDQq/H6/OB6PLM5msxGJROKLOPJEIYtwfr/fC6fTKWKxmAANmzbL5ZKTP2E2mwk5cyEFFEqv16Mq8Hg8cLlceDwedB18nv/z+eSV3r0kYzqdQvLAP8ZoNEKtVuM70ev5F6iww+FAoVBAKBTCL240NV8Ca08KAAAAAElFTkSuQmCC');
		  }

		  .fa-call {
		  	content: url('data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA8Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2ODApLCBxdWFsaXR5ID0gOTAKAP/bAEMAAgEBAgEBAgICAgICAgIDBQMDAwMDBgQEAwUHBgcHBwYHBwgJCwkICAoIBwcKDQoKCwwMDAwHCQ4PDQwOCwwMDP/bAEMBAgICAwMDBgMDBgwIBwgMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDP/AABEIAA8ADwMBIgACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APpbTPjTJ+1r/wAFBv2atN+MXwt8OfE7wJ+1F4U1nxdoC+Jbo3WheFNLgge8021tNImzaT6gLT7LLeXMiS3Jl1FhG8NtbJFX0N+2JP4a/wCCLHwtuvjl4F0+TQ/hLok8Nr458B6fI66Sbe4b7NaXmk2efJsLuO+mtVkFuscM0E9wZY5JY4JI/Ff25fB/wd/ZP/Z28M/C39qC/wDFngn4d/DzVPtHwf8AjD4QneLVPDEaMwstOVbUS3lve2luVtt/2ea1uIYIJmdJmMMPO/sHfsg3f/BQj4HeJPCuqfG34s/H79mnxh4h/t7VPE/jqZY5fE6xRH7NpOl2rO93aQRXnlXdxPcLbqXs7aKC1KyzzIAf/9k=');
		  }

		  .fa-bb {
		  	content: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAOCAYAAADwikbvAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAGYktHRAD/AP8A/6C9p5MAAAFpSURBVDhPnZO7qsJAEIb/mICFxEKiIAZSpLBKb2mhlVhb+RBWVoLEKoViBMEXEETwMSwDYmVtKaKgIKjIujMnhhOOnNsHw87Mzi1DVvE8TxwOB2iaBiEEfkJRFNzvd1iWBXS7XZnzd/r9vkhIuOLlcsF+v2f9Bdnn8zm04tAEH5mSVCqFbDbLzt1uh8lkwnY6nUa5XA6j4kSd6czn8yiVSsjlclitVjAMgwu0222Omc1mmM/nrNOO0Ov1+BsejwefL67Xa8w3Ho9pmyymaYrpdCoSuq5jOBxCVVUeuVarceVkMhn5CNIbjQaazSaCIMDxeKTuGpbLJY+RyWTQ6XSw2Ww4gQpXq1XW6axUKrBtm+3b7Qa4rhsO9j0yPhLC930Rbfsz9XqdxyVZLBbYbre8xGKxiFarxTFyH+87y7tI1ut16I0zGAzed5Z3kTiOE3q/kuD2/4DylNFoJE6nE/8kv4H2QA+jUCjgCcBuKC7Bq+HUAAAAAElFTkSuQmCC');
		  }
		}
	</style>
</head>
<body>
	<section class="pheader">
		<?php if (@$set->row()->logo) {
			echo '<div class="prlogo"></div>';
			}
			else {
				echo @$set->row()->nama;
			}?>
		<div class="ptitle"><?php echo $set->row()->alamat?></div>
	</section>
	<section class="pcontent">
		<table class="ptable">
			<tr>
				<td colspan="2"># <?php echo $no_faktur?></td>
				<td class="right"><?php echo user_name()?></td>
			</tr>
			<tr>
				<td colspan="3"><?php echo $waktu_transaksi?></td>
			</tr>
			<tr>
				<td colspan="3"><span id="nama_barang">Nama Barang</span></td>
			</tr>
			<tr>
				<td colspan="2"><span id="Jumlah">Jumlah</span></td>
				<td class="right"><span id="Harga">Harga</span></td>
			</tr>
			<tr>
				<td colspan="3"><hr></td>
			</tr>
			<!-- Loop start -->
			<?php if ($list_barang->result()) {
				foreach ($list_barang->result() as $key) {
					$total = $key->quantity*$key->harga;
					echo "<tr><td colspan='3'>$key->product</td></tr>";
					echo "<tr>";
					echo "<td width='1'>$key->quantity</td>";
					echo '<td>&nbsp;x&nbsp;'.format_harga_rp($key->harga).'</td>';
					echo '<td class="right">'.format_harga_rp($total).'</td>';
					echo "</tr>";
				}
			}?>
			<!-- End of Loop -->
			<tr>
				<td colspan="3"><hr></td>
			</tr>
			<tr>
				<td colspan="2"><span id="Sup Total">Sub Total</span></td>
				<td class="right"><?php if(@$totalbelanja_awal) {echo format_harga_rp($totalbelanja_awal);} else echo '-';?></td>
			</tr>
			<tr>
				<td colspan="2"><span id="Diskon">Diskon</span></td>
				<td class="right"><?php if(@$total_disc) {echo format_harga_rp($total_disc);} else echo '-';?></td>
			</tr>
			<tr>
				<td colspan="2"><span id="Total">Total</span></td>
				<td class="right"><?php if(@$totalbelanja_akhir) {echo format_harga_rp($totalbelanja_akhir);} else echo '-';?></td>
			</tr>
			<tr>
				<td colspan="2"><span id="Bayar">Bayar</span></td>
				<td class="right"><?php if(@$tunai) {echo format_harga_rp($tunai);} else echo '-';?></td>
			</tr>
			<tr>
				<td colspan="2"><span id="Kembali">Kembali</span></td>
				<td class="right"><?php if(@$kembali) {echo format_harga_rp($kembali);} else echo '-';?></td>
			</tr>
		</table>
	</section>
	<section class="pfooter">
		<p class="center">** Terimakasih **</p>
		<p class="center">BARANG YANG SUDAH DIBELI TIDAK DAPAT DITUKAR KEMBALI</p>
		<?php if(@$set->row()->ig) echo '<p class="inline"><div class="fa-ig"></div>&nbsp; '.$set->row()->ig.'</p>'; ?>
		<?php if(@$set->row()->pin) echo '<p class="inline"><div class="fa-bb"></div>&nbsp; '.$set->row()->pin.'</p>'; ?>
		<?php if(@$set->row()->telp) echo '<p class="inline"><div class="fa-call"></div>&nbsp; '.$set->row()->telp.'</p>'; ?>
		<br>
		<hr>
	</section>
</body>
</html>