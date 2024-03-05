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
                            <li class="breadcrumb-item active">Create new Subadmin</li>
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
                                <h3 class="card-title">Add New Subadmin</h3>
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
                            <form action="{{ route('subadmin.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="page_title">Name</label>
                                        <input class="form-control" name="name" value="{{ old('name') }}"
                                            id="name" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Type</label>
                                        <input name="type" class="form-control" id="type" cols="30"
                                            rows="5" value="{{ old('type') }}" placeholder="type" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input name="mobile" type="text" value="{{ old('mobile') }}"
                                            class="form-control" id="mobile" placeholder="Mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Email</label>
                                        <input name="email" type="text" value="{{ old('email') }}"
                                            class="form-control" id="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Password</label>
                                        <input name="password" cols="30" rows="3" type="text"
                                            class="form-control" id="password" placeholder="Password" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
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
