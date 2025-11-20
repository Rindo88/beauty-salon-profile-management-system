<html>
<head>
    <meta charset="utf-8">
    <style>table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:8px;font-size:12px}</style>
    <title>Produk</title>
</head>
<body>
    <h2>Data Produk</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th><th>Kategori</th><th>Harga</th><th>Diskon</th><th>Popularitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category }}</td>
                <td>{{ number_format($p->price_cents/100,0,',','.') }}</td>
                <td>{{ $p->discount_percent }}%</td>
                <td>{{ $p->popularity_score }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>