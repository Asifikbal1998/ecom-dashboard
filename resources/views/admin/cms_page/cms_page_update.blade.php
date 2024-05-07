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
                            <li class="breadcrumb-item active">Updates Cms Pages</li>
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
                                <h3 class="card-title">Updates Cms Pages</h3>
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
                            <form action="{{ route('cmsPage.edit', ['id' => $cmsPage->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="page_title">Page Title</label>
                                        <input class="form-control" name="page_title" value="{{ $cmsPage->title }}"
                                            id="page_title" placeholder="Page Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                            placeholder="Description">{{ $cmsPage->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Page Url</label>
                                        <input name="page_url" type="text" value="{{ $cmsPage->url }}"
                                            class="form-control" id="page_url" placeholder="Page Url">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Title</label>
                                        <input name="meta_title" type="text" value="{{ $cmsPage->meta_title }}"
                                            class="form-control" id="meta_title" placeholder="Meta Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta Description</label>
                                        <textarea name="meta_description" cols="30" rows="3" type="text" class="form-control"
                                            id="meta_description" placeholder="Meta Description">{{ $cmsPage->meta_description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Meta KeyWords</label>
                                        <input name="meta_keywords" type="text" class="form-control"
                                            value={{ $cmsPage->mata_keywords }} id="meta_keywords"
                                            placeholder="Meta Keywords">
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
