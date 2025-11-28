<h1>Halaman Product</h1>
<h2>Category : {{ $category }}</h2>

<ol>
    @foreach ( $products as $item )
    <li>{{ $item }}</li>
    
    @endforeach
</ol>