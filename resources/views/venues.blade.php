@extends('guest-app')

@section('title', 'KAFELER')

@section('content')

    <div class="section-title-one mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <div class="content">
                            <h2 class="fw-bold">İŞLETMELER</h2>
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

    <div class="row justify-content-center">
        @foreach ($venues as $venue)
            <div class="col-md-4 col-lg-3 mb-4">
                <a href="{{ route('venue.show', $venue->slug) }}"
                    class="card shadow-sm border-0 rounded-3 text-decoration-none">
                    <div class="card shadow-sm border-0 rounded-3">
                        <img src="{{ $venue->featured_image }}" class="card-img-top" alt="{{ $venue->name }}"
                            style="height: 180px; object-fit: cover;">

                        <div class="card-body text-center">
                            <h5 class="card-title text-dark fw-bold">{{ $venue->name }}</h5>
                            <p class="card-text text-muted">{{ $venue->address }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection
