@extends('adminpanel.layouts.app')
@push('pagecss')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
.pad-lft-0 {padding: 3px 0 3px 0px;}
.pad-lft {padding: 5px 0 5px 20px;}
.category-list {max-height: 250px;overflow-y: scroll;}
.mar-0 {margin: 0;}
.purchase .btn-info, .purchase .btn-danger {color: #fff!important;}
.purchase .opt-val {float: left;width: 40%;}
.purchase .fa-add-but {float: left;margin-left: 10px;}
.purchase hr {margin-top: 20px;margin-bottom: 20px;border: 0;border-top: 2px solid #666;}
.purchase .action-control {display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;}

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
        <h1 class="m-0 text-dark">Purchase Order</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Add Purchase Order</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<form role="form" action="/admin/purchase/purchase-order" method="post" name="product" id="product" enctype="multipart/form-data">
  <?php /*if(!empty($product) and $isCopy!="true") {?>
    <input type="hidden" name="prodid" id="prodid" value="<?php echo $product->id;?>">
  <?php }*/?>
<div class="content purchase">
  <div class="container-fluid">
    <div class="row">
      @include('adminpanel.blocks.message')
      @include('adminpanel.purchase.add-purchase-form')
    </div>
  </div>
</div>
</form>
@endsection
