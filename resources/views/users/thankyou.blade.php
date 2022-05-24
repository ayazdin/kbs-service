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
            <li class="active"><a href="#">Cart</a></li>
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
            </tr>
          </thead>
          <tbody>
            @inject('crt', 'App\Http\Controllers\CartController')
            <?php
            $cartTotal=0;$qt=1;
            foreach($orders as $c){
              $cartTotal += $c->quantity*$c->price;
            ?>
            <tr>
              <td class="image" data-title="No"><img src="/{{$c->images}}" alt="{{$c->title}}"></td>
              <td class="product-des" data-title="Description">
                <p class="product-name"><a href="/product/{{$c->slug}}">{{$c->title}}</a></p>
                <p class="product-des"><?php //echo $crt->getOptionValues($c->option);?></p>
              </td>
              <td class="price" data-title="Price"><span>Rs. {{$c->price}} </span></td>
              <td class="qty" data-title="Qty"><span>{{$c->quantity}} </span>

              </td>
              <td class="total-amount {{$c->id}}" data-title="Total"><span>Rs. {{$c->quantity*$c->price}}</span></td>
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
                <div class="coupon">
                  <!-- <form action="#" target="_blank">
                    <input type="text" name="paid" id="paid" placeholder="Amount Paid">
                    <button class="btn">Apply</button>
                  </form> -->
                </div>
                <!-- <div class="checkbox">
                  <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (Rs.+200)</label>
                </div> -->
              </div>
            </div>
            <div class="col-lg-4 col-md-7 col-12">
              <div class="right">
                <form action="#">
                  <ul>
                    <li>Cart Subtotal<span class="gtotal">Rs. {{$cartTotal}}</span></li>
                    <!-- <li>Shipping<span>Free</span></li> -->
                    <!-- <li>You Save<span>$20.00</span></li> -->
                    <li class="last">Grand Total<span class="gtotal">Rs. {{$cartTotal}}</span></li>
                    <!-- <li>You Paid<span><input type="text" name="paid" id="paid" placeholder="Amount Paid"></span></li> -->
                  </ul>
                  <!-- <div class="button5">
                    <a href="/checkout" class="btn">Checkout</a>
                    <a href="/products" class="btn">Continue shopping</a>
                  </div> -->
                </form>
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
