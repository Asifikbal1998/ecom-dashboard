@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Banners</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Banners</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Banners</h3>
                @if ($bannersModule['edit_access'] == 1 || $bannersModule['full_access'] == 1)
                    <a href="{{ route('banner.create') }}" class="btn btn-primary" style="float: right;">Add New
                        Banner</a>
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
                            <th>image</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                @if ($banner->image == null)
                                    <td></td>
                                @endif
                                @if (isset($banner->image))
                                    <td>
                                        <a target="_blank" href="{{ url('catalogues/banner_image') }}/{{ $banner->image }}">
                                            <img width="150px" height="150px"
                                                src="{{ asset('catalogues/banner_image') }}/{{ $banner->image }}"
                                                alt="image" srcset="">
                                        </a>
                                        {{-- delete  image --}}
                                        @if ($bannersModule['full_access'] == 1)
                                            <a href="javascript:void(0)" style="color: #fff; margin-left:20px;"
                                                class="nav-icon fas fa-trash confirmDelete" name="banner Image"
                                                title="Delete banner Image" record="banner-image"
                                                recordid="{{ $banner['id'] }}"></a>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $banner->type }}</td>
                                <td>
                                    {{-- ststus update --}}
                                    @if ($bannersModule['edit_access'] == 1 || $bannersModule['full_access'] == 1)
                                        @if ($banner->status == 1)
                                            <a class="updateBannerStatus" id="page-{{ $banner->id }}"
                                                page_id="{{ $banner->id }}" href="javascript:void(0)"><i
                                                    style='color: #3f6ed3;' class="fas fa-toggle-on"
                                                    status="Active"></i></a>
                                        @else
                                            <a class="updateBannerStatus" id="page-{{ $banner->id }}"
                                                page_id="{{ $banner->id }}" style="color: gray;"
                                                href="javascript:void(0)"><i class="fas fa-toggle-off"
                                                    status="Inactive"></i></a>
                                        @endif &nbsp;&nbsp;
                                    @endif
                                    {{-- ststus update end --}}

                                    {{-- edit --}}
                                    @if ($bannersModule['edit_access'] == 1 || $bannersModule['full_access'] == 1)
                                        <a href="{{ route('banner.show', ['id' => $banner->id]) }}"
                                            class="nav-icon fas fa-edit"></a>&nbsp;&nbsp;
                                    @endif

                                    {{-- delete     --}}
                                    @if ($bannersModule['full_access'] == 1)
                                        <a href="javascript:void(0)" class="nav-icon fas fa-trash confirmDelete"
                                            name="banner Page" title="Delete banner" record="banner"
                                            recordid="{{ $banner->id }}"></a>&nbsp;
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
