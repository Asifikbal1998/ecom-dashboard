@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Brand</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Brand</li>
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
                                <h3 class="card-title">Update Brand</h3>
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
                            <form action="{{ route('brand.edit', ['id' => $brands['id']]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="brand_id">Brand Id</label>
                                        <input class="form-control" type="text" name="brand_id"
                                            value="{{ $brands->brand_id }}" id="brand_id"
                                            placeholder="Brand Id">
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_name">Brand Name*</label>
                                        <input class="form-control" type="text" name="brand_name"
                                            value="{{ $brands->brand_name }}" id="brand_name"
                                            placeholder="Brand Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            placeholder="Image" />
                                    </div>
                                    @if ($brands['brand_image'] == null)
                                        <td></td>
                                    @endif
                                    @if (isset($brands['brand_image']))
                                        <td><a target="_blank"
                                                href="{{ url('catalogues/brand_images/image') }}/{{ $brands['brand_image'] }}"><img
                                                    class="rounded-circle" width="150px" height="150px"
                                                    src="{{ asset('catalogues/brand_images/image') }}/{{ $brands['brand_image'] }}">
                                            </a></td>
                                        {{-- delete     --}}
                                        <a href="javascript:void(0)" style="color: #fff; margin-left:20px;" class="nav-icon fas fa-trash confirmDelete"
                                            name="brand Image" title="Delete category Image" record="brand-image"
                                            recordid="{{ $brands['id'] }}"></a>
                                    @endif
                                    <div class="form-group">
                                        <label for="brand_logo">Brand Logo</label>
                                        <input type="file" name="brand_logo" id="brand_logo" class="form-control"
                                            placeholder="Brand Logo" />
                                    </div>
                                    @if ($brands['brand_logo'] == null)
                                        <td></td>
                                    @endif
                                    @if (isset($brands['brand_logo']))
                                        <td><a target="_blank"
                                                href="{{ url('catalogues/brand_images/logo') }}/{{ $brands['brand_logo'] }}"><img
                                                    class="rounded-circle" width="150px" height="150px"
                                                    src="{{ asset('catalogues/brand_images/logo') }}/{{ $brands['brand_logo'] }}">
                                            </a></td>
                                        {{-- delete     --}}
                                        <a href="javascript:void(0)" style="color: #fff; margin-left:20px;" class="nav-icon fas fa-trash confirmDelete"
                                            name="brand logo" title="Delete brand logo" record="brand-logo"
                                            recordid="{{ $brands['id'] }}"></a>
                                    @endif
                                    <div class="form-group">
                                        <label for="brand_discount">Brand Discount(%)</label>
                                        <input class="form-control" type="number" name="brand_discount"
                                            value="{{ $brands->brand_discount }}" id="brand_discount"
                                            placeholder="Brand discount">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                            placeholder="Description">{{ $brands->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Url</label>
                                        <input class="form-control" type="text" name="url"
                                            value="{{ $brands->url }}" id="url"
                                            placeholder="Url">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Title</label>
                                        <input name="meta_title" cols="30" rows="3" type="text"
                                            class="form-control" id="meta_title" value="{{ $brands->meta_title }}"
                                            placeholder="Meta title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Keyword</label>
                                        <input type="text" name="meta_keyword" id="meta_keyword"
                                            value="{{ $brands->meta_keywords }}" class="form-control"
                                            placeholder="Meta keyword" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Description</label>
                                        <input type="text" name="meta_description" id="meta_description"
                                            value="{{ $brands->meta_description }}" class="form-control"
                                            placeholder="Meta Description" />
                                    </div>
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" name="website" id="website"
                                            value="{{ $brands->website }}" class="form-control"
                                            placeholder="Website" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email"
                                            value="{{ $brands->email }}" class="form-control"
                                            placeholder="Email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone"
                                            value="{{ $brands->phone }}" class="form-control"
                                            placeholder="Phone" />
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" class="form-control" id="address" cols="30" rows="5"
                                            placeholder="Address">{{ $brands->address }}</textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
