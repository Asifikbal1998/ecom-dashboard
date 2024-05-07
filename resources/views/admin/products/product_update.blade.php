@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Seeting</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Product</li>
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
                                <h3 class="card-title">Update Product</h3>
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
                            <form action="{{ route('product.edit', ['id' => $product->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="category_name">Select Category</label>
                                        <select name="category_id" class="form-control">
                                            <option value="0" @if ($product['category_id'] == 0) selected @endif>Main
                                                Category</option>
                                            {{-- get categories --}}
                                            @foreach ($getCategories as $cat)
                                                <option @if (isset($product['category_id']) && $product['category_id'] == $cat['id']) selected @endif
                                                    value="{{ $cat['id'] }}">{{ $cat['categori_name'] }}</option>
                                                {{-- get subcategories --}}
                                                @if (!empty($cat['sub_categories']))
                                                    @foreach ($cat['sub_categories'] as $subcat)
                                                        <option @if (isset($product['category_id']) && $product['category_id'] == $subcat['id']) selected @endif
                                                            value="{{ $subcat['id'] }}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo;{{ $subcat['categori_name'] }}
                                                        </option>
                                                        {{-- get subsubcategories --}}
                                                        @if (!empty($subcat['sub_categories']))
                                                            @foreach ($subcat['sub_categories'] as $subsubcat)
                                                                <option @if (isset($product['category_id']) && $product['category_id'] == $subsubcat['id']) selected @endif
                                                                    value="{{ $subsubcat['id'] }}">
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo;{{ $subsubcat['categori_name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input class="form-control" type="text" name="product_name"
                                            value="{{ $product->product_name }}" id="product_name"
                                            placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">Product Code</label>
                                        <input class="form-control" type="text" name="product_code"
                                            value="{{ $product->product_code }}" id="product_code"
                                            placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_color">Product Color</label>
                                        <input class="form-control" type="text" name="product_color"
                                            value="{{ $product->product_color }}" id="product_color"
                                            placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="family_color">Family Color</label>
                                        <select name="family_color" id="family_color" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($familyColors as $familyColor)
                                                <option @if ($product->family_color == $familyColor->color_name) selected @endif
                                                    value="{{ $familyColor->color_name }}">
                                                    {{ $familyColor->color_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="group_code">Group Code</label>
                                        <input class="form-control" type="text" name="group_code"
                                            value="{{ $product->group_code }}" id="group_code" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Product Price</label>
                                        <input class="form-control" type="number" name="product_price"
                                            value="{{ $product->product_price }}" id="product_price"
                                            placeholder="Product Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Product Discount(%)</label>
                                        <input class="form-control" type="number" name="product_discount"
                                            value="{{ $product->product_discount }}" id="product_discount"
                                            placeholder="Product Discount">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input class="form-control" type="number" name="product_weight"
                                            value="{{ $product->product_weight }}" id="product_weight"
                                            placeholder="Product Weight">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_video">Product Video</label>
                                        <input class="form-control" type="file" name="product_video"
                                            id="product_video" accept="video/" placeholder="Product Video">
                                    </div>

                                    {{-- show product video if product video is exist --}}
                                    @if ($product['product_video'] == null)
                                        <td></td>
                                    @endif
                                    @if (isset($product['product_video']))
                                        <td><a href="{{ url('catalogues/product_video') }}/{{ $product['product_video'] }}"
                                                target="_blank">
                                                <video width="150" height="110" controls>
                                                    <source
                                                        src="{{ asset('catalogues/product_video') }}/{{ $product['product_video'] }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a></td>
                                        {{-- delete product video    --}}
                                        <a href="javascript:void(0)" style="color: #fff; margin-left:20px;"
                                            class="nav-icon fas fa-trash confirmDelete" name="product video"
                                            title="Delete product video" record="product-video"
                                            recordid="{{ $product['id'] }}"></a>
                                    @endif

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                            placeholder="Description">{{ $product->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="wash_care">Wash Care</label>
                                        <textarea name="wash_care" class="form-control" id="wash_care" cols="30" rows="3"
                                            placeholder="Wash Care">{{ $product->wash_care }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="keywords">Search Keywords</label>
                                        <textarea name="search_keywords" class="form-control" id="search_keywords" cols="30" rows="3"
                                            placeholder="Search Keywords">{{ $product->search_keywords }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="fabric">Fabric</label>
                                        <select name="fabric" id="fabric" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['fabricArray'] as $fabric)
                                                <option @if ($product->fabric == $fabric) selected @endif value="{{ $fabric }}">{{ $fabric }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fit">Fit</label>
                                        <select name="fit" id="fit" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['fitArray'] as $fit)
                                                <option @if ($product->fit == $fit) selected @endif value="{{ $fit }}">{{ $fit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="occasion">Occasion</label>
                                        <select name="occasion" id="occasion" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['occasionArray'] as $occasion)
                                                <option @if ($product->occassion == $occasion) selected @endif value="{{ $occasion }}">{{ $occasion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sleeve">Sleeve</label>
                                        <select name="sleeve" id="sleeve" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['sleeveArray'] as $sleeve)
                                                <option @if ($product->sleeve == $sleeve) selected @endif value="{{ $sleeve }}">{{ $sleeve }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pattern">Pattern</label>
                                        <select name="pattern" id="pattern" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['patternArray'] as $pattern)
                                                <option @if ($product->pattern == $pattern) selected @endif value="{{ $pattern }}">{{ $pattern }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Title</label>
                                        <input name="meta_title" cols="30" rows="3" type="text"
                                            class="form-control" id="meta_title" value="{{ $product->meta_title }}"
                                            placeholder="Meta title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Description</label>
                                        <input type="text" name="meta_description" id="meta_description"
                                            value="{{ $product->meta_description }}" class="form-control"
                                            placeholder="Meta Description" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Keyword</label>
                                        <input type="text" name="meta_keyword" id="meta_keyword"
                                            value="{{ $product->meta_keyword }}" class="form-control"
                                            placeholder="Meta keyword" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Is Featured</label>
                                        <select name="is_featured" class="form-control" name="" id="">
                                            <option @if ($product->is_featured == 'yes') selected @endif value=1>Yes
                                            </option>
                                            <option @if ($product->is_featured == 'no') selected @endif value=0>No
                                            </option>
                                        </select>
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
