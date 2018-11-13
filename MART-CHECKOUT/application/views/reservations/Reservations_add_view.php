<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add a New Reservation</h1>
      <br>

      <?php
      // $new_id = array();

      // foreach ($results as $r) {
      //   $new_id[$r->banner_id] = $r->banner_id;
      // }
      ?>

      <div id="form" class="form-group">
        <?php
        echo form_open('reservations/add');
        echo form_label('Equipment Barcode');
        echo form_input(array('id'=>'barcode','name'=>'barcode[]', 'value'=>set_value('barcode[]'), 'class' => 'form-control'));
        // echo form_input(array('id'=>'barcode','name'=>'barcode[]', 'value'=>set_value('barcode'), 'class' => 'form-control'));

        ?>
        <span class = "text-danger"><?php echo form_error('barcode');?></span>
      </div>
      <button type="button" class="btn btn-outline-secondary">Add Another Barcode</button>
      <br><br>
      <!-- Student ID -->
      <div class="form-group">
        <label for="student_id" class="control-label">Student ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <?php
          echo form_input(array('id'=>'student_id','name'=>'student_id', 'value'=>set_value('student_id'), 'class' => 'form-control'));
          // echo form_dropdown('student_id"'.'class="form-control', $new_id);
          ?>
        </div>
        <span class = "text-danger"><?php echo form_error('student_id');?></span>
      </div>

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
});


$(document).ready(function(){
  $("button").click(function(){
    // form_input(
    //   array(
    //     'id'=>'barcode',
    //     'name'=>'barcode[]',
    //     'value'=>set_value('barcode'),
    //     'class' => 'form-control'
    //   ));
    // alert("The paragraph was clicked.");
    $('<input>').attr({
      // type: 'hidden',
      id: 'barcode',
      name: 'barcode[]',
      value: "<?php set_value('barcode') ?>",
      class: 'form-control'
    }).appendTo('form');
  });
});
</script>
