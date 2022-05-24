@extends('adminpanel.layouts.app')
@push('pagecss')
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="/admin/plugins/ekko-lightbox/ekko-lightbox.css">
<style>
.pad-lft-0 {padding: 3px 0 3px 0px;}
.pad-lft {padding: 5px 0 5px 20px;}
.category-list {max-height: 250px;overflow-y: scroll;}
.mar-0 {margin: 0;}
#option-list .btn-info, #option-list .btn-danger {color: #fff!important;}
#option-list .opt-val {float: left;width: 40%;}
#option-list .fa-add-but {float: left;margin-left: 10px;}
#option-list hr {margin-top: 20px;margin-bottom: 20px;border: 0;border-top: 2px solid #666;}
.hight-40 {height: 40px;}
.otherphotos img{width:60px; float: left; margin-bottom:10px; margin-right:10px;}
.otherphotos .fa-delete-but{margin: 10px;}
.otherphotos .btn-info {color: #fff!important;}
a.btn-danger{color: #fff!important;}
.qty {width: 60px;}
</style>
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Orders</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Add Order</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<form role="form" action="/admin/orders/store" method="post" name="order" id="order">
<div class="content">
  <div class="container-fluid">
    <div class="row">
      @include('adminpanel.blocks.message')
      @include('adminpanel.orders.add-order-form')
    </div>
  </div>
</div>
{{csrf_field()}}
</form>
@endsection
