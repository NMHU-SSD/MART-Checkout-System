<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add New Clearance Level</h1>
      <br>
      <?php echo form_open('clearance/add'); ?>

      <!-- Clearance Level Input and Label -->
      <div class="form-group">
        <label for="clearance" class="control-label">Clearance Level</label>
        <?php
        echo form_input(array('id'=>'clearance', 'name'=>'clearance', 'value'=>set_value('clearance'), 'class'=>'form-control'));  ?>
        <span class="text-danger"><?php echo form_error('clearance');?></span>
      </div>

      <!-- Barcode Input and Label -->
      <div class="form-group">
        <label for="barcode" class="control-label">Barcode</label>
        <?php
        echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>set_value('barcode'), 'class'=>'form-control', 'autocomplete' => 'off', 'type' => 'text'));
        ?>
        <span class = "text-danger"><?php echo form_error('barcode');?></span>
      </div>

      <!-- Description Input and Label -->
      <div class="form-group">
        <label for="description" class="control-label">Description</label>
        <?php
        echo form_input(array('id'=>'description', 'name'=>'description', 'value'=>set_value('description'), 'class'=>'form-control'));
        ?>
        <span class = "text-danger"><?php echo form_error('description');?></span>
      </div>

      <!-- Class Input and Label -->
      <div class="form-group">
        <label for="class" class="control-label">Class</label>
        <?php
        echo form_textarea(array('id'=>'class', 'name'=>'class', 'value'=>set_value('class'), 'class'=>'form-control'));  ?>
        <span class="text-danger"><?php echo form_error('class');?></span>
      </div>

      <?php
      echo form_submit(array('id'=>'submit','value'=>'Add', 'class'=>'btn btn-primary'));
      echo form_close();
      ?>
    </div>
  </div>
</div>

<script type="text/javascript">
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
