<table>
  <thead>
  <tr>
      <th>No</th>
      <th>Nama</th>
      <th>NIK</th>
      <th>Alamat</th>
      <th>Kordinat</th>
      <th>Foto</th>
  </thead>
  <tbody>
      @php
          $no = 1;
      @endphp
  @foreach($daftar_pemilihs as $value)
      <tr>
          <td>{{ $no }}</td>
          <td>{{$value['nama_pemilih']}}</td>
          <td>{{ $value['alamat'] }}</td>
          <td>{{ $value['nik'] }}</td>
          <td>{{ $value['kordinat'] }}</td>
          <td>{{ $value['photo'] }}</td>
      </tr>
      @php
          $no++;
      @endphp
  @endforeach
  </tbody>
</table>
