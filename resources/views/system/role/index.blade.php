@extends('system.layout')
@section('title', 'Role')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Roles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @can('add roles')
                                <div class="card-header">
                                    <a class="btn btn-primary" style="float: right" href="{{ route('roles.create') }}">Add
                                        Roles</a>
                                    @if (\Session::has('message'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                <li>{!! \Session::get('message') !!}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endcan

                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @if ($role->id != 1)
                                                        @can('edit roles')
                                                            <a class="btn btn-secondary"
                                                                href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                        @endcan
                                                        @can('delete roles')
                                                            <form action="{{ route('roles.destroy', $role->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        @endcan
                                                </td>
                                        @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
