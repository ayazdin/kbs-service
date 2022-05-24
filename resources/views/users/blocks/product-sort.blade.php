<!-- Shop Top -->
<div class="shop-top">
  <div class="shop-shorter">
    <div class="single-shorter">
      <label>Sort By :</label>
      <select name="sortby" class="sortby">
        <option value="data-title" {!! ($sortby== 'data-title') ? 'selected' : '' !!}>Name</option>
        <option value="date-asc" {!! ($sortby== 'date-asc') ? 'selected' : '' !!}>Older First</option>
        <option value="date-desc" {!! ($sortby== 'date-desc') ? 'selected' : '' !!}>Newer First</option>
        <option value="price-asc" {!! ($sortby== 'price-asc') ? 'selected' : '' !!}> Price low to high</option>
        <option value="price-desc" {!! ($sortby== 'price-desc') ? 'selected' : '' !!}> Price high to low</option>
      </select>
    </div>
    <div class="single-shorter">
      <button name="submit-sort" class="btn btn-md btn-primary sortme">Sort</button>
    </div>
  </div>
  <!-- <ul class="view-mode">
    <li class="active"><a href="shop-grid.html"><i class="fa fa-th-large"></i></a></li>
    <li><a href="shop-list.html"><i class="fa fa-th-list"></i></a></li>
  </ul> -->
</div>
<!--/ End Shop Top -->
