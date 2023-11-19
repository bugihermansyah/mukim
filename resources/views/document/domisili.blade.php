<h2 style="text-align: center;"><strong>&lt;&lt; rtwrw &gt;&gt;</strong></h2>
<p style="text-align: center;"><strong>&lt;&lt; nama_cluster &gt;&gt;</strong><br />KELURAHAN&lt;&lt; nama_kelurahan &gt;&gt;KECAMATAN&lt;&lt; nama_kecamatan &gt;&gt;<br />KOTA &lt;&lt; nama_kota &gt;&gt;</p>
<hr />
<p style="text-align: center;"><strong>S U R A T&nbsp; P E N G A N T A R<br /></strong>No : &lt;&lt; id &gt;&gt;/&lt;&lt; rtrw &gt;&gt;/&lt;&lt; kode_surat&gt;&gt;/&lt;&lt; tahun &gt;&gt;</p>
<p style="text-align: left;"><br />Ketua &lt;&lt; rtrw&gt;&gt;&lt;&lt; nama_cluster &gt;&gt;Kelurahan&lt;&lt; kelurahan &gt;&gt; Kecamatan &lt;&lt; nama_kecamatan &gt;&gt; Kota &lt;&lt; nama_kota &gt;&gt;, menerangkan bahwa :</p>
<table style="width: 818px; height: 118px; padding-left: 30px;">
<tbody style="padding-left: 30px;">
<tr style="padding-left: 30px; height: 13.975px;">
<td style="width: 174.387px; padding-left: 30px; text-align: left; height: 13.975px;">Nama Lengkap</td>
<td style="width: 623.613px; padding-left: 30px; text-align: left; height: 13.975px;">: {{ $record->warga->full_name }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">Jenis Kelamin</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ $record->warga->gender }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">Tempat / Tanggal Lahir</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ucwords($record->warga->birthplace) }} / {{ Carbon\Carbon::parse($record->warga->dob)->locale('id_ID')->format('d F Y') }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">No. KTP / KK</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ $record->warga->nik }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">Agama</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ ucwords($record->warga->religion) }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">Pekerjaan</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ ucwords($record->warga->work_type) }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">Kewarganegaraan</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ strtoupper($record->warga->citizen) }}</td>
</tr>
<tr style="padding-left: 30px; text-align: left; height: 13px;">
<td style="width: 174.387px; padding-left: 30px; height: 13px;">Alamat Lengkap</td>
<td style="width: 623.613px; padding-left: 30px; height: 13px;">: {{ $record->warga->status }}</td>
</tr>
</tbody>
</table>
<p style="text-align: left;">Bahwa benar nama tersebut diatas adalah penduduk / warga yang berdomisili diwilayah RT-001 / RW-XXI Perumahan Bumi Agung Permai Kelurahan Kibing Kecamatan Batu Aji Kota Batam, Surat pengantar ini diberikan untuk keperluan :</p>
<p style="text-align: center;">....................................................<strong>{{$record->notes }}</strong>....................................................</p>
<p style="text-align: left;">Demikian Surat Keterangan ini kami buat dengan sebenar-benarnya untuk digunakan sebagaimana mestinya.</p>
<p style="padding-left: 30px; text-align: left;">&nbsp;</p>
<p style="text-align: left;">&lt;&lt; nama_kota }}, &lt;&lt; tgl_dibuat }}.</p>
<p style="text-align: left;">Mengetahui,</p>
<table style="width: 654.025px; height: 56px; float: left;">
    <tbody>
    <tr style="height: 13px;">
    <td style="width: 219px; height: 13px; text-align: center;">Ketua RW &lt;&lt; rw }}</td>
    <td style="width: 78px; height: 13px; text-align: center;">&nbsp;</td>
    <td style="width: 70px; height: 13px; text-align: center;">&nbsp;</td>
    <td style="width: 242.025px; height: 13px; text-align: center;">Ketua RT &lt;&lt; rt }}</td>
    </tr>
    <tr style="height: 79.75px;">
    <td style="width: 219px; height: 79.75px;">&nbsp;</td>
    <td style="width: 78px; height: 79.75px;">&nbsp;</td>
    <td style="width: 70px; height: 79.75px;">&nbsp;</td>
    <td style="width: 242.025px; height: 79.75px;">&nbsp;</td>
    </tr>
    <tr style="height: 18px;">
    <td style="width: 219px; height: 18px; text-align: center;">&lt;&lt; nama_rw }}</td>
    <td style="width: 78px; height: 18px; text-align: center;">&nbsp;</td>
    <td style="width: 70px; height: 18px; text-align: center;">&nbsp;</td>
    <td style="width: 242.025px; height: 18px; text-align: center;">&lt;&lt; nama_rt }}</td>
    </tr>
    </tbody>
    </table>
<br>
<p style="text-align: left;"><strong><em><u>Catatan :</u></em></strong></p>
<p style="text-align: left;">Surat Keterangan ini untuk 1 (satu) kali pengurusan dan berlaku 1 (satu) minggu setelah tanggal dikeluarkannya surat ini.</p>