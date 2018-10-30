<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">

      <h1>Edit Faculty</h1>
      <br>
      <?php
      $active_options = array(
        'active' => 'Active'
      );
      $eligible_options = array(
        'eligible' => 'Eligible'
      );

      echo form_open('faculty/update/'.$records->banner_id);
      echo form_hidden('old_banner_id', $records->banner_id);
      ?>

      <!-- banner id -->
      <div class="form-group">
        <label for="banner_id" class="control-label">Banner ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'banner_id', 'name'=>'banner_id', 'value'=>$records->banner_id, 'class' => 'form-control'));
          ?>
        </div>
        <span class="text-danger"><?php echo form_error('banner_id'); ?></span>
      </div>

      <!-- Name -->
      <?php
      echo form_label('Name');
      echo form_input(array('id'=>'name','name'=>'name', 'value'=>$records->name, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('name');?></span>
      <br>

      <!-- Email -->
      <?php
      echo form_label('Email');
      echo form_input(array('id'=>'email','name'=>'email', 'value'=>$records->email, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('email');?></span>
      <br>

      <!-- Phone -->
      <?php
      echo form_label('Phone');
      echo form_input(array('id'=>'phone','name'=>'phone', 'value'=>$records->phone, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('phone');?></span>
      <br>

      <!-- Clearance Level -->
      <?php
      echo form_label('Clearance Level');
      echo form_input(array('id'=>'clearance_level','name'=>'clearance_level', 'value'=>$records->clearance_level, 'readonly' => 'true', 'class' => 'form-control'));
      ?>
      <br>

      <!-- Amount Owed -->
      <?php
      echo form_label('Amount Owed');
      echo form_input(array('id'=>'amount_owed','name'=>'amount_owed', 'value'=>$records->amount_owed, 'readonly' => 'true', 'class' => 'form-control'));
      ?>
      <br>

      <!-- Enrollment Status -->
      <div class="form-group">
        <label for="active" class="control-label">Enrollment Status</label>
        <?php
        echo form_dropdown('active', $active_options, $records->enrollment );
        ?>
      </div>

      <!-- Eligibility Status -->
      <div class="form-group">
        <label for="eligible" class="control-label">Eligibility Status</label>
        <?php
        echo form_dropdown('eligible', $eligible_options, $records->eligibility );
        ?>
      </div>

      <!-- Submit Button -->
      <?php
      echo form_input(array('type'=>'submit','value'=>'Update', 'class'=> 'btn btn-primary'));
      echo form_close();
      ?>
    </div>
  </div>
</div>
