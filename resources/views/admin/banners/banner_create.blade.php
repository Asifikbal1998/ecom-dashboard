@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Banner</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create New Banner</li>
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
                            <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            placeholder="Image" />
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type*</label>
                                        <select class="form-control" name="type" id="type">
                                            <option>Select</option>
                                            <option value="Slider">Slider</option>
                                            <option value="Fix 1">Fix 1</option>
                                            <option value="Fix 2">Fix 2</option>
                                            <option value="Fix 3">Fix 2</option>
                                            <option value="Fix 4">Fix 2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Banner Link</label>
                                        <input class="form-control" type="text" name="link"
                                            value="{{ old('link') }}" id="link"
                                            placeholder="Link">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Banner Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ old('title') }}" id="title"
                                            placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="alt">Banner Alt</label>
                                        <input class="form-control" type="text" name="alt"
                                            value="{{ old('alt') }}" id="alt"
                                            placeholder="Alt">
                                    </div>
                                    <div class="form-group">
                                        <label for="sort">Banner Sort</label>
                                        <input class="form-control" type="number" name="sort"
                                            value="{{ old('sort') }}" id="sort"
                                            placeholder="Sort">
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
