<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Struk Pembayaran</title>
</head>
<body>
	<div style="border: 2px solid black; width:450px; height: 650px; padding: 10px;">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 120px;">
					<img src="{{ asset('images/logo_karawang.png') }}" alt="" style="width:100px; height: 80px;">
				</td>
				<td style="padding-top:none ; text-align:center">
					<span style="font-size:18px; font-weight:bold;">UPTD PUSKESWAN KARAWANG</span> <br><br> 
					Jl. Gandaria, Nagasari, Kec. Karawang Barat, Kab. Karawang, Jawa Barat 41314 <br>
					Telp: 0815-4272-1696
				</td>
			</tr>
		</table>
		<br>
		<hr style="border: 2px solid black">
		<span style="float:right">Karawang, {{ \Carbon\Carbon::now()->format('d') . ' ' . namaBulan(intval(\Carbon\Carbon::now()->format('m'))) . ' ' . \Carbon\Carbon::now()->format('Y') }}</span>
		<br>
		<table border="0" width="100%"  cellpadding="0" cellspacing="0">
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td style="width:120px;">No Pembayaran</td>
				<td>:</td>
				<td style="width:50px;">{{ $data->id_pembayaran }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Nama Dokter</td>
				<td>:</td>
				<td>{{ $data->nm_dokter }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Nama Admin</td>
				<td>:</td>
				<td>{{ $data->nm_admin }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5"><center><b><u>Struk Pembayaran</u></b></center></td>
			</tr>
			<tr>
				<td colspan="2">Detail Pembayaran:</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">Keterangan</td>
				<td style="text-align:center;">Jumlah</td>
				<td style="text-align:center;">Harga</td>
				<td style="text-align:center;">Total</td>
			</tr>
			<tr>
				<td colspan="2">Pemeriksaan </td>
				<td style="text-align:center;"> - </td>
				<td style="text-align:center;">{{ $data->harga_pemeriksaan }}</td>
				<td style="text-align:center;">{{ $data->harga_pemeriksaan }}</td>
			</tr>
            @if(isset($dataobat))
                @foreach($dataobat as $val)
                    <tr>
                        <td colspan="2">{{ $val->nm_obat }}</td>
                        <td style="text-align:center;">{{ $val->jml_obat }}</td>
                        <td style="text-align:center;">{{ $val->harga_obat }}</td>
                        <td style="text-align:center;">{{ intval($val->jml_obat) * intval($val->harga_obat) }}</td>
                    </tr>
                @endforeach
            @endif
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="text-align:right;">Total Bayar </td>
				<td style="text-align:center;">{{ $ttlhrg }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="text-align:right;">Uang Bayar </td>
				<td style="text-align:center;">{{ $data->uang_bayar }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="text-align:right;">Kembalian </td>
				<td style="text-align:center;">{{ $data->uang_kembalian }}</td>
			</tr>
		</table>
		<br>
		<br>
		<center>
			<span style="vertical-align:middle; text-align: center;">Terimakasih telah merawat hewan peliharaan anda dengan baik ^_^</span>
		</center>
	</div>
</body>
</html>