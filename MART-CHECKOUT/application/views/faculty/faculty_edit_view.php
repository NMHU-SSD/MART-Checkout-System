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

      echo form_open('faculty/update/'.$records->banner_id, 'onsubmit="return validateForm()"');
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
          echo form_input(array('id'=>'banner_id', 'name'=>'banner_id', 'value'=>$records->banner_id, 'class' => 'form-control', 'autocomplete' => 'off' ,'readonly' => TRUE));
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
      echo form_input(array('id'=>'email','name'=>'email', 'value'=>$records->email, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'email'));
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

      <div class="form-group">
        <label for="clearance">Select Clearance Level</label><br>
        <?php

        $clearance_names = array();
        // New array with key clearance id and value clearance level
        foreach ($clearance_options as $c) {
          $clearance_names[$c->id] = $c->name;
        }

        // When editing recheck all boxes that were checked
        // seperate clearance numbers on ,
        $array = explode(",", $records->clearance);

        // loop through new clearance array
        foreach($clearance_names as $c=>$checkbox){
          // Loop through clearance numbers
          foreach($array as $p){
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
          echo form_label(form_checkbox($data) . $checkbox, $c.'-label', array('for' => $c));
          echo '</div>';
        }
        // complete form

        ?>
      </div>

      <!-- Amount Owed -->
      <!-- <?php
      echo form_label('Amount Owed');
      echo form_input(array('id'=>'amount_owed','name'=>'amount_owed', 'value'=>$records->amount_owed, 'readonly' => 'true', 'class' => 'form-control'));
      ?>
      <br> -->

      <!-- Enrollment Status -->
      <!-- <div class="form-group">
        <label for="active" class="control-label">Enrollment Status</label>
        <?php
        echo form_dropdown('active', $active_options, $records->enrollment );
        ?>
      </div> -->

      <!-- Eligibility Status -->
      <!-- <div class="form-group">
        <label for="eligible" class="control-label">Eligibility Status</label>
        <?php
        echo form_dropdown('eligible', $eligible_options, $records->eligibility );
        ?>
      </div> -->

      <!-- Submit Button -->
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
