<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Surat Rujukan</title>
</head>
<body>
	<div style="border: 2px solid black; width:850px; height: 600px; padding: 10px;">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 200px;">
					<img src="{{ asset('images/logo_karawang.png') }}" alt="" style="width:180px; height: 150px;">
				</td>
				<td style="padding-top:none ; text-align:center">
					<span style="font-size:32px; font-weight:bold;">UPTD PUSKESWAN KARAWANG</span> <br><br> 
					Jl. Gandaria, Nagasari, Kec. Karawang Barat, Kab. Karawang, Jawa Barat 41314 <br>
					Telp: 0815-4272-1696
				</td>
			</tr>
		</table>
		<br>
		<hr style="border: 2px solid black">
		<span style="float:right">Karawang, {{ \Carbon\Carbon::now()->format('d') . ' ' . namaBulan(intval(\Carbon\Carbon::now()->format('m'))) . ' ' . \Carbon\Carbon::now()->format('Y') }}</span>
		<table border="0">
			<tr>
				<td style="width:90px;">No Surat</td>
				<td>:</td>
				<td style="width:50px;">{{ $data->id_rujukan }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Hal / Perihal</td>
				<td>:</td>
				<td>Rujukan Medis</td>
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
				<td>Di Bawah ini:</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Nama Pemilik </td>
				<td>:</td>
				<td>{{ $data->nm_pasien }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Nama Hewan </td>
				<td>:</td>
				<td>{{ $data->nm_hewan }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Jenis Hewan </td>
				<td>:</td>
				<td>{{ $data->jenis_hewan }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Keluhan </td>
				<td>:</td>
				<td>{{ $data->keluhan }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Diagnosa </td>
				<td>:</td>
				<td>{{ $data->ket_rujukan }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5">Dirujuk dari PUSKESWAN KARAWANG Ke {{ $data->lok_tujuan }}. Pada tanggal {{ substr($data->tgl_rujukan, -2) }} {{ namaBulan(intval(substr($data->tgl_rujukan, 5, 2))) }} {{ substr($data->tgl_rujukan, 0, 4) }}</td>
			</tr>
		</table>
		<span style="float:right; vertical-align:middle; text-align: center;">Mengetahui, <br> Kepala UPTD PUSKESWAN
		<br><br><br><br><br>drh. Dian Kurniasih</span>
	</div>
</body>
</html>