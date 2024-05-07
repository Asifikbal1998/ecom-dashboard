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
                            <li class="breadcrumb-item active">Update New Category</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Category</h3>
                @if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1)
                    <a href=" {{ route('category.create') }} " class="btn btn-primary" style="float: right;">Add New
                        Category</a>
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
                <table id="category" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category Name</th>
                            <th>Parent Category</th>
                            <th>URL</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->categori_name }}</td>
                                <td>
                                    @if (isset($category->parentcategory->categori_name))
                                        {{ $category->parentcategory->categori_name }}
                                    @endif
                                </td>
                                <td>{{ $category->url }}</td>
                                <td>{{ $category->created_at->format('F j, Y, g:i a') }}</td>
                                <td>
                                    {{-- ststus update --}}
                                    @if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1)
                                        @if ($category->status == 1)
                                            <a class="updateCategoryStatus" id="page-{{ $category->id }}"
                                                page_id="{{ $category->id }}" href="javascript:void(0)"><i
                                                    style='color: #3f6ed3;' class="fas fa-toggle-on"
                                                    status="Active"></i></a>
                                        @else
                                            <a class="updateCategoryStatus" id="page-{{ $category->id }}"
                                                page_id="{{ $category->id }}" style="color: gray;"
                                                href="javascript:void(0)"><i class="fas fa-toggle-off"
                                                    status="Inactive"></i></a>
                                        @endif &nbsp;&nbsp;
                                    @endif
                                    {{-- ststus update end --}}

                                    {{-- edit --}}
                                    @if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1)
                                        <a href="{{ route('category.show', ['id' => $category->id]) }}"
                                            class="nav-icon fas fa-edit"></a>&nbsp;&nbsp;
                                    @endif

                                    {{-- delete     --}}
                                    @if ($categoriesModule['full_access'] == 1)
                                        <a href="javascript:void(0)" class="nav-icon fas fa-trash confirmDelete"
                                            name="category Page" title="Delete category" record="category"
                                            recordid="{{ $category->id }}"></a>&nbsp;
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
