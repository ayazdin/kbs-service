@extends('adminpanel.layouts.app')

@section('content')
@push('cssfile')
<link rel="stylesheet" href="/admin/plugins/sweetalert2/sweetalert2.min.css">
<style>
.card-body h3 {float: left;font-size: 1.1rem;font-weight: 400;margin: 0;padding: .75rem 1.25rem;}
</style>
@endpush
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Purchase</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Purchase list</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      @include('adminpanel.blocks.message')
      @include('adminpanel.purchase.purchase-list')
      <?php /*include('adminpanel.purchase.purchase-detail')*/?>
    </div>
  </div>
</div>
@endsection
