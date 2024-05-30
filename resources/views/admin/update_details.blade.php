@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Admin Details</li>
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
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Admin Details</h3>
                            </div>
                            <!-- /.card-header -->
                            {{-- show custom error message --}}
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="admin_email">Email address</label>
                                        <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}"
                                            id="admin_email" readonly style="background-color: #666">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Name" value="{{ Auth::guard('admin')->user()->name }}" readonly
                                            style="background-color: #666">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile No</label>
                                        <input name="mobile" type="text" class="form-control" id="mobile"
                                            placeholder="Mobile No" value="{{ Auth::guard('admin')->user()->mobile }}"
                                            readonly style="background-color: #666">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>

                    {{-- right column --}}
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Admin Details</h3>
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
                            <form action="{{ route('update.details') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="admin_email">Email address</label>
                                        <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}"
                                            id="admin_email" readonly style="background-color: #666">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Name" value="{{ Auth::guard('admin')->user()->name }}">
                                        <span id="is_validate"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile No</label>
                                        <input name="mobile" type="text" class="form-control" id="mobile"
                                            placeholder="Mobile No" value="{{ Auth::guard('admin')->user()->mobile }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input name="image" type="file" class="form-control" id="image">
                                    </div>
                                    @if (isset(Auth::guard('admin')->user()->image))
                                        <td><a target="_blank"
                                                href="{{ url('subadmin') }}/{{ Auth::guard('admin')->user()->image }}"><img
                                                    class="rounded-circle" width="150px" height="150px"
                                                    src="{{ asset('subadmin') }}/{{ Auth::guard('admin')->user()->image }}">
                                            </a></td>
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
