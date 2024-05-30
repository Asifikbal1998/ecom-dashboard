@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cms Page</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Cms Pages</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Pages</h3>
                @if ($pageModule['edit_access'] == 1 || $pageModule['full_access'] == 1)
                    <a href=" {{ route('cmsPage.create') }} " class="btn btn-primary" style="float: right;">Add New
                        Pages</a>
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
                <table id="cms-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Cms Pages</th>
                            <th>Page URL</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cmsPages as $cmsPage)
                            <tr>
                                <td>{{ $cmsPage->id }}</td>
                                <td>{{ $cmsPage->title }}</td>
                                <td>{{ $cmsPage->url }}</td>
                                <td>{{ $cmsPage->created_at->format('F j, Y, g:i a') }}</td>
                                <td>
                                    {{-- ststus update --}}
                                    @if ($pageModule['edit_access'] == 1 || $pageModule['full_access'] == 1)
                                        @if ($cmsPage->ststus == 1)
                                            <a class="updateCmsPageStatus" id="page-{{ $cmsPage->id }}"
                                                page_id="{{ $cmsPage->id }}" href="javascript:void(0)"><i
                                                    style='color: #3f6ed3;' class="fas fa-toggle-on"
                                                    status="Active"></i></a>
                                        @else
                                            <a class="updateCmsPageStatus" id="page-{{ $cmsPage->id }}"
                                                page_id="{{ $cmsPage->id }}" style="color: gray;"
                                                href="javascript:void(0)"><i class="fas fa-toggle-off"
                                                    status="Inactive"></i></a>
                                        @endif &nbsp;&nbsp;
                                    @endif
                                    {{-- ststus update end --}}


                                    {{-- edit --}}
                                    @if ($pageModule['edit_access'] == 1 || $pageModule['full_access'] == 1)
                                        <a href="{{ route('cmsPage.show', ['id' => $cmsPage->id]) }}"
                                            class="nav-icon fas fa-edit"></a>&nbsp;&nbsp;
                                    @endif

                                    {{-- delete     --}}
                                    @if ($pageModule['full_access'] == 1)
                                        <a href="javascript:void(0)" class="nav-icon fas fa-trash confirmDelete"
                                            name="Cms Page" title="Delete Cms Page" record="cms-page"
                                            recordid="{{ $cmsPage->id }}"></a>
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
