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
                    <li class="breadcrumb-item active" aria-current="page">Add Product</li>
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
                    <form id="jQueryValidationForm" method="post" action="{{ route('admin.product.create') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="input38" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" id="input41" name="category_id" value="{{ $data->id}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input38" class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input41" value="{{ $data->category }}">
                                @error('category')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" placeholder="Name" name="product_name" value="{{ old('product_name') }}">
                                @error('product_name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{ old('price') }}">
                                @error('price')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-sm-3 col-form-label">Stream url</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="stream_url" placeholder="stream_url" name="stream_url" value="{{ old('stream_url') }}">
                                @error('stream_url')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="image" name="image">
                                @error('image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start_time" class="col-sm-3 col-form-label">Start Time</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', isset($product) ? \Carbon\Carbon::parse($product->start_time)->format('Y-m-d\TH:i') : '') }}">
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
                                        <input type="number" class="form-control" name="duration_hours" placeholder="Hours" value="{{ old('duration_hours') }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" name="duration_minutes" placeholder="Minutes" value="{{ old('duration_minutes') }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" name="duration_seconds" placeholder="Seconds" value="{{ old('duration_seconds') }}">
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
                                    <button type="submit" class="btn btn-primary px-4" name="submit2">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <h6 class="mb-0 text-uppercase">Product List</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>SI.No</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stream url</th>
                            <th>Image</th>
                            <th>Start Time</th>
                            <th>Auction Duration</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $id=1; @endphp
                        @forelse($item as $items)
                        <tr>
                            <td>{{ $id++ }}</td>
                            <td>{{ $items->product_name }}</td>
                            <td>{{ $items->price }}</td>
                            <td>{{ $items->stream_url }}</td>
                            <td>
                                <img src="/uploads/{{ $items->image }}" width="70px" height="70px" class="product-img-2">
                            </td>
                            <td>{{ \Carbon\Carbon::parse($items->start_time)->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $items->duration_seconds }}</td>
                            <td>
                                <a href="{{ route('admin.product.Edit', $items->id) }}" class="icon-style-edit"><ion-icon name="create-outline"></ion-icon></a>
                            </td>
                            <td>
                                <a href="{{ route('admin.product.delete', $items->id) }}" onclick="return confirm('Are you sure you want to delete this item?');" class="icon-style-trash"><i class="lni lni-trash"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No Records Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


@endsection