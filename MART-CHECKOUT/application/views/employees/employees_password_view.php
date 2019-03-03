<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-6">

      <?php echo $this->session->flashdata('message'); ?>
      <h1>Reset Password</h1>
      <br>

      <?php
      echo form_open('employees/reset_password/'.$employee['banner_id']);
      echo form_hidden('form_id', $employee['banner_id']);
      ?>

        <!-- password -->
        <div class="form-group">
          <label for="form_password" class="control-label">Password</label>
          <input class="form-control" id="form_password" name="form_password" placeholder="Password" type="password" value="<?php echo set_value('form_password'); ?>" />
          <span class="text-danger"><?php echo form_error('form_password'); ?></span>
        </div>

        <!-- password -->
        <div class="form-group">
          <label for="form_re-enter_password" class="control-label">Confirm Password</label>
          <input class="form-control" id="form_confirm_password" name="form_confirm_password" placeholder="Confirm Password" type="password" value="<?php echo set_value('form_re-enter_password'); ?>" />
          <span class="text-danger"><?php echo form_error('form_confirm_password'); ?></span>
        </div>

        <!-- Password reset button -->
        <div class="form-group">
          <input id="btn_register" name="btn_register" type="submit" class="btn btn-primary float-right" value="Submit" />
        </div>
        <?php echo form_close(); ?>


    </div>
  </div>
</div>
