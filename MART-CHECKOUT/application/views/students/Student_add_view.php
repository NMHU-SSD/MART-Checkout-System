<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add New Student</h1>
      <br>
      <?php
      $active_options = array(
        'inactive' => 'Inactive',
        'active' => 'Active'
      );
      $eligible_options = array(
        'ineligible' => 'Ineligible',
        'eligible' => 'Eligible'
      );

      echo form_open('students/add', 'onsubmit="return validateForm()"');
      ?>

      <!-- banner id -->
      <div class="form-group">
        <label for="banner_id" class="control-label">Banner ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'banner_id','name'=>'banner_id', 'type' => 'text', 'value' => set_value('banner_id'), 'class' => 'form-control', 'autocomplete' => 'off', 'required'=>TRUE));
          ?>
        </div>
        <span class="text-danger"><?php echo form_error('banner_id'); ?></span>
      </div>

      <!-- name -->
      <?php
      echo form_label('Name');
      echo form_input(array('id'=>'`name`','name'=>'name', 'value' => set_value('name'), 'class' => 'form-control', 'required'=>TRUE));
      ?>
      <span class="text-danger"><?php echo form_error('name');?></span>
      <br>

      <!-- Email -->
      <?php
      echo form_label('Email');
      echo form_input(array('id'=>'email','name'=>'email','value' => set_value('email'), 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'email', 'required'=>TRUE)); ?>
      <span class="text-danger"><?php echo form_error('email');?></span>
      <br>

      <!-- Phone Number -->
      <?php
      echo form_label('Phone');
      echo form_input(array('id'=>'phone','name'=>'phone', 'value' => set_value('phone'), 'class' => 'form-control', 'placeholder' => "505-555-5555", 'type'=>"tel" , 'pattern'=>"[0-9]{3}-[0-9]{3}-[0-9]{4}", 'required'=>TRUE));
      ?>
      <span class = "text-danger"><?php echo form_error('phone');?></span>
      <br>


      <!-- Enrollment status -->
      <div class="form-group">
        <?php
        echo form_label('Enrollment Status');
        echo form_dropdown('active', $active_options, set_value('active'), "class='form-control'");
        ?>
      </div>

      <!-- Eligibility Status -->
      <div class="form-group">
        <?php
        echo form_label('Eligibility Status');
        echo form_dropdown('eligible', $eligible_options, set_value('eligible'), "class='form-control'");
        ?>
      </div>

      <!-- Amount Owed -->
      <?php
      echo form_label('Amount Owed');
      echo form_input(array('id'=>'amount_owed','name'=>'amount_owed', 'value' => set_value('amount_owed'), 'class' => 'form-control'));
      ?>
      <span class="text-danger"><?php echo form_error('amount_owed');?></span>
      <br>

      <!-- Clearance Level -->
      <div class="form-group">
        <label for="clearance">Select Clearance Level</label><br>
        <?php

        // Clearance array
        $new_clear = array();

        // New array with key clearance id and value clearance level
        foreach ($clearance_options as $options) {
          $new_clear[$options->id] = $options->name;
        }

        foreach($new_clear as $c=>$label_text){

          $data = array(
            'name' => 'clearance[]',
            'id' => $c,
            'value' => $c,
            'checked' => FALSE,
            'class' => 'form-check-input'
          );

          echo '<div class="form-check">';
          echo form_label(form_checkbox($data) . $label_text, $c.'-label', array('for' => $c));
          echo '</div>';
        }
        ?>
      </div>
      <br>


      <!-- Submit Button -->
      <?php
      echo form_input(array('type'=>'submit','value'=>'Submit', 'class'=> 'btn btn-primary float-right'));
      echo form_close();
      ?>
    </div>
  </div>
</div>

<script type="text/javascript">

$(function () {
  // Put User in the first input field when page loads
  $("#banner_id").focus();
});

function validateForm(){

  // Grab all input fields
  var fBanner = document.getElementById("banner_id").value;
  var fName = document.getElementById("name").value;
  var fEmail = document.getElementById("email").value;
  var fPhone = document.getElementById("phone").value;
  var fOwed = document.getElementById("amount_owed").value;

  // check if any input fields are empty
  if(fBanner == ""){
    alert("Banner ID cannot be empty");
    return false;
  }else if(fName == ""){
    alert("Name cannot be empty");
    return false;
  }else if(fEmail == ""){
    alert("Email cannot be empty");
    return false;
  }else if(fPhone == ""){
    alert("Phone cannot be empty");
    return false;
  }else if(fOwed == ""){
    alert("Amount Owed cannot be empty");
    return false;
  }
}

$(document).ready(function(){
  var $regexname = '((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}';
  $("#banner_id").focus(function() {
    // user click into the text box
    console.log('in');
  }).blur(function() {
    // user clicks out of thetext box
    $(this).val($(this).val().replace($regexname, ''));
    console.log('out');
  });

  $("#phone").focus(function() {
    // user click into the text box
    console.log('in');
  }).blur(function() {
    // user clicks out of thetext box
    $(this).val($(this).val().replace($regexname, ''));
    console.log('out');
  });

});
</script>
