<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add a New Reservation</h1>
      <br>
      <?php
      echo form_open('reservations/add', 'onsubmit="return validateForm()" autocomplete="off" ');
      ?>

      <div id="equipment" class="form-group">
        <label class="control-label">Equipment</label>

        <div class="input-group">
           <?php
           echo form_input(array('id'=>'barcode0','name'=>'barcode[]', 'value'=>set_value('barcode[]'), 'class' => 'form-control barcode', 'autocomplete' => 'off', 'type' => 'text'));
           ?>
           <button id="addBtn" class="btn btn-primary ml-2" type="button">
             <i class="fas fa-plus"></i>
           </button>
           <br>
        </div>
        <?php echo form_error('barcode[]', '<span id="barcode_error" class="text-danger">', '</span>');?>

      </div>

      <!-- ID -->
      <div class="form-group">
        <label for="banner_id" class="control-label">Student/Faculty Banner ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'banner_id','name'=>'banner_id', 'value'=>set_value('banner_id'), 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'text'));
          ?>
        </div>
        <?php echo form_error('banner_id', '<span id="banner_error" class="text-danger">', '</span>');?>
      </div>

      <!-- Date Picker -->
      <div class='row'>
        <!-- Pickup Date -->
        <div class='col-md-6'>
          <div class="form-group">
            <?php echo form_label('Pickup Date'); ?>
            <div class="input-group date" id="start" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#start" data-toggle="datetimepicker" name="date_pickup" id="date_pickup" value="<?php echo set_value('date_pickup'); ?>" />
              <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                <div class="input-group-text">
                  <i class="fas fa-calendar-alt"></i>
                </div>
              </div>
              <span class="text-danger"><?php echo form_error('date_pickup');?></span>
            </div>
          </div>
        </div>
        <!-- Due Date -->
        <div class='col-md-6'>
          <div class="form-group">
            <?php echo form_label('Due Date'); ?>
            <div class="input-group date" id="end" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#end" data-toggle="datetimepicker" name="date_due" id="date_due" value="<?php echo set_value('date_due') ?>"/>
              <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                <div class="input-group-text">
                  <i class="fas fa-calendar-alt"></i>
                </div>
              </div>
              <span class="text-danger"><?php echo form_error('date_due');?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Notes -->
      <div class="form-group">
      <?php
      echo form_label('Notes');
      echo form_textarea(array('id'=>'notes','name'=>'notes', 'value'=>set_value('notes'),'class' => 'form-control', 'rows' => '4'));
      ?>
      </div>

      <br>

      <div class="form-group">
      <!-- Submit Button -->
      <?php
      echo form_submit(array('type'=>'submit','value'=>'Submit', 'class'=> 'btn btn-primary float-right'));
      echo form_close();
      ?>
      </div>

    </div>
  </div>
</div>



<!-- datetimepicker -->
<link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap-datetimepicker/css/tempusdominus-bootstrap-4.min.css' ?>">
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/jquery/jquery-3.3.1.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/moment/moment-with-locales.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/moment/moment-timezone.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/js/tempusdominus-bootstrap-4.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/bootstrap-datetimepicker/add-datetimepicker.js'; ?>"></script>



<script type="text/javascript">

var isValid = true;

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
      var data = JSON.parse(response);
      if (data[0] == false){
        isValid = false;
      }
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
  isValid = true;
  //barcodes_array
  var barcode_inputs = document.getElementsByClassName("barcode");
  var barcodes_array = [];

  for (var i = 0; i < barcode_inputs.length; i++){
    var val = (barcode_inputs[i].value).trim();
    var isEmpty = val === "";

    if (!isEmpty){
      barcodes_array[i] = val;
    }

  }

  for (var i = 0; i < barcodes_array.length; i++){
    checkBarcode(barcodes_array[i]);

  }

  //return isValid;


}

</script>
