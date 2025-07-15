@extends('admin.layouts.master')
@section('body')

<!-- start page content-->
<div class="page-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="javascript:;">
                            <ion-icon name="home-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Product</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">

            <!-- Display Success and Error Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="card">
                <div class="card-header px-4 py-3">
                    <h5 class="mb-0">Product Form</h5>
                </div>
                <div class="card-body p-4">
                    <form id="jQueryValidationForm" method="post" action="{{ route('admin.product.update', $data->id) }}" enctype="multipart/form-data">
                        @csrf


                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" placeholder="Name" name="product_name" value="{{ $data->product_name }}">
                                @error('product_name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{ $data->price }}">
                                @error('price')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-sm-3 col-form-label">Stream url</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="stream_url" placeholder="stream_url" name="stream_url" value="{{ $data->stream_url }}">
                                @error('stream_url')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="image" name="image"><br><img style="margin-top: 10px;" src="/uploads/{{$data->image}}" width="100px" height="100px">
                                @error('image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start_time" class="col-sm-3 col-form-label">Start Time</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', isset($data) && $data->start_time ? \Carbon\Carbon::parse($data->start_time)->format('Y-m-d\TH:i') : '') }}">
                                @error('start_time')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Auction Duration</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-4">
                                        <input type="number" class="form-control" name="duration_hours" value="{{ old('duration_hours', $hours ?? 0) }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" name="duration_minutes" placeholder="Minutes" value="{{ old('duration_minutes', $minutes ?? 0) }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" name="duration_seconds" placeholder="Seconds" value="{{ old('duration_seconds', $seconds ?? 0) }}">
                                    </div>
                                </div>
                                @if ($errors->has('auction_duration'))
                                <span class="text-danger">
                                    {{ $errors->first('auction_duration') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4" name="submit2">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


@endsection