<!DOCTYPE html>
<html>
<head>
    <title>Absensi PDF</title>
</head>
<body>
    <center>
        <h1 style="margin-bottom:0px;">LAPORAN ABSENSI</h1>
        <h3 style="margin-top: 0px;">UPTD Klinik Hewan Kab. Karawang</h3>
        @if($data['tgl_awal'] != $data['tgl_akhir'])
            <h5>Dari Tanggal: {{$data['tgl_awal']}} s/d Tanggal: {{$data['tgl_akhir']}}</h5>
        @else
            <h5>Tanggal: {{$data['tgl_awal']}}</h5>
        @endif
        <br>
        <table cellspacing="0" cellpadding="0" align="center" border="2" style="border-collapse: collapse; border:2px solid black;">
            <thead>
                <tr>
                    <th style="text-align: center; padding: 7px;">No</th>
                    <th style="text-align: center; padding: 7px;">Nama</th>
                    <th style="text-align: center; padding: 7px;">Tanggal Absen</th>
                    <th style="text-align: center; padding: 7px;">Jam Masuk</th>
                    <th style="text-align: center; padding: 7px;">Jam Keluar</th>
                    <th style="text-align: center; padding: 7px;">Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['query'] as $val)
                    <tr>
                        <td style="padding: 7px;">{{$loop->iteration}}</td>
                        <td style="padding: 7px;">{{$val->nm_dokter}}</td>
                        <td style="padding: 7px;">{{$val->tgl_absen}}</td>
                        <td style="padding: 7px;">{{$val->jam_masuk}}</td>
                        <td style="padding: 7px;">{{$val->jam_keluar}}</td>
                        <td style="text-align:center;padding: 7px;">{{$val->kehadiran == 'y' ? 'HADIR' : 'TIDAK'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </center>
</body>
</html>