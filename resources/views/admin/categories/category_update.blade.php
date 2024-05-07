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
                            <li class="breadcrumb-item active">Update Category</li>
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
                                <h3 class="card-title">Update Category</h3>
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
                            <form action="{{ route('category.edit', ['id' => $categories['id']]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input class="form-control" type="text" name="category_name"
                                            value="{{ $categories['categori_name'] }}" id="category_name"
                                            placeholder="Category Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Category Lebel (Parent Category)</label>
                                        <select name="parent_id" class="form-control">
                                            <option value="0" @if ($categories['parent_id'] == 0) selected @endif>Main
                                                Category</option>
                                            {{-- get categories --}}
                                            @foreach ($getCategories as $cat)
                                                <option @if (isset($categories['parent_id']) && $categories['parent_id'] == $cat['id']) selected @endif
                                                    value="{{ $cat['id'] }}">{{ $cat['categori_name'] }}</option>
                                                {{-- get subcategories --}}
                                                @if (!empty($cat['sub_categories']))
                                                    @foreach ($cat['sub_categories'] as $subcat)
                                                        <option @if (isset($categories['parent_id']) && $categories['parent_id'] == $subcat['id']) selected @endif
                                                            value="{{ $subcat['id'] }}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&raquo;{{ $subcat['categori_name'] }}
                                                        </option>
                                                        {{-- get subsubcategories --}}
                                                        @if (!empty($subcat['sub_categories']))
                                                            @foreach ($subcat['sub_categories'] as $subsubcat)
                                                                <option @if (isset($categories['parent_id']) && $categories['parent_id'] == $subsubcat['id']) selected @endif
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
                                        <label for="category_name">Category Discount</label>
                                        <input class="form-control" type="text" name="category_discount"
                                            value="{{ $categories['categori_discount'] }}" id="category_discount"
                                            placeholder="Category discount">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                            placeholder="Description">{{ $categories['description'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Url</label>
                                        <input name="url" type="test" value="{{ $categories['url'] }}"
                                            class="form-control" id="url" placeholder="url">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Title</label>
                                        <input name="meta_title" cols="30" rows="3" type="text"
                                            class="form-control" value="{{ $categories['meta_title'] }}" id="meta_title"
                                            placeholder="Meta title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Description</label>
                                        <input type="text" name="meta_description" id="meta_description"
                                            value="{{ $categories['meta_description'] }}" class="form-control"
                                            placeholder="Meta Description" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Keyword</label>
                                        <input type="text" name="meta_keyword" id="meta_keyword"
                                            value="{{ $categories['meta_keywords'] }}" class="form-control"
                                            placeholder="Meta keyword" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Image</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            placeholder="Image" />
                                    </div>
                                    @if ($categories['categori_image'] == null)
                                        <td></td>
                                    @endif
                                    @if (isset($categories['categori_image']))
                                        <td><a target="_blank"
                                                href="{{ url('catalogues/category_image') }}/{{ $categories['categori_image'] }}"><img
                                                    class="rounded-circle" width="150px" height="150px"
                                                    src="{{ asset('catalogues/category_image') }}/{{ $categories['categori_image'] }}">
                                            </a></td>
                                        {{-- delete     --}}
                                        <a href="javascript:void(0)" style="color: #fff; margin-left:20px;" class="nav-icon fas fa-trash confirmDelete"
                                            name="category Image" title="Delete category Image" record="category-image"
                                            recordid="{{ $categories['id'] }}"></a>
                                    @endif
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
