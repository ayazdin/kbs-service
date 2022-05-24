<?php $page="products";?>
@extends('users.layouts.app')
@push('pagecss')
<!-- Owl Carousel -->
<link rel="stylesheet" href="/css/owl-carousel.css">
<style>
  .quickview-content h6 {margin-bottom: 20px;}
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
            <li class="active"><a href="#">product-detail</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Breadcrumbs -->
<!-- Product Style -->
<?php //dd($images);?>
<section class="product-area shop-sidebar section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <!-- Product Slider -->
          <div class="product-gallery">
            <div class="quickview-slider-active">
              <?php
                if($images->isNotEmpty()){
                  foreach($images as $im){
                    $imgarr = unserialize($im->images);
              ?>
              <div class="single-slider">
                <img src="/{{$imgarr[0]}}" alt="{{$product->title}}">
              </div>
            <?php }}else{ ?>
              <div class="single-slider">
                <img src="/{{$product->images}}" alt="{{$product->title}}">
              </div>
            <?php } ?>
            </div>
          </div>
        <!-- End Product slider -->
      </div>

      <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <form name="frmCart" id="frmCart" method="post" action="/product/add-to-cart">
          <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="prodid" value="{{$product->id}}">
          <input type="hidden" name="wp" value="{{$product->wp}}">
          <input type="hidden" name="option" id="option" value="">
        <div class="quickview-content">
          <h2 id="ptitle">{{$product->title}}</h2>
          <div class="quickview-ratting-review">
            <div class="quickview-stock">
              <span><i class="fa fa-check-circle-o"></i> in stock</span>
            </div>
          </div>
          <h3 id="sprice">Wholesale: {{$product->wp}}</h3>
          <h3>Retail: {{$product->sp}}</h3>
          <h6>SKU: #{{$product->sku}}</h6>
          <div class="quickview-peragraph">
            {!! $product->description !!}
          </div>
          <div class="size">
            <div class="row">
              <?php
                //print_r($options);
                /*foreach($options as $option)
                {
              ?>
              <div class="col-lg-6 col-12">
                <h5 class="title">{{$option['name']}}</h5>
                <select name="<?php echo strtolower($option['name']);?>" id="_<?php echo strtolower($option['name']);?>">
                  <option value="">Please Select</option>
                  <?php foreach($option['options'] as $key=>$val){?>
                    <option value="{{$key}}">{{$val}}</option>
                  <?php }?>
                </select>
              </div>
              <?php
                }*/
              ?>
            </div>
          </div>
          <div class="quantity">
            <!-- Input Order -->
            <div class="input-group">
              <div class="button minus">
                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quantity">
                  <i class="ti-minus"></i>
                </button>
              </div>
              <input type="text" name="quantity" class="input-number"  data-min="1" data-max="1000" value="1">
              <div class="button plus">
                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quantity">
                  <i class="ti-plus"></i>
                </button>
              </div>
            </div>
            <!--/ End Input Order -->
          </div>
          <div class="add-to-cart">
            <button class="btn addtocart">Add to cart</button>
            <!-- <a href="#" class="btn min"><i class="ti-heart"></i></a>
            <a href="#" class="btn min"><i class="fa fa-compress"></i></a> -->
          </div>
          <!-- <div class="default-social">
            <h4 class="share-now">Share:</h4>
            <ul>
              <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
              <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
            </ul>
          </div> -->
        </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('pagejs')
<script>
  $(".addtocart").on('click', function(e){
    e.preventDefault();
    var _opt = "";
    var _valid = true;
    var _inv = JSON.parse('<?php echo json_encode($inventories);?>');
    <?php
      $i=0;
      if(!empty($options))
      {
        foreach($options as $option)
        {
    ?>
      if($("#_<?php echo strtolower($option['name']);?>").val()!="")
        _opt += $("#_<?php echo strtolower($option['name']);?>").val()+"-";
      else
        _valid = false;
    <?php
        $i++;
        }
    ?>
        _opt=_opt.replace(/-+$/,'');
    <?php
      }
    ?>
    if(_valid==true)
    {
      $("#option").val(_opt);
      $("#frmCart").submit();
    }
    //console.log("Here we are: "+_inv[_opt]);
  });
</script>
@endpush
