<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Edit Reservation</h1>
      <br>
      <?php
      $new_id = array();
      $new_barcode = array();

      foreach ($results as $r) {
        $new_id[$r->banner_id] = $r->banner_id;
      }

      foreach ($equip as $e) {
        $new_barcode[$e->barcode] = $e->barcode;
      }

      echo form_open('Reservations/update/'.$records->barcode, 'onsubmit="return validateForm()"');
      echo form_hidden('old_barcode', $records->barcode);
      ?>

      <!-- Barcode -->
      <div class="form-group">
        <label for="barcode" class="control-label">Barcode</label>
        <?php
        echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>$records->barcode, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'text'));
        ?>
        <span class = "text-danger"><?php echo form_error('barcode');?></span>
        <label class="cError" id="errorBarcode1" name="errorBarcode1"  style="display: none; color: red">Barcode does not exist</label>
      </div>

      <!-- Student ID -->
      <div class="form-group">
        <label for="student_id" class="control-label">Student ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'student_id','name'=>'student_id', 'value'=>$records->student_id, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'text'));
          // echo form_dropdown('student_id"'.'class="form-control', $new_id);
          ?>
        </div>
        <span class = "text-danger"><?php echo form_error('student_id');?></span>
      </div>
      <label id="errorID" name="errorID"  style="display: none;"><font color="red">ID does not exist</font></label>


      <!-- Date Picker -->
      <div class='row'>
        <!-- Pickup Date -->
        <div class='col-md-6'>
          <div class="form-group">
            <?php echo form_label('Pickup Date'); ?>
            <div class="input-group date" id="start" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#start" data-toggle="datetimepicker" name="date_pickup" id="date_pickup" value="<?php echo $records->date_pickup; ?>" />
              <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                <div class="input-group-text">
                  <i class="fas fa-calendar-alt"></i>
                </div>
              </div>
              <span class = "text-danger"><?php echo form_error('date_pickup');?></span>
            </div>
          </div>
        </div>
        <!-- Due Date -->
        <div class='col-md-6'>
          <div class="form-group">
            <?php echo form_label('Due Date'); ?>
            <div class="input-group date" id="end" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#end" data-toggle="datetimepicker" name="date_due" id="date_due" value="<?php echo $records->date_due; ?>"/>
              <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                <div class="input-group-text">
                  <i class="fas fa-calendar-alt"></i>
                </div>
              </div>
              <span class = "text-danger"><?php echo form_error('date_due');?></span>
            </div>
          </div>
        </div>
      </div>


      <!-- <div class="form-group">
      <label for="date_pickup" class="control-label">Date Pickup</label>
      <?php
      echo form_input(array('id'=>'date_pickup','name'=>'date_pickup', 'value'=>$records->date_pickup, 'type'=>"datetime-local", 'class'=>'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('date_pickup');?></span>
    </div>
    <div class="form-group">
    <label for="date_due" class="control-label">Date Due</label>
    <?php
    echo form_input(array('id'=>'date_due','name'=>'date_due', 'value'=>$records->date_due,'type'=>"datetime-local", 'class'=>'form-control'));
    ?>
    <span class = "text-danger"><?php echo form_error('date_due');?></span>
  </div> -->

  <!-- Notes -->
  <div class="form-group">
    <label for="notes" class="control-label">Notes</label>
    <?php
    echo form_textarea(array('id'=>'notes','name'=>'notes', 'value'=>$records->notes,'class'=>'form-control'));
    ?>
  </div>

  <!-- Checked Out Checkbox -->
  <div class="form-group">
    <label for="checkedout" class="control-label">Checked Out</label>
    <?php
    if($records->isCheckedOut == FALSE){
      echo form_checkbox(array('id' => 'checkedout', 'name' => 'checkedout', 'value' => 'true', 'checked' => FALSE));
    }else{
      echo form_checkbox(array('id' => 'checkedout', 'name' => 'checkedout', 'value' => 'true', 'checked' => TRUE));
    }
    ?>
  </div>

  <!-- Submit Button -->
  <div class="form-group">
    <?php
    echo form_submit(array('type'=>'submit','value'=>'Update', 'class' => 'btn btn-primary'));
    echo form_close();
    ?>
  </div>

</div>
</div>
</div>

<script type="text/javascript">

$(function () {
  // Put User in the first input field when page loads
  $("#barcode").focus();
});


// set studentIDs and equipment barcodes for validating input fields
var studentID=<?php echo json_encode($new_id); ?>;
var equipBar=<?php echo json_encode($new_barcode); ?>;

// variables for validating input fields
var isStudentID = true;
var isEquipBar = true;

// regular expressions for input fields
// regex allows capital letters, numbers, dashes, and underscores
var regexBarcode = /[^A-Z0-9\-\_]/g;
// regex allows numbers
var regexID = /[^0-9]/g;

$("#student_id").blur(function() {
  // user clicks out of thetext box
  $(this).val($(this).val().replace(regexID, ''));
  var checkID = studentID.hasOwnProperty($(this).val());
  if(checkID == false){
    $("#errorID").show();
    isStudentID = false;
  }else{
    $("#errorID").hide();
    isStudentID = true;
  }
});

// input that isn't created
$("#barcode").blur(function() {
  // user clicks out of thetext box
  $(this).val($(this).val().replace(regexBarcode, ''));
  // check if text box is not empty
  if($(this).val != ""){
    var checkBarcode = equipBar.hasOwnProperty($(this).val());
    if(checkBarcode == false){
      $("#errorBarcode1").show();
      isEquipBar = false;
    }else{
      $("#errorBarcode1").hide();
      isEquipBar = true;
    }
  }
});

// validate the form before submit
function validateForm() {

  // input values
  var equipBarcode = document.getElementById("barcode").value;
  var sID = document.getElementById("student_id").value;
  var dPickup = document.getElementById("date_pickup").value;
  var dDue = document.getElementById("date_due").value;

  // make new date objects from pickup, due, and current date
  var pTemp = new Date(dPickup);
  var dTemp = new Date(dDue);
  var curTemp = new Date(currentDate());

  // Check if any input fields are empty
  if (equipBarcode == "") {
    alert("Barcode must be filled out");
    return false;
  }else if (sID == "") {
    alert("Student id must be filled out");
    return false;
  }else if (dPickup == "") {
    alert("A pickup date must be selected");
    return false;
  }else if (dDue == "") {
    alert("A due date must be selected");
    return false;
  }

  // Check if dates are valid
  if((pTemp>curTemp) === false){
    alert("Pickup date cannot be before todays date");
    return false;
  }else if((dTemp>pTemp) === false){
    alert("Due date cannot be before Pickup date");
    return false;
  }

  // Check if student id is a valid id
  if(isStudentID == false){
    alert("Enter a valid Student ID");
    return false;
  }

  // Check if the first equipment barcode is a valid barcode
  if(isEquipBar == false){
    alert("Enter a valid Equipment Barcode");
    return false;
  }
}

// Get current date nad time in 01/26/2019 9:42 AM format
// Code from: https://stackoverflow.com/a/4929629
function currentDate(){
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!

  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd;
  }

  if (mm < 10) {
    mm = '0' + mm;
  }

  // Code from: https://stackoverflow.com/a/36822046
  var currentTime = today.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })

  var today = mm + '/' + dd + '/' + yyyy + " " + currentTime;
  return today;
}

</script>
