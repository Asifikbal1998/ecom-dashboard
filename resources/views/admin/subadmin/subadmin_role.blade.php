@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Subadmin Role</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Subadmin Role</li>
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
                        <div class="card">
                            <div class="card-header">
                                @foreach ($name as $nam)
                                    @php $nam @endphp
                                @endforeach
                                <h3 class="card-title">Subadmin Name: {{ $nam }}</h3>
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
                            <form action="{{ route('subadminpermision.give', $id) }}" method="post">
                                @csrf
                                <input type="hidden" name="subadmin_id" value="{{ $id }}">
                                @if (!empty($data))
                                    @foreach ($data as $dat)
                                        @if ($dat['module'] == 'cms_pages')
                                            @if ($dat['view_access'] == 1)
                                                @php $viewCMSpPage = "checked" @endphp
                                            @else
                                                @php $viewCMSpPage = "" @endphp
                                            @endif
                                            @if ($dat['edit_access'] == 1)
                                                @php $editCMSpPage = "checked" @endphp
                                            @else
                                                @php $editCMSpPage = "" @endphp
                                            @endif
                                            @if ($dat['full_access'] == 1)
                                                @php $fullCMSpPage = "checked" @endphp
                                            @else
                                                @php $fullCMSpPage = "" @endphp
                                            @endif
                                        @endif

                                        @if ($dat['module'] == 'categories')
                                            @if ($dat['view_access'] == 1)
                                                @php $viewCategories = "checked" @endphp
                                            @else
                                                @php $viewCategories = "" @endphp
                                            @endif
                                            @if ($dat['edit_access'] == 1)
                                                @php $editCategories = "checked" @endphp
                                            @else
                                                @php $editCategories = "" @endphp
                                            @endif
                                            @if ($dat['full_access'] == 1)
                                                @php $fullCategories = "checked" @endphp
                                            @else
                                                @php $fullCategories = "" @endphp
                                            @endif
                                        @endif

                                        @if ($dat['module'] == 'product')
                                            @if ($dat['view_access'] == 1)
                                                @php $viewProduct = "checked" @endphp
                                            @else
                                                @php $viewProduct = "" @endphp
                                            @endif
                                            @if ($dat['edit_access'] == 1)
                                                @php $editProduct = "checked" @endphp
                                            @else
                                                @php $editProduct = "" @endphp
                                            @endif
                                            @if ($dat['full_access'] == 1)
                                                @php $fullProduct = "checked" @endphp
                                            @else
                                                @php $fullProduct = "" @endphp
                                            @endif
                                        @endif

                                        @if ($dat['module'] == 'brands')
                                            @if ($dat['view_access'] == 1)
                                                @php $viewBrand = "checked" @endphp
                                            @else
                                                @php $viewBrand = "" @endphp
                                            @endif
                                            @if ($dat['edit_access'] == 1)
                                                @php $editBrand = "checked" @endphp
                                            @else
                                                @php $editBrand = "" @endphp
                                            @endif
                                            @if ($dat['full_access'] == 1)
                                                @php $fullBrand = "checked" @endphp
                                            @else
                                                @php $fullBrand = "" @endphp
                                            @endif
                                        @endif

                                        @if ($dat['module'] == 'banners')
                                            @if ($dat['view_access'] == 1)
                                                @php $viewBanner = "checked" @endphp
                                            @else
                                                @php $viewBanner = "" @endphp
                                            @endif
                                            @if ($dat['edit_access'] == 1)
                                                @php $editBanner = "checked" @endphp
                                            @else
                                                @php $editBanner = "" @endphp
                                            @endif
                                            @if ($dat['full_access'] == 1)
                                                @php $fullBanner = "checked" @endphp
                                            @else
                                                @php $fullBanner = "" @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="cms_pages">CMS Pages:</label>&nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" name="cms_pages[view]" value="1"
                                            @if (isset($viewCMSpPage)) {{ $viewCMSpPage }} @endif>&nbsp;View
                                        Access&nbsp;
                                        &nbsp;
                                        <input type="checkbox" name="cms_pages[edit]" value="1"
                                            @if (isset($editCMSpPage)) {{ $editCMSpPage }} @endif>&nbsp;View/Edit
                                        Access&nbsp; &nbsp;
                                        <input type="checkbox" name="cms_pages[full]" value="1"
                                            @if (isset($fullCMSpPage)) {{ $fullCMSpPage }} @endif>&nbsp;Full
                                        Access&nbsp;
                                        &nbsp;
                                    </div>

                                    <div class="form-group">
                                        <label for="categories">Categories:</label>&nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" name="categories[view]" value="1"
                                            @if (isset($viewCategories)) {{ $viewCategories }} @endif>&nbsp;View
                                        Access&nbsp;
                                        &nbsp;
                                        <input type="checkbox" name="categories[edit]" value="1"
                                            @if (isset($editCategories)) {{ $editCategories }} @endif>&nbsp;View/Edit
                                        Access&nbsp; &nbsp;
                                        <input type="checkbox" name="categories[full]" value="1"
                                            @if (isset($fullCategories)) {{ $fullCategories }} @endif>&nbsp;Full
                                        Access&nbsp;
                                        &nbsp;
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Product:</label>&nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" name="product[view]" value="1"
                                            @if (isset($viewProduct)) {{ $viewProduct }} @endif>&nbsp;View
                                        Access&nbsp;
                                        &nbsp;
                                        <input type="checkbox" name="product[edit]" value="1"
                                            @if (isset($editProduct)) {{ $editProduct }} @endif>&nbsp;View/Edit
                                        Access&nbsp; &nbsp;
                                        <input type="checkbox" name="product[full]" value="1"
                                            @if (isset($fullProduct)) {{ $fullProduct }} @endif>&nbsp;Full
                                        Access&nbsp;
                                        &nbsp;
                                    </div>

                                    <div class="form-group">
                                        <label for="brand">Brand:</label>&nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" name="brands[view]" value="1"
                                            @if (isset($viewBrand)) {{ $viewBrand }} @endif>&nbsp;View
                                        Access&nbsp;
                                        &nbsp;
                                        <input type="checkbox" name="brands[edit]" value="1"
                                            @if (isset($editBrand)) {{ $editBrand }} @endif>&nbsp;View/Edit
                                        Access&nbsp; &nbsp;
                                        <input type="checkbox" name="brands[full]" value="1"
                                            @if (isset($fullBrand)) {{ $fullBrand }} @endif>&nbsp;Full
                                        Access&nbsp;
                                        &nbsp;
                                    </div>

                                    <div class="form-group">
                                        <label for="banners">Banners:</label>&nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" name="banners[view]" value="1"
                                            @if (isset($viewBanner)) {{ $viewBanner }} @endif>&nbsp;View
                                        Access&nbsp;
                                        &nbsp;
                                        <input type="checkbox" name="banners[edit]" value="1"
                                            @if (isset($editBanner)) {{ $editBanner }} @endif>&nbsp;View/Edit
                                        Access&nbsp; &nbsp;
                                        <input type="checkbox" name="banners[full]" value="1"
                                            @if (isset($fullBanner)) {{ $fullBanner }} @endif>&nbsp;Full
                                        Access&nbsp;
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
