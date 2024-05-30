@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Brands</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create new Brand</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- right column --}}
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add New Brand</h3>
                            </div>
                            <!-- /.card-header -->
                            {{-- show custom error message --}}
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error: </strong>{{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {{-- alert message through valitador class --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- form start -->
                            <form action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="brand_id">Brand Id</label>
                                        <input class="form-control" type="text" name="brand_id"
                                            value="{{ old('brand_id') }}" id="brand_id"
                                            placeholder="Brand Id">
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_name">Brand Name*</label>
                                        <input class="form-control" type="text" name="brand_name"
                                            value="{{ old('brand_name') }}" id="brand_name"
                                            placeholder="Brand Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            placeholder="Image" />
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_logo">Brand Logo</label>
                                        <input type="file" name="brand_logo" id="brand_logo" class="form-control"
                                            placeholder="Brand Logo" />
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_discount">Brand Discount(%)</label>
                                        <input class="form-control" type="number" name="brand_discount"
                                            value="{{ old('brand_discount') }}" id="brand_discount"
                                            placeholder="Brand discount">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                            placeholder="Description">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Url</label>
                                        <input class="form-control" type="text" name="url"
                                            value="{{ old('url') }}" id="url"
                                            placeholder="Url">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Title</label>
                                        <input name="meta_title" cols="30" rows="3" type="text"
                                            class="form-control" id="meta_title" value="{{ old('meta_title') }}"
                                            placeholder="Meta title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Keyword</label>
                                        <input type="text" name="meta_keyword" id="meta_keyword"
                                            value="{{ old('meta_keyword') }}" class="form-control"
                                            placeholder="Meta keyword" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Description</label>
                                        <input type="text" name="meta_description" id="meta_description"
                                            value="{{ old('meta_description') }}" class="form-control"
                                            placeholder="Meta Description" />
                                    </div>
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" name="website" id="website"
                                            value="{{ old('website') }}" class="form-control"
                                            placeholder="Website" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email"
                                            value="{{ old('email') }}" class="form-control"
                                            placeholder="Email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone"
                                            value="{{ old('phone') }}" class="form-control"
                                            placeholder="Phone" />
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" class="form-control" id="address" cols="30" rows="5"
                                            placeholder="Address">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

<!-- /.content-wrapper -->
