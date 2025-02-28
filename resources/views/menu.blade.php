@extends('guest-app')

@section('title', $venue->name . ' Menüsü')

@section('content')
    <div class="container">
        <div class="section-title-one mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="content">
                                <h2 class="fw-bold">{{ $venue->name }} Menüsü</h2>
                                <div
                                    class="d-flex justify-content-between align-items-center p-4 rounded-pill bg-light shadow-sm">
                                    <p class="mb-0 text-dark fw-bold">
                                        Şimdi işletme kaydı oluşturun, muhteşem menülerinizi herkes görsün...
                                    </p>
                                    <a href="/admin/register" class="btn btn-primary btn-lg rounded-pill shadow text-sm"
                                        style="margin-left:20px">
                                        <i class="bi bi-fast-forward"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($venue->categories as $category)
            <div class="mb-4">
                <div class="section-title-one mt-4">
                    <h3 class="text-primary border-bottom pb-2 fw-bold">{{ $category->name }}</h3>
                </div>
                <div class="row">
                    @foreach ($category->products as $product)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <a href="{{ route('product.show', [$venue->slug, $category->slug, $product->slug]) }}"
                                class="card shadow-sm border-0 rounded-3 text-decoration-none">
                                <div class="card shadow-sm border-0 rounded-3">
                                    <img src="{{ $product->featured_image }}" class="card-img-top"
                                        alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">

                                    <div class="card-body text-center">
                                        <h5 class="card-title text-dark fw-bold">{{ $product->name }}</h5>
                                        <p class="card-text text-muted">{{ $product->description }}</p>

                                        @if ($product->discount_price)
                                            <span
                                                class="badge bg-danger fs-6 text-decoration-line-through">{{ $product->price }}
                                                ₺</span>
                                            <span class="badge bg-success fs-6">{{ $product->discount_price }} ₺</span>
                                        @else
                                            <span class="badge bg-success fs-6">{{ $product->price }} ₺</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
