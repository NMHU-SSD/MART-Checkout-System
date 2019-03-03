<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add New Clearance Level</h1>
      <br>
      <?php echo form_open('clearance/add', 'onsubmit="return validateForm()"'); ?>

      <!-- Clearance Level Input and Label -->
      <div class="form-group">
        <label for="clearance_name" class="control-label">Level Name</label>
        <?php
        echo form_input(array('id'=>'name', 'name'=>'clearance_name', 'value'=>set_value('clearance_name'), 'class'=>'form-control'));  ?>
        <span class="text-danger"><?php echo form_error('clearance_name');?></span>
      </div>

      <!-- Description Input and Label -->
      <div class="form-group">
        <label for="clearance_description" class="control-label">Description</label>
        <?php
        echo form_textarea(array('id'=>'description', 'name'=>'clearance_description', 'value'=>set_value('clearance_description'), 'class'=>'form-control', 'rows'=>'4'));
        ?>
        <span class = "text-danger"><?php echo form_error('clearance_description');?></span>
      </div>

      <!-- Class Input and Label -->
      <div class="form-group">
        <label for="clearance_courses" class="control-label">Courses</label>
        <?php
        echo form_textarea(array('id'=>'courses', 'name'=>'clearance_courses', 'value'=>set_value('clearance_courses'), 'class'=>'form-control', 'rows'=>'4'));  ?>
        <span class="text-danger"><?php echo form_error('clearance_courses');?></span>
      </div>

      <?php
      echo form_submit(array('id'=>'submit','value'=>'Submit', 'class'=>'btn btn-primary float-right'));
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
  var fClear = document.getElementById("name").value;
  var fDesc = document.getElementById("description").value;
  var fClass = document.getElementById("courses").value;

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
