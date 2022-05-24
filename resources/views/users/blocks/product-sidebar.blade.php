<div class="col-lg-3 col-md-4 col-12">
  <div class="shop-sidebar">

      <!-- Single Widget -->
      <div class="single-widget category">
        <h3 class="title">Categories</h3>

        <nav id="sidebar">
          <?php echo $categories; ?>
        </nav>
      </div>
      <!--/ End Single Widget -->
      <!-- Shop By Price -->
        <!-- <div class="single-widget range">
          <h3 class="title">Shop by Price</h3>
          <div class="price-filter">
            <div class="price-filter-inner">
              <div id="slider-range"></div>
                <div class="price_slider_amount">
                <div class="label-input">
                  <span>Range:</span><input type="text" id="amount" name="price" placeholder="Add Your Price"/>
                </div>
              </div>
            </div>
          </div>
          <ul class="check-box-list">
            <li>
              <label class="checkbox-inline" for="1"><input name="news" id="1" type="checkbox">$20 - $50<span class="count">(3)</span></label>
            </li>
            <li>
              <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">$50 - $100<span class="count">(5)</span></label>
            </li>
            <li>
              <label class="checkbox-inline" for="3"><input name="news" id="3" type="checkbox">$100 - $250<span class="count">(8)</span></label>
            </li>
          </ul>
        </div> -->
        <!--/ End Shop By Price -->

        <!-- Single Widget -->
        <div class="single-widget category">
          <h3 class="title">Supplier</h3>
          <ul class="categor-list">
            <?php foreach($suppliers as $sup){?>
            <li><a href="/supplier/{{$sup->id}}"><?php echo $sup->name;?></a></li>
            <?php }?>
          </ul>
        </div>
        <!--/ End Single Widget -->
  </div>
</div>
