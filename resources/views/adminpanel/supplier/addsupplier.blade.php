<div class="col-lg-3">
  <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Add Supplier</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="/admin/supplier/store" method="post" name="supplier" id="supplier">
      <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" id="supid" name="supid" value="<?php if(!empty($supplier)) echo $supplier->id;?>">
      <div class="card-body">
        <div class="form-group">
          <label for="fullname">Supplier name</label>
          <input type="text" class="form-control" name="name" id="name" placeholder="Enter supplier name" value="<?php if(!empty($supplier)) echo $supplier->name;?>">
        </div>
        <div class="form-group">
          <label for="fullname">Supplier representative</label>
          <input type="text" class="form-control" name="rpname" id="rpname" placeholder="Enter representative name" value="<?php if(!empty($supplier)) echo $supplier->rpname;?>">
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" id="email" <?php if(!empty($supplier)) echo 'value="'.$supplier->email.'"';?> placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="phone">Phone 1</label>
          <input type="text" class="form-control" name="phone1" id="phone1" placeholder="Enter phone number" value="<?php if(!empty($supplier)) echo $supplier->phone1;?>">
        </div>
        <div class="form-group">
          <label for="phone">Phone 2</label>
          <input type="text" class="form-control" name="phone2" id="phone2" placeholder="Enter phone number" value="<?php if(!empty($supplier)) echo $supplier->phone2;?>">
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="location" id="location" placeholder="Enter address" value="<?php if(!empty($supplier)) echo $supplier->location;?>">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" name="status" id="status">
            <option value="">Select</option>
            <option value="active" <?php if(!empty($supplier) and $supplier->status=='active') echo 'selected';?>>Active</option>
            <option value="inactive" <?php if(!empty($supplier) and $supplier->status=='inactive') echo 'selected';?>>Inactive</option>
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
  /*$.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });*/
  $('#registration').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      <?php if(!empty($customer)) {?>
      password: {
        minlength: 5
      },
      confirmpass: {
        minlength: 5,
        equalTo : "#password"
      },
      <?php } else {?>
        password: {
          required: true,
          minlength: 5
        },
        confirmpass: {
          required: true,
          minlength: 5,
          equalTo : "#password"
        },
      <?php } ?>
      fullname: {
        required: true
      },
      phone: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter an email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please enter a password",
        minlength: "Your password must be at least 5 characters long"
      },
      confirmpass: {
        required: "Please enter a confirm password",
        minlength: "Your password must be at least 5 characters long",
        equalTo: "Please enter the same password again"
      },
      fullname: "Please provide your full name",
      phone: "Please provide your phone number"
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
