<html>
<head>
    <meta charset="utf-8">
    <style>table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:8px;font-size:12px}</style>
    <title>Reservasi</title>
    </head>
<body>
    <h2>Data Reservasi</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th><th>Telepon</th><th>Email</th><th>Tanggal</th><th>Waktu</th><th>Layanan</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $r)
            <tr>
                <td>{{ $r->customer_name }}</td>
                <td>{{ $r->phone }}</td>
                <td>{{ $r->email }}</td>
                <td>{{ $r->date }}</td>
                <td>{{ $r->time_slot }}</td>
                <td>{{ optional($r->service)->name }}</td>
                <td>{{ $r->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>