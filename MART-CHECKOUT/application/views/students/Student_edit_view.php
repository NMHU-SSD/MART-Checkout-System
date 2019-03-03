<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">

      <h1>Edit Student</h1>
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

      echo form_open('students/update/'.$records->banner_id, 'onsubmit="return validateForm()"');
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
          echo form_input(array('id'=>'banner_id', 'name'=>'banner_id', 'value'=>$records->banner_id, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'text'));
          ?>

        </div>
        <span class="text-danger"><?php echo form_error('banner_id'); ?></span>
      </div>

      <?php
      echo form_label('Name');
      echo form_input(array('id'=>'name','name'=>'name', 'value'=>$records->name, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('name');?></span>
      <br>

      <?php
      echo form_label('Email');
      echo form_input(array('id'=>'email','name'=>'email', 'value'=>$records->email, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'email'));
      ?>
      <span class = "text-danger"><?php echo form_error('email');?></span>
      <br>

      <?php
      echo form_label('Phone');
      echo form_input(array('id'=>'phone','name'=>'phone', 'value'=>$records->phone, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('phone');?></span>

      <br>

      <div class="form-group">
        <label for="active" class="control-label">Enrollment Status</label>
        <?php
        echo form_dropdown('active', $active_options, $records->enrollment , "class='form-control'");
        ?>
      </div>

      <div class="form-group">
        <label for="eligible" class="control-label">Eligibility Status</label>
        <?php
        echo form_dropdown('eligible', $eligible_options, $records->eligibility , "class='form-control'");
        ?>
      </div>

      <?php
      echo form_label('Amount Owed');
      echo form_input(array('id'=>'amount_owed','name'=>'amount_owed', 'value'=>$records->amount_owed, 'class' => 'form-control'));
      ?>


      <br>

      <div class="form-group">
        <label for="clearance">Select Clearance Level</label><br>
        <?php

        $new_clear = array();
        // New array with key clearance id and value clearance level
        foreach ($clearance_options as $options) {
          $new_clear[$options->id] = $options->name;
        }
        // When editing recheck all boxes that were checked
        // temp var
        $temp = "";
        // seperate clearance numbers on ,
        $pieces = explode(",", $records->clearance);

        // loop through new clearance array
        foreach($new_clear as $c=>$label_text){
          // Loop through clearance numbers
          foreach($pieces as $p){
            // If clearance number is equal to clearance
            if((int)$p == $c){
              // make new data array with box checked
              $data = array(
                'name' => 'clearance[]',
                'id' => $c,
                'value' => $c,
                'checked' => TRUE,
                'class' => 'form-check-input'
              );
              // break out of loop if found
              break;
            }else{
              $data = array(
                'name' => 'clearance[]',
                'id' => $c,
                'value' => $c,
                'checked' => FALSE,
                'class' => 'form-check-input'
              );
            }
          }

          // make checkbox
          echo '<div class="form-check">';
          echo form_label(form_checkbox($data) . $label_text, $c.'-label', array('for' => $c));
          echo '</div>';
        }
        // complete form
        ?>
      </div>
      <br>
      <?php
      echo form_input(array('type'=>'submit','value'=>'Update', 'class'=> 'btn btn-primary float-right'));
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
  var $regexname = /[^0-9]/g;
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
