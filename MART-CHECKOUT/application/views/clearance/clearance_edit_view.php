<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Edit Clearance</h1>
      <br>
      <?php
        echo form_open('clearance/update/'.$records->id, 'onsubmit="return validateForm()"');
        echo form_hidden('old_id', $records->id);
        ?>

        <div class="form-group">
          <label for="clearance" class="control-label">Clearance Level</label>
          <?php
          echo form_input(array('id'=>'clearance', 'name'=>'clearance', 'value'=>$records->level, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('clearance');?></span>
        </div>

        <div class="form-group">
          <label for="barcode" class="control-label">Equipment Barcode</label>
          <?php
          echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>$records->barcode, 'class'=>'form-control', 'autocomplete' => 'off', 'type' => 'text'));
          ?>
          <span class = "text-danger"><?php echo form_error('barcode');?></span>
        </div>

        <div class="form-group">
          <label for="description" class="control-label">Description</label>
          <?php
          echo form_input(array('id'=>'description', 'name'=>'description', 'value'=>$records->description, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('description');?></span>
        </div>

        <div class="form-group">
          <label for="class" class="control-label">Class</label>
          <?php
          echo form_textarea(array('id'=>'class',  'name'=>'class', 'value'=>$records->class, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('class');?></span>
        </div>


        <?php

        echo form_submit(array('id'=>'submit','value'=>'Update', 'class'=>'btn btn-primary'));
        echo form_close();
        ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">

  $(function () {
    // Put User in the first input field when page loads
    $("#clearance").focus();
  });

  function validateForm(){
    // Get input values
    var fClear = document.getElementById("clearance").value;
    var fBarcode = document.getElementById("barcode").value;
    var fDesc = document.getElementById("description").value;
    var fClass = document.getElementById("class").value;

    // Check input values
    if(fClear == ""){
      alert("Clearance Level cannot be empty");
      return false;
    } else if(fBarcode == ""){
      alert("Barcode cannot be empty");
      return false;
    }else if(fDesc == ""){
      alert("Description cannot be empty");
      return false;
    }else if(fClass == ""){
      alert("Class cannot be empty");
      return false;
    }

  }

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
