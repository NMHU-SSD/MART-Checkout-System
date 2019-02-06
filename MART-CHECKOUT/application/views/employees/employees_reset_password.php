<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">

      <?php echo $this->session->flashdata('message'); ?>

      <h1>Reset Employee Password</h1>
      <br>

      <?php if($_SESSION['user_role'] == "Manager" || $_SESSION['user_role'] == "Assistant"){ ?>
        <?php echo form_open('employees/reset_password/'.$employee['banner_id'], 'onsubmit="return validateForm()"'); ?>

        <!-- banner id -->
        <div class="form-group">
          <label for="form_id" class="control-label">Banner ID</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">@</span>
            </div>
            <input readonly class="form-control" id="form_id" name="form_id" placeholder="" type="text"  aria-describedby="basic-addon1" value="<?php echo $employee['banner_id']; ?>" />
          </div>
          <span class="text-danger"><?php echo form_error('form_id'); ?></span>
        </div>

        <!-- name -->
        <div class="form-group">
          <label for="form_name" class="control-label">Name</label>
          <input class="form-control" id="form_name" name="form_name" placeholder="Name" type="text" value="<?php echo set_value('form_name', $employee['name']) ?>" />
          <span class="text-danger"><?php echo form_error('form_name'); ?></span>
        </div>

        <!-- password -->
        <div class="form-group">
          <label for="form_password" class="control-label">Password</label>
          <input class="form-control" id="form_password" name="form_password" placeholder="Password" type="password" value="<?php echo set_value('form_password'); ?>" />
          <span class="text-danger"><?php echo form_error('form_password'); ?></span>
        </div>

        <!-- password -->
        <div class="form-group">
          <label for="form_re-enter_password" class="control-label">Re-Enter Password</label>
          <input class="form-control" id="form_re-enter_password" name="form_re-enter_password" placeholder="Re-enter Password" type="password" value="<?php echo set_value('form_re-enter_password'); ?>" />
          <span class="text-danger"><?php echo form_error('form_re-enter_password'); ?></span>
        </div>

        <!-- Password reset button -->
        <div class="form-group">
          <input id="btn_register" name="btn_register" type="submit" class="btn btn-primary" value="Reset Password" />
        </div>
        <?php echo form_close(); ?>
      <?php } ?>
    </div>
  </div>
</div>

<script>
$(function () {
  // Put User in the first input field when page loads
  $("#form_name").focus();
});

function validateForm(){
  var fName = document.getElementById("form_name").value;
  var fPass = document.getElementById("form_password").value;
  var fRePass = document.getElementById("form_re-enter_password").value;

  if(fName == ""){
    alert("Name must not be empty");
    return false;
  }else if(fPass == ""){
    alert("Password must not be empty");
    return false;
  }else if(fRePass == ""){
    alert("Re-Enter Password must not be empty");
    return false;
  }
}
</script>
