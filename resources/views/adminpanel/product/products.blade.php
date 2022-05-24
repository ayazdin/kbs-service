@extends('adminpanel.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Products</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Product list</li>
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
      @include('adminpanel.product.product-list')
    </div>
  </div>
</div>
@endsection

@push('pagejs')
  <script>
    $(function () {
      $('#add-inventory').on('show.bs.modal', function (e) {

        var data = { 'prodid':  $(e.relatedTarget).attr('data-prodid'), _token: '{{csrf_token()}}'};
        //console.log(data);return;
        $.post( "/admin/product/get-purchase-order", data)
            .done(function( html ) {
                $("#_prodList").html(html);
                //console.log( "Field Updated: " + data );
            });
        //$("#_prodList").html('<h1>Add your purchase order here!!!</h1>')
      });
    });
  </script>
@endpush
