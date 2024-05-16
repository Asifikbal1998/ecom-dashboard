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
                            <li class="breadcrumb-item active">Create new Product</li>
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
                                <h3 class="card-title">Add New Product</h3>
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
                            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="category_level">Select Category*</label>
                                        <select name="category_id" class="form-control">
                                            <option value="0">Main Category</option>
                                            {{-- get categories --}}
                                            @foreach ($getCategories as $cat)
                                                <option @if (!empty(old('category_id')) && $cat['id'] == old('category_id')) selected @endif
                                                    value="{{ $cat['id'] }}">{{ $cat['categori_name'] }}</option>
                                                {{-- get subcategories --}}
                                                @if (!empty($cat['sub_categories']))
                                                    @foreach ($cat['sub_categories'] as $subcat)
                                                        <option @if (!empty(old('category_id')) && $subcat['id'] == old('category_id')) selected @endif
                                                            value="{{ $subcat['id'] }}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo;{{ $subcat['categori_name'] }}
                                                        </option>
                                                        {{-- get subsubcategories --}}
                                                        @if (!empty($subcat['sub_categories']))
                                                            @foreach ($subcat['sub_categories'] as $subsubcat)
                                                                <option @if (!empty(old('category_id')) && $subsubcat['id'] == old('category_id')) selected @endif
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
                                        <label for="product_name">Product Name*</label>
                                        <input class="form-control" type="text" name="product_name"
                                            value="{{ old('product_name') }}" id="product_name" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">Product Code*</label>
                                        <input class="form-control" type="text" name="product_code"
                                            value="{{ old('product_code') }}" id="product_code" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_color">Product Color*</label>
                                        <input class="form-control" type="text" name="product_color"
                                            value="{{ old('product_color') }}" id="product_color"
                                            placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="family_color">Family Color*</label>
                                        <select name="family_color" id="family_color" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($familyColors as $familyColor)
                                                <option @if (old('family_color') == $familyColor->color_name) selected @endif
                                                    value="{{ $familyColor->color_name }}">
                                                    {{ $familyColor->color_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="group_code">Group Code</label>
                                        <input class="form-control" type="text" name="group_code"
                                            value="{{ old('group_code') }}" id="group_code" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Product Price*</label>
                                        <input class="form-control" type="number" name="product_price"
                                            value="{{ old('product_price') }}" id="product_price"
                                            placeholder="Product Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Product Discount(%)</label>
                                        <input class="form-control" type="number" name="product_discount"
                                            value="{{ old('product_discount') }}" id="product_discount"
                                            placeholder="Product Discount(%)">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input class="form-control" type="number" name="product_weight"
                                            value="{{ old('product_weight') }}" id="product_weight"
                                            placeholder="Product Weight">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_image">Product Image</label>
                                        <input class="form-control" type="file" name="product_images[]"
                                            id="product_images" accept="image/*" multiple placeholder="Product Image">
                                    </div>
                                    <div class="form-group">
                                        <label>Product Attributes</label>
                                        <div class="field_wrapper">
                                            <div>
                                                <input type="text" value="{{ old('size[]') }}" name="size[]" id="size[]" placeholder="Size" style="width: 150px;"/>&nbsp;
                                                <input type="text" value="{{ old('sku[]') }}" name="sku[]" id="sku[]" placeholder="Sku" style="width: 150px;"/>&nbsp;
                                                <input type="number" value="{{ old('price[]') }}" name="price[]" id="price[]" placeholder="Price" style="width: 150px;"/>&nbsp;
                                                <input type="number" value="{{ old('stock[]') }}" name="stock[]" id="stock[]" placeholder="Stock" style="width: 150px;"/>
                                                <a href="javascript:void(0);" class="add_button" title="Add field"> Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_video">Product Video (Recomended size Less than 2mb)</label>
                                        <input class="form-control" type="file" name="product_video"
                                            value="{{ old('product_video') }}" id="product_video" accept="video/*"
                                            placeholder="Product Video">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                            placeholder="Description">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="wash_care">Wash Care</label>
                                        <textarea name="wash_care" class="form-control" id="wash_care" cols="30" rows="3"
                                            placeholder="Wash Care">{{ old('wash_care') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="search_keywords">Search Keywords</label>
                                        <textarea name="search_keywords" class="form-control" id="search_keywords" cols="30" rows="3"
                                            placeholder="Search Keywords">{{ old('search_keywords') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="fabric">Fabric</label>
                                        <select name="fabric" id="fabric" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['fabricArray'] as $fabric)
                                                <option @if (old('fabric') == $fabric) selected @endif
                                                    value="{{ $fabric }}">{{ $fabric }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fit">Fit</label>
                                        <select name="fit" id="fit" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['fitArray'] as $fit)
                                                <option @if (old('fit') == $fit) selected @endif
                                                    value="{{ $fit }}">{{ $fit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="occasion">Occasion</label>
                                        <select name="occasion" id="occasion" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['occasionArray'] as $occasion)
                                                <option @if (old('occasion') == $occasion) selected @endif
                                                    value="{{ $occasion }}">{{ $occasion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sleeve">Sleeve</label>
                                        <select name="sleeve" id="sleeve" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['sleeveArray'] as $sleeve)
                                                <option @if (old('sleeve') == $sleeve) selected @endif
                                                    value="{{ $sleeve }}">{{ $sleeve }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pattern">Pattern</label>
                                        <select name="pattern" id="pattern" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($productFilters['patternArray'] as $pattern)
                                                <option @if (old('pattern') == $pattern) selected @endif
                                                    value="{{ $pattern }}">{{ $pattern }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Title</label>
                                        <input name="meta_title" cols="30" rows="3" type="text"
                                            class="form-control" id="meta_title" value="{{ old('meta_title') }}"
                                            placeholder="Meta title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Description</label>
                                        <input type="text" name="meta_description" id="meta_description"
                                            value="{{ old('meta_description') }}" class="form-control"
                                            placeholder="Meta Description" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Keyword</label>
                                        <input type="text" name="meta_keyword" id="meta_keyword"
                                            value="{{ old('meta_keyword') }}" class="form-control"
                                            placeholder="Meta keyword" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Featured Item</label>
                                        <select name="is_featured" class="form-control" name="" id="">
                                            <option>Select</option>
                                            <option @if (old('is_featured') == 1) selected @endif value=1>Yes
                                            </option>
                                            <option @if (old('is_featured') == 0) selected @endif value=0>No
                                            </option>
                                        </select>
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
