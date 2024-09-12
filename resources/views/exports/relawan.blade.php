<table>
  <thead>
  <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>No Hp</th>
      <th>Jumlah Pemilih</th>
      <th>Bintang</th>
      <th>Alamat Posko</th>
      <th>Penanggung Jawab</th>
      <th>Nama TPS</th>
      <th>Alamat TPS</th>
  </tr>
  </thead>
  <tbody>
      @php
          $no = 1;
      @endphp
  @foreach($relawans as $value)
      <tr>
          <td>{{ $no }}</td>
          <td>{{$value['nama']}}</td>
          <td>{{ $value['alamat'] }}</td>
          <td>{{ $value['no_handphone'] }}</td>
          <td>{{ $value['count_pemilih'] }}</td>
          <td>{{ $value['star'] }}</td>
          <td>{{ $value['posko']['alamat'] }}</td>
          <td>{{ $value['posko']['penanggungjawab'] }}</td>
          <td>{{ $value['tps']['nama_tps'] }}</td>
          <td>{{ $value['tps']['alamat'] }}</td>
      </tr>
      @php
          $no++;
      @endphp
  @endforeach
  </tbody>
</table>
