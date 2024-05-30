@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Banner</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update Banner</li>
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
                                <h3 class="card-title">Update Banner</h3>
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
                            <form action="{{ route('banner.edit', ['id' => $banners->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image">Banner Image</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            placeholder="Image" />
                                    </div>
                                    @if ($banners->image == null)
                                        <td></td>
                                    @endif
                                    @if (isset($banners->image))
                                        <td>
                                            <a target="_blank"
                                                href="{{ url('catalogues/banner_image') }}/{{ $banners->image }}">
                                                <img width="150px" height="150px"
                                                    src="{{ asset('catalogues/banner_image') }}/{{ $banners->image }}"
                                                    alt="image" srcset="">
                                            </a>
                                            {{-- delete  image --}}
                                            <a href="javascript:void(0)" style="color: #fff; margin-left:20px;"
                                                class="nav-icon fas fa-trash confirmDelete" name="banner Image"
                                                title="Delete banner Image" record="banner-image"
                                                recordid="{{ $banners['id'] }}"></a>
                                        </td>
                                    @endif
                                    <div class="form-group mt-3">
                                        <label for="type">Banner Type*</label>
                                        <select class="form-control" name="type" id="type">
                                            <option>Select</option>
                                            <option value="slider" @if($banners->type == 'Slider') selected  @endif>Slider</option>
                                            <option value="Fix 1" @if($banners->type == 'Fix 1') selected  @endif>Fix 1</option>
                                            <option value="Fix 2" @if($banners->type == 'Fix 2') selected  @endif>Fix 2</option>
                                            <option value="Fix 3" @if($banners->type == 'Fix 3') selected  @endif>Fix 3</option>
                                            <option value="Fix 4" @if($banners->type == 'Fix 4') selected  @endif>Fix 4</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Banner Link</label>
                                        <input class="form-control" type="text" name="link"
                                            value="{{ $banners->link }}" id="link" placeholder="Link">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Banner Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ $banners->title }}" id="title" placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="alt">Banner Alt</label>
                                        <input class="form-control" type="text" name="alt"
                                            value="{{ $banners->alt }}" id="alt" placeholder="Alt">
                                    </div>
                                    <div class="form-group">
                                        <label for="sort">Banner Sort</label>
                                        <input class="form-control" type="number" name="sort"
                                            value="{{ $banners->sort }}" id="sort" placeholder="Sort">
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
