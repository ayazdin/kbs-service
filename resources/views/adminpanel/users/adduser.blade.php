<div class="col-lg-4">
  <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Add User</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="/admin/user/store" method="post" name="registration" id="registration">
      <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" id="userid" name="userid" value="<?php if(!empty($customer)) echo $customer->id;?>">
      <div class="card-body">
        <div class="form-group">
          <label for="fullname">Full name</label>
          <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Enter full name" value="<?php if(!empty($customer)) echo $customer->name;?>">
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" id="email" <?php if(!empty($customer)) echo 'disabled value="'.$customer->email.'"';?> placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="phone">Phone number</label>
          <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone number" value="<?php if(!empty($customer)) echo $customer->phone;?>">
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" value="<?php if(!empty($customer)) echo $customer->address;?>">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="confirmpass">Confirm password</label>
          <input type="password" class="form-control" name="confirmpass" id="confirmpass" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="role">Role</label>
          <select class="form-control" name="role" id="role">
            <?php foreach($roles as $role){ ?>
            <option value="{{$role->id}}" <?php if(!empty($customer) and $customer->role_id==$role->id) echo 'selected';?>>{{$role->name}}</option>
          <?php }?>
            <!-- <option value="staff" <?php //if(!empty($customer) and $customer->role=='staff') echo 'selected';?>>Staff</option> -->
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
