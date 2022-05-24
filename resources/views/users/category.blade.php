<?php $page="products";?>
@extends('users.layouts.app')
@push('pagecss')
<!-- Owl Carousel -->
<link rel="stylesheet" href="/css/owl-carousel.css">
<style>
#sidebar {
    min-width: 250px;
    max-width: 250px;
    /* background: #7386D5; */
    color: #fff;
    transition: all 0.3s;
    margin-left: -30px;
}

#sidebar.active {
    margin-left: -250px;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #6d7fcc;
}

#sidebar ul.components {
    /* padding: 20px 0; */
    /* border-bottom: 1px solid #47748b; */
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
    color: #424646;
}

#sidebar li > ul, #sidebar li > ol{margin: 0!important;}

#sidebar ul li a:hover {
    color: #7386D5;
    background: #fff;
}

#sidebar ul li.active>a,
a[aria-expanded="true"] {
    color: #424646;
    /* background: #6d7fcc; */
}

a[data-toggle="collapse"] {
    position: relative;
}

/*.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 13%;
    right: 25px;
    transform: translateY(-50%);
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
    color: #424646;
}

.dropdown-toggle.collapsed::after {
    display: block;
    position: absolute;
    top: 13%;
    right: 25px;
    transform: translateY(-50%);
    border-top: .3em solid transparent;
    border-right: .3em solid;
    border-bottom: .3em solid transparent;
    border-left: .3em solid transparent;
    color: #424646;
}*/

.product-area ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    color: #424646;
    /* background: #6d7fcc; */
}

.product-area ul.CTAs {
    padding: 20px;
}

.product-area ul.CTAs a {
    text-align: center;
    font-size: 0.9em !important;
    display: block;
    border-radius: 5px;
    margin-bottom: 5px;
}

.product-area a.download {
    background: #fff;
    color: #7386D5;
}

.product-area a.article,
.product-area a.article:hover {
    background: #6d7fcc !important;
    color: #fff !important;
}
</style>
@endpush
@section('content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="bread-inner">
          <ul class="bread-list">
            <li><a href="/">Home<i class="ti-arrow-right"></i></a></li>
            <li class="active"><a href="#">Category</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Breadcrumbs -->
<!-- Product Style -->
<section class="product-area shop-sidebar shop section">
  <div class="container">
    <div class="row">
      @include('users.blocks.product-sidebar')

      <div class="col-lg-9 col-md-8 col-12">
        <div class="row">
          <div class="col-12">
            @include('users.blocks.product-sort')
          </div>
        </div>
        <div class="row">
          @include('users.blocks.product-items')
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ End Product Style 1  -->

@push('pagejs')
<script>
  $('#detailModal').on('show.bs.modal', function (e) {
    var data = { 'prodid':  $(e.relatedTarget).attr('data-prodid'), _token: '{{csrf_token()}}'};
    $.post( "/product/get-product-details", data)
        .done(function( html ) {
          console.log(html);
            //$("#_prodList").html(html);
        });
    //$("#_prodList").html('<h1>Add your purchase order here!!!</h1>')
  });
</script>
@endpush


<!-- Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
        </div>
        <div class="modal-body">
          <div class="row no-gutters">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <!-- Product Slider -->
                <div class="product-gallery">
                  <div class="quickview-slider-active">
                    <div class="single-slider">
                      <img src="https://via.placeholder.com/569x528" alt="#">
                    </div>
                    <div class="single-slider">
                      <img src="https://via.placeholder.com/569x528" alt="#">
                    </div>
                    <div class="single-slider">
                      <img src="https://via.placeholder.com/569x528" alt="#">
                    </div>
                    <div class="single-slider">
                      <img src="https://via.placeholder.com/569x528" alt="#">
                    </div>
                  </div>
                </div>
              <!-- End Product slider -->
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="quickview-content">
                <h2 id="ptitle">Flared Shift Dress</h2>
                <div class="quickview-ratting-review">
                  <div class="quickview-stock">
                    <span><i class="fa fa-check-circle-o"></i> in stock</span>
                  </div>
                </div>
                <h3 id="sprice">$29.00</h3>
                <div class="quickview-peragraph">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam.</p>
                </div>
                <div class="size">
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <h5 class="title">Size</h5>
                      <select>
                        <option selected="selected">s</option>
                        <option>m</option>
                        <option>l</option>
                        <option>xl</option>
                      </select>
                    </div>
                    <div class="col-lg-6 col-12">
                      <h5 class="title">Color</h5>
                      <select>
                        <option selected="selected">orange</option>
                        <option>purple</option>
                        <option>black</option>
                        <option>pink</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="quantity">
                  <!-- Input Order -->
                  <div class="input-group">
                    <div class="button minus">
                      <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                        <i class="ti-minus"></i>
                      </button>
                    </div>
                    <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
                    <div class="button plus">
                      <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                        <i class="ti-plus"></i>
                      </button>
                    </div>
                  </div>
                  <!--/ End Input Order -->
                </div>
                <div class="add-to-cart">
                  <a href="#" class="btn">Add to cart</a>
                  <a href="#" class="btn min"><i class="ti-heart"></i></a>
                  <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                </div>
                <div class="default-social">
                  <h4 class="share-now">Share:</h4>
                  <ul>
                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal end -->
@endsection
