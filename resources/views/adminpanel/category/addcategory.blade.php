@push('pagecss')
<style>
.cover {
    border-bottom: gray 1px dotted;
    padding: 0 10px;
}
.table-responsive li.cttl {
    display: inline-block;
    width: 65%;
    padding: 5px 0;
}
.table-responsive li.caction {
    display: inline-block;
    width: 15%;
    padding: 5px 0;
    text-align: center;
}
.pad-lft-0 {padding: 3px 0 3px 0px;}
.pad-lft {padding: 5px 0 5px 20px;}
</style>
@endpush
<div class="col-lg-4">
  <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Add Category</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="/admin/category/store" method="post" name="category" id="category">
      <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" id="catid" name="catid" value="<?php if(!empty($category)) echo $category->id;?>">
      <div class="card-body">
        <div class="form-group">
          <label for="title">Category name</label>
          <input type="text" class="form-control" name="title" id="title" placeholder="Enter category name" value="<?php if(!empty($category)) echo $category->name;?>">
        </div>
        <div class="form-group">
          <label for="fullname">Slug</label>
          <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="<?php if(!empty($category)) echo $category->slug;?>">
        </div>
        <div class="form-group">
          <label for="email">Parent</label>
          {!! $cateTree !!}
        </div>
        <div class="form-group">
          <label for="fullname">#Hastag</label>
          <input type="text" class="form-control" name="hashtag" id="hashtag" placeholder="#Hastag" value="<?php if(!empty($category)) echo $category->hash;?>">
        </div>
        <div class="form-group">
          <label for="ctype">Category type</label>
          <select class="form-control" name="ctype" id="ctype">
            <option value="product" <?php if(!empty($category) and $category->type=='product') echo 'selected';?>>Product</option>
          </select>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>

    </form>
  </div>
  <!-- /.card -->
</div>
@push('pagejs')
<script src="/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {


      $('.form-group #title').keyup(function(){
          var articleTitle= $('.form-group #title').val();
          var slug = articleTitle.toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')
          $('.form-group #slug').val(slug);
      });



  $('#category').validate({
    rules: {
      title: {
        required: true
      }
    },
    messages: {
      title: {
        required: "Please enter category name",
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
@endpush
