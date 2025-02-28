@extends('guest-app')

@section('title', $product->name . ' - ' . $venue->name)

@section('content')
    <div class="container mt-5">
        <div class="section-title-one mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h2 class="fw-bold">{{ $product->name }}</h2>
                        <p class="text-muted">{{ $venue->name }} - {{ $category->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="img-fluid rounded-3 shadow-sm"
                    style="height: 350px; object-fit: cover;">
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h3 class="card-title text-dark fw-bold">{{ $product->name }}</h3>
                        <p class="card-text text-muted">{{ $product->description }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if ($product->discount_price)
                                    <span class="badge bg-danger fs-6 text-decoration-line-through">{{ $product->price }}
                                        ₺</span>
                                    <span class="badge bg-success fs-6">{{ $product->discount_price }} ₺</span>
                                @else
                                    <span class="badge bg-success fs-6">{{ $product->price }} ₺</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4">
                            <h4 class="fw-bold">Ürün Özellikleri</h4>
                            <ul>
                                <li><strong>Fiyat:</strong> {{ $product->price }} ₺</li>
                                @if ($product->discount_price)
                                    <li><strong>İndirimli Fiyat:</strong> {{ $product->discount_price }} ₺</li>
                                @endif
                                <li><strong>Kategori:</strong> {{ $category->name }}</li>
                                <li><strong>İşletme:</strong> {{ $venue->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
