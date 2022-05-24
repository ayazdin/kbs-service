<?php foreach($products as $p){ ?>
<div class="col-lg-3 col-md-6 col-12">
  <div class="single-product">
    <div class="product-img">
      <a href="/product/{{$p->slug}}">
        <img class="default-img" src="{!! URL::to($p->images) !!}" alt="{{$p->title}}">
        <!-- <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#"> -->
      </a>
      <div class="button-head">
        <div class="product-action">
          <!-- <a data-toggle="modal" data-target="#detailModal" data-prodid="{{$p->id}}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a> -->
          <!-- <a title="Wishlist" href="#">#<span>{{$p->sku}}</span></a> -->
          <!-- <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a> -->
        </div>
        <div class="product-action-2">
          <a title="Add to cart" href="#">SKU: #{{$p->sku}}</a>
        </div>
      </div>
    </div>
    <div class="product-content">
      <h3><a href="/product/{{$p->slug}}">{{$p->title}}</a></h3>
      <div class="product-price">
        <span>Rs. {{$p->wp}}</span>
      </div>
    </div>
  </div>
</div>
<?php }?>
