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
                            <li class="breadcrumb-item active">Subadmin Role</li>
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
                        <div class="card">
                            <div class="card-header">
                                @foreach ($names as $name)
                                    @php $name = $name['name'] @endphp
                                @endforeach
                                <h3 class="card-title">Subadmin Name: {{ $name }}</h3>
                                <a href=" {{ route('subadminpermision.give', $id) }} " class="btn btn-primary"
                                    style="float: right;">Edit/Give Access</a>
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
                            @php
                                $view_access = '';
                                $edit_access = '';
                                $full_access = '';
                            @endphp
                            @if (!empty($data))
                                @foreach ($data as $dat)
                                    @if ($dat['view_access'] == 1)
                                        @php  $view_access="checked"  @endphp
                                    @else
                                        @php  $view_access=""  @endphp
                                    @endif

                                    @if ($dat['edit_access'] == 1)
                                        @php  $edit_access="checked"  @endphp
                                    @else
                                        @php  $edit_access=""  @endphp
                                    @endif

                                    @if ($dat['full_access'] == 1)
                                        @php  $full_access="checked"  @endphp
                                    @else
                                        @php  $full_access=""  @endphp
                                    @endif
                                @endforeach
                            @endif
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="cms_pages">CMS Pages:</label>&nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" name="cms_pages[view]" value="1" {{ $view_access }}
                                            onclick="return false" onkeydown="return false;">&nbsp;View Access&nbsp;
                                        &nbsp;
                                        <input type="checkbox" name="cms_pages[edit]" value="1" {{ $edit_access }}
                                            onclick="return false" onkeydown="return false;">&nbsp;View/Edit
                                        Access&nbsp; &nbsp;
                                        <input type="checkbox" name="cms_pages[full]" value="1" {{ $full_access }}
                                            onclick="return false" onkeydown="return false;">&nbsp;Full Access&nbsp;
                                        &nbsp;
                                    </div>
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
