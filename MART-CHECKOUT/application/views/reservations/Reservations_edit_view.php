<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Edit Reservation</h1>
      <br>
      <?php
      $new_id = array();

      foreach ($results as $r) {
        $new_id[$r->banner_id] = $r->banner_id;
      }

      echo form_open('Reservations/update/'.$records->barcode);
      echo form_hidden('old_barcode', $records->barcode);
      ?>

      <!-- Barcode -->
      <div class="form-group">
        <label for="barcode" class="control-label">Barcode</label>
        <?php
        echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>$records->barcode, 'class' => 'form-control', 'autocomplete' => 'off', 'type' => 'text'));
        ?>
        <span class = "text-danger"><?php echo form_error('barcode');?></span>
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

var something=<?php echo json_encode($new_id); ?>;
console.log(typeof something);
console.log(something);

var regexID = /[^0-9]/g;
$("#student_id").focus(function() {
  // user click into the text box
  console.log('in');
}).blur(function() {
  // user clicks out of thetext box
  $(this).val($(this).val().replace(regexID, ''));
  console.log('out');
  var checkID = something.hasOwnProperty($(this).val());
  if(checkID == false){
    $("#errorID").show();
  }else{
    $("#errorID").hide();
  }

  console.log(checkID);
});

// regex allows capital letters, numbers, dashes, and underscores
var regexBarcode = /[^A-Z0-9\-\_]/g;
$("#barcode").focus(function() {
  // user click into the text box
  console.log('in');
}).blur(function() {
  // user clicks out of thetext box
  $(this).val($(this).val().replace(regexBarcode, ''));
  console.log('out');
});
</script>
