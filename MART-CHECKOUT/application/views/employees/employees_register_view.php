<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">

      <?php echo $this->session->flashdata('message'); ?>

      <h1>Register New User</h1>
      <br>

      <?php echo form_open('employees/register', 'onsubmit="return validateForm()"') ?>

      <!-- user type -->
      <div class="form-group">
        <label for="form_name" class="control-label">Role</label>

        <!-- helper function to generate select form field with options -->
        <?php
        $selected = set_value('form_role');
        echo form_dropdown('form_role', $roles, $selected);
        ?>

        <span class="text-danger"><?php echo form_error('form_role'); ?></span>
      </div>

      <!-- banner id -->
      <div class="form-group">
        <label for="form_id" class="control-label">Banner ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">@</span>
          </div>
          <input class="form-control" id="form_id" name="form_id" autocomplete="off" type="text" placeholder="" type="text"  aria-describedby="basic-addon1" value="<?php echo set_value('form_id'); ?>" />
        </div>

        <span class="text-danger"><?php echo form_error('form_id'); ?></span>
      </div>

      <!-- name -->
      <div class="form-group">
        <label for="form_name" class="control-label">Name</label>
        <input class="form-control" id="form_name" name="form_name" placeholder="Name" type="text" value="<?php echo set_value('form_name'); ?>" />
        <span class="text-danger"><?php echo form_error('form_name'); ?></span>
      </div>

      <!-- password -->
      <div class="form-group">
        <label for="form_password" class="control-label">Password</label>
        <input class="form-control" id="form_password" name="form_password" placeholder="Password" type="password" value="<?php echo set_value('form_password'); ?>" />
        <span class="text-danger"><?php echo form_error('form_password'); ?></span>
      </div>

      <!-- register button -->
      <div class="form-group">
        <input id="btn_register" name="btn_register" type="submit" class="btn btn-primary" value="Register" />
        <input type="reset" id="btn_reset" name="btn_reset" class="btn btn-default" value="Cancel"/>
      </div>

      <?php echo form_close(); ?>

    </div>
  </div>
</div>

<script type="text/javascript">
$(function () {
  // Put User in the first input field when page loads
  $("#form_id").focus();
});

function validateForm(){
  // Get input
  var fBannerID = document.getElementById("form_id").value;
  var fName = document.getElementById("form_name").value;
  var fPass = document.getElementById("form_password").value;

  // Tell the user that there needs to be text
  if(fBannerID == ""){
    alert("Banner ID must not be empty");
    return false;
  }else if(fName == ""){
    alert("Name must not be empty");
    return false;
  }else if(fPass == ""){
    alert("Password must not be empty");
    return false;
  }
}

$(document).ready(function(){
  var $regexname = /[^0-9]/g;
  $("#form_id").focus(function() {
    // user click into the text box
    console.log('in');
  }).blur(function() {
    // user clicks out of thetext box
    $(this).val($(this).val().replace($regexname, ''));
    console.log('out');
  });
});
</script>
