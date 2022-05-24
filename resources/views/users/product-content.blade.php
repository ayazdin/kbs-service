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
