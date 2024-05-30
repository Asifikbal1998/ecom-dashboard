@extends('admin.layout.layout')
<!-- Content Wrapper. Contains page content -->
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Subadmin</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update Subadmin</li>
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
                                <h3 class="card-title">Update Subadmin</h3>
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
                            <form action="{{ route('subadmin.edit', ['id' => $subadmin->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="mobile">Email</label>
                                        <input name="email" type="text" value="{{ $subadmin->email }}"
                                            class="form-control" id="email" placeholder="Email" readonly
                                            style="background-color: #666">
                                    </div>
                                    <div class="form-group">
                                        <label for="page_title">Name</label>
                                        <input class="form-control" name="name" value="{{ $subadmin->name }}"
                                            id="name" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input name="mobile" type="text" value="{{ $subadmin->mobile }}"
                                            class="form-control" id="mobile" placeholder="Mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Password</label>
                                        <input name="password" cols="30" rows="3" type="password"
                                            value="{{ $subadmin->password }}" class="form-control" id="password"
                                            placeholder="password" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">image</label>
                                        <input name="image" type="file" class="form-control" id="image"
                                            placeholder="image">
                                    </div>
                                    @if (isset($subadmin->image))
                                        <td><a target="_blank" href="{{ url('subadmin') }}/{{ $subadmin->image }}"><img
                                                    class="rounded-circle" width="150px" height="150px"
                                                    src="{{ asset('subadmin') }}/{{ $subadmin->image }}">
                                            </a></td>
                                        {{-- delete     --}}
                                        <a href="javascript:void(0)" style="color: #fff; margin-left:20px;"
                                            class="nav-icon fas fa-trash confirmDelete" name="subadmin Image"
                                            title="Delete category Image" record="subadmin-image"
                                            recordid="{{ $subadmin['id'] }}"></a>
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
