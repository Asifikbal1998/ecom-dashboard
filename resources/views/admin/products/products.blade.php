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
                            <li class="breadcrumb-item active">New Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Product</h3>
                @if ($productModule['edit_access'] == 1 || $productModule['full_access'] == 1)
                    <a href=" {{ route('product.create') }} " class="btn btn-primary" style="float: right;">Add New
                        Product</a>
                @endif
            </div>
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
            <!-- /.card-header -->
            <div class="card-body">
                <table id="product" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Product Color</th>
                            <th>Category</th>
                            <th>Parent Category</th>
                            {{-- <th>Product Price</th>
                            <th>Product Discount</th>
                            <th>Sale Price</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->product_color }}</td>
                                <td>
                                    @if (isset($product->category->categori_name))
                                        {{ $product->category->categori_name }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($product->category->parentcategory->categori_name))
                                        {{ $product->category->parentcategory->categori_name }}
                                    @endif
                                </td>
                                <td>
                                    {{-- ststus update --}}
                                    @if ($productModule['edit_access'] == 1 || $productModule['full_access'] == 1)
                                        @if ($product->status == 1)
                                            <a class="updateProductStatus" id="page-{{ $product->id }}"
                                                page_id="{{ $product->id }}" href="javascript:void(0)"><i
                                                    style='color: #3f6ed3;' class="fas fa-toggle-on"
                                                    status="Active"></i></a>
                                        @else
                                            <a class="updateProductStatus" id="page-{{ $product->id }}"
                                                page_id="{{ $product->id }}" style="color: gray;"
                                                href="javascript:void(0)"><i class="fas fa-toggle-off"
                                                    status="Inactive"></i></a>
                                        @endif &nbsp;&nbsp;
                                    @endif
                                    {{-- ststus update end --}}

                                    {{-- edit --}}
                                    @if ($productModule['edit_access'] == 1 || $productModule['full_access'] == 1)
                                        <a href="{{ route('product.show', ['id' => $product->id]) }}"
                                            class="nav-icon fas fa-edit"></a>&nbsp;&nbsp;
                                    @endif

                                    {{-- delete     --}}
                                    @if ($productModule['full_access'] == 1)
                                        <a href="javascript:void(0)" class="nav-icon fas fa-trash confirmDelete"
                                            name="product Page" title="Delete product" record="product"
                                            recordid="{{ $product->id }}"></a>&nbsp;
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.content -->
    </div>
@endsection

<!-- /.content-wrapper -->
