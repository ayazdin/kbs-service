<!-- Header -->
<header class="header shop">
  <div class="middle-inner">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 col-md-2 col-12">
          <!-- Logo -->
          <div class="logo">
            <a href="/"><img src="/images/trek-logo.png" alt="logo"></a>
          </div>
          <!--/ End Logo -->
          <!-- Search Form -->
          <div class="search-top">
            <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
            <!-- Search Form -->
            <div class="search-top">
              <form class="search-form">
                <input type="text" placeholder="Search here..." name="search">
                <button value="search" type="submit"><i class="ti-search"></i></button>
              </form>
            </div>
            <!--/ End Search Form -->
          </div>
          <!--/ End Search Form -->
          <div class="mobile-nav"></div>
        </div>
        <div class="col-lg-6 col-md-7 col-12">
          <div class="search-bar-top">
            <div class="search-bar">
              <form>
                <input name="search" placeholder="Search Products Here....." type="search">
                <button class="btnn"><i class="ti-search"></i></button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-3 col-12">
          <div class="right-bar">
            <ul class="list-main">
              <li><i class="ti-user"></i> <a href="/user/dashboard">Welcome <b>{{$user->name}}</b></a></li>
              <?php if($cart->isNotEmpty()){ ?>
                <li><a href="/cart"><i class="ti-shopping-cart-full"></i></a></li>
              <?php }?>
              <!-- Authentication Links -->
              @guest
                  <li>
                      <i class="ti-power-off"></i>
                      <a href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @else
                  <li>

                      <a href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          <i class="ti-power-off" title="{{ __('Logout') }}"></i>
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </li>
              @endguest
              <li>
                <!-- Search Form -->
                <div class="sinlge-bar shopping">
                  <a href="#" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{count($cart)}}</span></a>
                  <!-- Shopping Item -->
                  <div class="shopping-item">
                    <div class="dropdown-cart-header">
                      <span>{{count($cart)}} Items</span>
                      <a href="/cart">View Cart</a>
                    </div>
                    <ul class="shopping-list">
                      <?php
                        $cartTotal = 0;
                        foreach($cart as $c){
                          $cartTotal += $c->price;
                      ?>
                      <li>
                        <a href="/cart/remove/{{$c->id}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                        <a class="cart-img" href="/product/{{$c->slug}}"><img src="/{{$c->images}}" alt="{{$c->title}}"></a>
                        <h4><a href="/product/{{$c->slug}}">{{$c->title}}</a></h4>
                        <p class="quantity">{{$c->quantity}} - <span class="amount">Rs.{{$c->price}}</span></p>
                      </li>
                    <?php }?>
                    </ul>
                    <div class="bottom">
                      <div class="total">
                        <span>Total</span>
                        <span class="total-amount">Rs. {{$cartTotal}}</span>
                      </div>
                      <a href="/cart" class="btn animate">Checkout</a>
                    </div>
                  </div>
                  <!--/ End Shopping Item -->
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Header Inner -->
  <div class="header-inner">
    <div class="container">
      <div class="cat-nav-head">
        <div class="row">
          <div class="col-12">
            <div class="menu-area">
              <!-- Main Menu -->
              <nav class="navbar navbar-expand-lg">
                <div class="navbar-collapse">
                  <div class="nav-inner">
                    <ul class="nav main-menu menu navbar-nav">
                      <li <?php if($page=="") echo 'class="active"';?>><a href="/">Home</a></li>
                      <li <?php if($page=="products") echo 'class="active"';?>><a href="/products">Products</a></li>
                      <li <?php if($page=="contact") echo 'class="active"';?>><a href="/contact">Contact Us</a></li>
                    </ul>
                  </div>
                </div>
              </nav>
              <!--/ End Main Menu -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ End Header Inner -->
</header>
<!--/ End Header -->
<?php //if($cart->isEmpty()) echo "Empty";?>
