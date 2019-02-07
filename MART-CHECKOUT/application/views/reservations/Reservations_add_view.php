<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add a New Reservation</h1>
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
      ?>

      <div id="form" class="form-group">
        <?php
        echo form_open('reservations/add', 'onsubmit="return validateForm()"');
        echo form_label('Equipment Barcode');
        echo form_input(array('id'=>'barcode','name'=>'barcode[]', 'value'=>set_value('barcode[]'), 'class' => 'form-control inpVal', 'autocomplete' => 'off', 'type' => 'text'));
        ?>
        <span class = "text-danger"><?php echo form_error('barcode');?></span>
        <label class="cError" id="errorBarcode1" name="errorBarcode1"  style="display: none; color: red">Barcode does not exist</label>
      </div>

      <button type="button" id="addInput" class="btn btn-outline-secondary btnAddBar" style="display: none">Add Another Barcode</button>
      <br><br>
      <!-- Student ID -->
      <div class="form-group">
        <label for="student_id" class="control-label">Student ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'student_id','name'=>'student_id', 'value'=>set_value('student_id'), 'class' => 'form-control inpVal', 'autocomplete' => 'off', 'type' => 'text'));
          // echo form_dropdown('student_id"'.'class="form-control', $new_id);
          ?>
        </div>
        <span class = "text-danger"><?php echo form_error('student_id');?></span>
      </div>
      <label id="errorID" name="errorID"  style="display: none;"><font color="red">ID does not exist</font></label>


      <!-- Date Pickers -->
      <div class='row'>
        <!-- Pickup Date -->
        <div class='col-md-6'>
          <div class="form-group">
            <?php echo form_label('Pickup Date'); ?>
            <div class="input-group date" id="start" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#start" name="date_pickup" id="date_pickup" value="<?php echo set_value('date_pickup'); ?>"/>
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
              <input type="text" class="form-control datetimepicker-input" data-target="#end" name="date_due" id="date_due" value="<?php echo set_value('date_due'); ?>"/>
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

      <!-- <?php
      echo form_label('Pickup Date');
      echo form_input(array('id'=>'date_pickup','name'=>'date_pickup', 'type'=>"datetime-local", 'value'=>set_value('date_pickup'), 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('date_pickup');?></span>
      <br>

      <?php
      echo form_label('Due Date');
      echo form_input(array('id'=>'date_due','name'=>'date_due', 'value'=>set_value('date_due'), 'type'=>"datetime-local", 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('date_due');?></span>
      <br> -->

      <!-- Notes -->
      <?php
      echo form_label('Notes');
      echo form_textarea(array('id'=>'notes','name'=>'notes', 'value'=>set_value('notes'),'class' => 'form-control'));
      ?>
      <br>

      <!-- Submit Button -->
      <?php
      echo form_submit(array('type'=>'submit','value'=>'Add', 'class'=> 'btn btn-primary'));
      echo form_close();
      ?>
    </div>
  </div>
</div>

<!-- datetimepicker CDN -->
<!--
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha18/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha18/css/tempusdominus-bootstrap-4.min.css" /> -->

<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/jquery/jquery-3.3.1.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/moment/moment-with-locales.js'; ?>"></script>

<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/js/tempusdominus-bootstrap-4.min.js'; ?>"></script>

<script type="text/javascript">
$(function () {

  $('#start').datetimepicker({
    daysOfWeekDisabled: [0, 6],
    icons: {
      time: "fas fa-clock",
      date: "fas fa-calendar-alt",
      up: "fas fa-arrow-up",
      down: "fas fa-arrow-down"
    },
    minDate: moment(),
    enabledHours: [ 9, 10, 11, 12, 13, 14, 15, 16, 17] //9 - 5
  });
  $('#end').datetimepicker({
    daysOfWeekDisabled: [0, 6],
    icons: {
      time: "fas fa-clock",
      date: "fas fa-calendar-alt",
      up: "fas fa-arrow-up",
      down: "fas fa-arrow-down"
    },
    enabledHours: [ 9, 10, 11, 12, 13, 14, 15, 16, 17], //9 - 5
    minDate: moment(),
    useCurrent: false //Important! See issue #1075
  });
  $("#start").on("dp.change", function (e) {
    $('#due').data("DateTimePicker").minDate(e.date);
  });
  $("#end").on("dp.change", function (e) {
    $('#pickup').data("DateTimePicker").maxDate(e.date);
  });
  // Put User in the first input field when page loads
  $("#barcode").focus();
});


// set studentIDs and equipment barcodes for validating input fields
var studentID=<?php echo json_encode($new_id); ?>;
var equipBar=<?php echo json_encode($new_barcode); ?>;
console.log(equipBar);

// var for created input
var btnClick = 2;
var temp = 1;

// variables for validating input fields
var isStudentID = false;
var isEquipBar = false;
var isArrEquipBar = [];
var inputValues = [];

// regular expressions for input fields
// regex allows capital letters, numbers, dashes, and underscores
var regexBarcode = /[^A-Z0-9\-\_]/g;
// regex allows numbers
var regexID = /[^0-9]/g;

// TODO: Added input fields do not post the the database
// NOTE: Only the first input(Not generated) get posted to database
// Create input and label when add another barcode
$("#addInput").click(function(){
  temp++;
  $(".btnAddBar").hide();
  $('<div id="tempBarcode'+btnClick+'"></div>').append(
    $('<input id="barcode'+btnClick+'" name="barcode[]" class="form-control cBarcode inpVal" type="text" autocomplete="off"></input>').blur(function(){

      // Get value of input field and compare to regex and if not met clear field
      $(this).val($(this).val().replace(regexBarcode, ''));
      // check input value is in the array of equipBar arrat
      var checkBarcode = equipBar.hasOwnProperty($(this).val());

      // current inputs id
      temp = $(this).attr('id').slice(-1);
      var name = $(this).val();

      // loop through all elements with cError class
      $('.cError').each(function(i,obj){

        // name if so we can break
        // get id and get last character and compare to temp
        checkBar: if(obj['id'].slice(-1) == temp){
          // set index to false so there are not any correct barcodes
          isArrEquipBar[parseInt(temp) - 2] = false;

          // Set index to name so there are no duplications
          inputValues[parseInt(temp) - 1] = name;

          // Check if barcodes are the same
          for(var j = 0; j < inputValues.length; j++){
            if(inputValues[parseInt(temp) - 1] ==  inputValues[j] && (parseInt(temp) - 1) != j){
              alert("Barcodes are the same.");
              break checkBar;
            }
          }
          // if barcode doesn't exist
          if( checkBarcode == false){
            // shoe label, hide button, and in array set to false
            obj['style']['display'] = '';
            $(".btnAddBar").hide();
            isArrEquipBar[parseInt(temp) - 2] = false;
          }else{ // if barcode is valid
            // hide label, show button, and set array index to true
            obj['style']['display'] = 'none';
            $(".btnAddBar").show();
            isArrEquipBar[parseInt(temp) - 2] = true;
          }
        }
      })
    })
  ).appendTo('#form');
  // Make delete button
  $('#tempBarcode'+btnClick).append('<button type="button" id="deleteBarcode'+btnClick+'" class="btn btn-outline-secondary delBtn " style="display: inline-block;">X</button>');
  // button click of class delBtn
  $(".delBtn").click(function(e){
    // Get id of button clicked
    var idClicked = e.target.id;
    // get last index of button
    var btnID = idClicked.slice(-1);

    var delBarVal = $("#barcode"+btnID).val();
    // delete input, label, and button
    document.getElementById("tempBarcode"+btnID).remove();
    // edit arrays
    for( var i = 0; i < inputValues.length; i++){
      if ( inputValues[i] === delBarVal) {
        inputValues.splice(i, 1);
        isArrEquipBar.splice((i-1),1);
      }
    }
    // inputValues[btnID - 1] = name;
    // isArrEquipBar[btnID - 2] = true;
    $(".btnAddBar").show();
  });

  // if user goes into input field
  $("#barcode" + btnClick).click(function(e){

    var currBarID = e.target.id.slice(-1);
    // if barcode is valid
    if(isArrEquipBar[currBarID-2] == true){
      // shoe dialog
      if (confirm("Are you sure that you want to change "+ currBarID + " Equipment Barcode?")) {
        $(this).val("");
      } else {
        $(this).blur();
      }
    }
  });

  // Make barcide
  $('#tempBarcode'+btnClick).append('<label class="cError" id="errorBarcode'+btnClick+'" name="errorBarcode'+btnClick+'"  style="display: none; color: red">Barcode does not exist</label>');
  btnClick++;
});

// Click into student id input
$("#student_id").focus(function(){
  // if barcode is valid
  if(isStudentID == true){
    // Show dialog asking if they want to enter another ID
    if (confirm("Are you sure that you want to change StudentID?")) {
      // is yes, erase current text
      $(this).val("");
    } else {
      // if false kick them out of the input field
      $(this).blur();
    }
  }
});

// user clicks out of input field
$("#student_id").blur(function() {
  // compare input value to rexeg
  $(this).val($(this).val().replace(regexID, ''));
  // check if input value has a valid id
  var checkID = studentID.hasOwnProperty($(this).val());
  // if ID doesn't exist
  if(checkID == false){
    $("#errorID").show();
    isStudentID = false;
  }else{// if id does esist
    $("#errorID").hide();
    isStudentID = true;
  }
});

// if user goes into input field
$("#barcode").focus(function(){
  // if barcode is valid
  if(isEquipBar == true){
    // shoe dialog
    if (confirm("Are you sure that you want to change Equipment Barcode?")) {
      $(this).val("");
    } else {
      $(this).blur();
    }
  }
});

// input that isn't created
$("#barcode").blur(function() {
  // user clicks out of thetext box
  $(this).val($(this).val().replace(regexBarcode, ''));
  // check if text box is not empty
  if($(this).val != ""){
    // cheif if equipBar array has input vlaue
    var checkBarcode = equipBar.hasOwnProperty($(this).val());

    // if it doesn't
    if(checkBarcode == false){
      // shoe error
      $("#errorBarcode1").show();
      // if only equipment input
      if(isArrEquipBar.length == 0){
        // hide button
        $(".btnAddBar").hide();
      }
      // set to false
      isEquipBar = false;
      // add value to array
      inputValues[0] = $(this).val();
    }else{ // if barcode is valid
      // hide error label
      $("#errorBarcode1").hide();
      if(isArrEquipBar.length == 0){
        $(".btnAddBar").show();
      }
      isEquipBar = true;
      inputValues[0] = $(this).val();
    }
  }
});

// class inVal enter key pressed
$(".inpVal").keypress(function (event) {
  if (event.keyCode === 10 || event.keyCode === 13) {
    // stop event
    event.preventDefault();
    // kick them out of the input field
    $(this).blur();
  }
});


var curTemp = new Date(currentDate());
// validate the form before submit
function validateForm() {
  // input values
  var equipBarcode = document.getElementById("barcode").value;
  var arrEquipBar = [];
  var sID = document.getElementById("student_id").value;
  var dPickup = document.getElementById("date_pickup").value;
  var dDue = document.getElementById("date_due").value;

  // make new date objects from pickup, due, and current date
  var pTemp = new Date(dPickup);
  var dTemp = new Date(dDue);

  // Check if any input fields are empty
  if (equipBarcode == "") {
    alert("Equipment id must be filled out");
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
  if((pTemp>=curTemp) === false){
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

  // only loop through generated barcodes if there are some
  if(arrEquipBar.length > 0){
    // loop through all elements with cBarcode class
    // NOTE: starts at new generated buttons
    $('.cBarcode').each(function(i,obj){
      console.log(obj['id']);
      arrEquipBar.push(document.getElementById(obj['id']).value);
    });

    for(var i = 0; i < arrEquipBar.length; i++){
      // check if current input has text in them
      if(arrEquipBar[i] == ""){
        alert((i+2) + " Equipment id must be filled out");
        return false;
      }

      // check if current input has valid equipment barcode
      if(isArrEquipBar[i] == false){
        alert("Enter a valid Equipment Barcode on " + (i+2));
        return false;
      }
    }
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
