@extends('layouts.adminLayout.admin_design')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Contact List</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="allusers-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Author</th>
                                    <th>Publish Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0 ?>
                                @foreach($posts as $post)
                                <?php $i++ ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><a href="{{ url('/blog/'.$post->url) }}">{{ $post->title }}</a></td>
                                    <td>{{ $post->category }}</td>
                                    <td>@if($post->status == 1) <label class="label label-sm label-success">Publish</label> @elseif($post->status == 0) <label class="label label-sm label-danger">Draft</label> @endif</td>
                                    <td>{{ $post->add_by }}</td>
                                    <td>{{ date('d M, Y h:i:s A', strtotime($post->created_at)) }}</td>
                                    <td>
                                        <div id="donate">
                                            <a href="/admin/blog/post/{{ $post->id }}/edit" class="label label-warning label-sm"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="/admin/blog/post/{{ $post->id }}/delete" class="label label-danger label-sm"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection