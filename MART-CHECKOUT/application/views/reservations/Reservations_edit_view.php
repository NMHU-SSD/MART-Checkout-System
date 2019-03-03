<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">

      <h1>Edit Reservation</h1>
      <br>
      <?php
      echo form_open('Reservations/update/'.$records->id, 'onsubmit="return validateForm()"');
      echo form_hidden('old_id', $records->id);
      ?>

      <!-- Barcode -->
      <div id="equipment" class="form-group">
        <label class="control-label">Equipment</label>
        <div class="input-group">
           <?php
           echo form_input(array('id'=>'barcode0','name'=>'barcode', 'value'=>set_value('barcode[]'), 'class' => 'form-control barcode', 'autocomplete' => 'off', 'type' => 'text'));
           ?>
           <button id="addBtn" class="btn btn-primary ml-2" type="button">
             <i class="fas fa-plus"></i>
           </button>
           <span class = "text-danger"><?php echo form_error('barcode[]');?></span>
           <label class="errorBarcode0" id="error" name="error"  style="display: none; color: red">Barcode does not exist</label>
        </div>
      </div>

      <!-- Student ID -->
      <div class="form-group">
        <label for="student_id" class="control-label">Banner ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'banner_id','name'=>'banner_id', 'value'=>$records->banner_id, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'text'));
          ?>
        </div>
        <span class = "text-danger"><?php echo form_error('student_id');?></span>
        <label id="errorID" name="errorID"  style="display: none;"><font color="red">ID does not exist</font></label>
      </div>


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

      <!-- Notes -->
      <div class="form-group">
        <label for="notes" class="control-label">Notes</label>
        <?php
        echo form_textarea(array('id'=>'notes','name'=>'notes', 'value'=>$records->notes,'class'=>'form-control', 'rows' => '4'));
        ?>
      </div>

      <!-- Checked Out Checkbox -->
      <!-- <div class="form-group">
        <label for="checkedout" class="control-label">Checked Out</label>
        <?php
        if($records->isCheckedOut == FALSE){
          echo form_checkbox(array('id' => 'checkedout', 'name' => 'checkedout', 'value' => 'true', 'checked' => FALSE));
        }else{
          echo form_checkbox(array('id' => 'checkedout', 'name' => 'checkedout', 'value' => 'true', 'checked' => TRUE));
        }
        ?>
      </div> -->

      <!-- Submit Button -->
      <div class="form-group">
        <?php
        echo form_submit(array('type'=>'submit','value'=>'Update', 'class' => 'btn btn-primary float-right'));
        echo form_close();
        ?>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

//incrementer for multiple inputs
var increment = 0;

//barcode0
$(function () {
  // Put User in the first input field when page loads
  $("#barcode"+increment).focus();
});

$("#barcode"+increment).on('click', function(event){
  event.stopPropagation();
  event.stopImmediatePropagation();
  console.log("clicked:"+this.id+", value:"+this.value);
  var val = (this.value).trim();
  var isEmpty = val === ""; //check for empty input

  if (!isEmpty){
    checkBarcode(val);////check barcode
  }

});

//barcode 1+
$("#addBtn").click(function(){
    increment += 1;

    $('#equipment').append("<div class='input-group mt-2'><input id='barcode"+increment+"' name='barcode[]' class='form-control barcode' type='text'><button id='minus"+increment+"' class='btn btn-primary ml-2 minus-btn' type='button'><i class='fas fa-minus'></i></button></div>");
    //jump to next input
    $("#barcode"+increment).focus();

    //barcode1+ click
    $("#barcode"+increment).on('click', function(event){
      event.stopPropagation();
      event.stopImmediatePropagation();
      console.log("clicked:"+this.id+", value:"+this.value);
      var val = (this.value).trim();
      var isEmpty = val === ""; //check for empty input

      if (!isEmpty){
        checkBarcode(val);////check barcode
      }

    });
    $(".minus-btn").on('click', function(event){
      event.stopPropagation();
      event.stopImmediatePropagation();
      $( this ).parent().remove();
    });
});

// class barcode enter key pressed
$(".barcode").keypress(function (event) {
  if (event.keyCode === 10 || event.keyCode === 13) {
    // stop event
    event.preventDefault();
    // go to the next of the input field
    $(this).focus();
  }
});

//check for valid and available equipment
function checkBarcode(barcode){
  console.log(barcode);
  //make request
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>reservations/valid_barcode/",
    data: "barcode="+barcode,
    success:function(response){
      console.log(response);
    },
    error: function(err) {
      console.log(err);
    }
  });

}

//check banner id
$("#banner_id").on('click', function(event){
  event.stopPropagation();
  event.stopImmediatePropagation();
  console.log("clicked:"+this.id+", value:"+this.value);

  var val = (this.value).trim();
  var isEmpty = val === ""; //check for empty input

  if (!isEmpty){
    check_BannerID(val);////check barcode
  }

});

//check for valid and available equipment
function check_BannerID(id){
  console.log(id);

  //make request
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>reservations/valid_bannerid/",
    data: "banner_id="+id,
    success:function(response){
      console.log(response);
    },
    error: function(err) {
      console.log(err);
    }
  });

}

function validateForm() {
  //barcodes_array
  var barcode_inputs = document.getElementsByClassName("barcode");
  var barcodes_array = [];

  for (var i = 0; i < barcode_inputs.length; i++){
    var isEmpty = barcode_inputs[i].value === "";

    if (!isEmpty){
      barcodes_array[i] = barcode_inputs[i].value;
    }
  }

}

</script>


<!-- datetimepicker -->
<link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap-datetimepicker/css/tempusdominus-bootstrap-4.min.css' ?>">
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/jquery/jquery-3.3.1.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/moment/moment-with-locales.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/moment/moment-timezone.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/js/tempusdominus-bootstrap-4.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/edit-datetimepicker.js'; ?>"></script>
