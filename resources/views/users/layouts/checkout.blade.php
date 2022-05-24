<?php $page="products";?>
@extends('users.layouts.app')
@section('content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="bread-inner">
          <ul class="bread-list">
            <li><a href="/">Home<i class="ti-arrow-right"></i></a></li>
            <li class="active"><a href="#">Checkout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Breadcrumbs -->
<!-- Shopping Cart -->
<div class="shopping-cart section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- Shopping Summery -->
        <table class="table shopping-summery">
          <thead>
            <tr class="main-hading">
              <th>PRODUCT</th>
              <th>NAME</th>
              <th class="text-center">UNIT PRICE</th>
              <th class="text-center">QUANTITY</th>
              <th class="text-center">TOTAL</th>
              <th class="text-center"><i class="ti-trash remove-icon"></i></th>
            </tr>
          </thead>
          <tbody>
            @inject('crt', 'App\Http\Controllers\CartController')
            <?php
            $cartTotal=0;$qt=1;
            foreach($cart as $c){
              $cartTotal += $c->quantity*$c->price;
            ?>
            <tr>
              <td class="image" data-title="No"><img src="/{{$c->images}}" alt="{{$c->title}}"></td>
              <td class="product-des" data-title="Description">
                <p class="product-name"><a href="/product/{{$c->slug}}">{{$c->title}}</a></p>
                <p class="product-des"><?php //echo $crt->getOptionValues($c->option);?></p>
              </td>
              <td class="price" data-title="Price"><span>Rs. {{$c->price}} </span></td>
              <td class="qty" data-title="Qty"><!-- Input Order -->
                <div class="input-group">
                  <div class="button minus">
                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$qt}}]">
                      <i class="ti-minus"></i>
                    </button>
                  </div>
                  <input type="text" name="quant[{{$qt}}]" class="input-number"  data-min="1" data-max="100" value="{{$c->quantity}}">
                  <div class="button plus">
                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$qt}}]">
                      <i class="ti-plus"></i>
                    </button>
                  </div>
                </div>
                <!--/ End Input Order -->
              </td>
              <td class="total-amount" data-title="Total"><span>Rs. {{$c->quantity*$c->price}}</span></td>
              <td class="action" data-title="Remove"><a href="/cart/remove/{{$c->id}}"><i class="ti-trash remove-icon"></i></a></td>
            </tr>
            <?php $qt++;}?>
          </tbody>
        </table>
        <!--/ End Shopping Summery -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <!-- Total Amount -->
        <div class="total-amount">
          <div class="row">
            <div class="col-lg-8 col-md-5 col-12">
              <div class="left">
                <!-- <div class="coupon">
                  <form action="#" target="_blank">
                    <input name="Coupon" placeholder="Enter Your Coupon">
                    <button class="btn">Apply</button>
                  </form>
                </div> -->
                <div class="checkbox">
                  <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (Rs.+200)</label>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-7 col-12">
              <div class="right">
                <ul>
                  <li>Cart Subtotal<span>Rs. {{$cartTotal}}</span></li>
                  <li>Shipping<span>Free</span></li>
                  <!-- <li>You Save<span>$20.00</span></li> -->
                  <li class="last">You Pay<span>{{$cartTotal}}</span></li>
                </ul>
                <div class="button5">
                  <a href="#" class="btn">Checkout</a>
                  <a href="/products" class="btn">Continue shopping</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ End Total Amount -->
      </div>
    </div>
  </div>
</div>
<!--/ End Shopping Cart -->
@endsection
