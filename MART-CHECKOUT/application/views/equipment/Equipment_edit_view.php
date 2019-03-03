<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Edit Equipment</h1>
      <br>
      <?php

        echo form_open('Equipment/update/'.$record->barcode, 'onsubmit="return validateForm()"');
        echo form_hidden('old_barcode', $record->barcode);

        ?>

        <div class="form-group">
          <label for="barcode" class="control-label">Barcode</label>
          <?php
          echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>$record->barcode, 'class'=>'form-control', 'autocomplete' => 'off', 'type' => 'text', 'style'=>"text-transform: uppercase"));
          ?>
          <span class = "text-danger"><?php echo form_error('barcode');?></span>
        </div>

        <div class="form-group">
          <label for="name" class="control-label">Name</label>
          <?php
          echo form_input(array('id'=>'name', 'name'=>'name', 'value'=>$record->name, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('name');?></span>
        </div>

        <div class="form-group">
          <label for="description" class="control-label">Description</label>
          <?php
          echo form_input(array('id'=>'description', 'name'=>'description', 'value'=>$record->description, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('description');?></span>
        </div>


        <div class="form-group">
          <label for="notes" class="control-label">Notes</label>
          <?php
          echo form_textarea(array('id'=>'notes',  'name'=>'notes', 'value'=>$record->notes, 'class'=>'form-control', 'rows'=>'4'));
          ?>
          <span class = "text-danger"><?php echo form_error('notes');?></span>
        </div>

        <!-- Purchased From -->

        <div class="form-group">
          <label for="account_purchased_from" class="control-label">Account Purchased From</label>
          <?php
          echo form_input(array('id'=>'account_purchased_from', 'name'=>'account_purchased_from', 'value'=>$record->purchase_account, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('account_purchased_from');?></span>
        </div>

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
          $array = explode(",", $record->clearance);

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


        <!-- CHECK Status of Item-->

        <!-- Status -->
        <div class="form-group">
          <label for="form_status" class="control-label">Status</label>

          <!-- helper function to generate select form field with options -->
          <?php

          echo form_dropdown('form_status', $states, $status, 'class="form-control"');

          ?>

          <span class="text-danger"><?php echo form_error('form_status'); ?></span>
        </div>

        <?php

        echo form_submit(array('id'=>'submit','value'=>'Update', 'class'=>'btn btn-primary float-right'));
        echo form_close();
        ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">

  $(function () {
    // Put User in the first input field when page loads
    $("#barcode").focus();
  });

  function validateForm(){
    var fBarcode = document.getElementById("barcode").value;
    var fName = document.getElementById("name").value;
    var fDesc = document.getElementById("description").value;

    if(fBarcode == ""){
      alert("Barcode cannot be empty");
      return false;
    }else if(fName == ""){
      alert(" Name cannot be empty");
      return false;
    }else if(fDesc == ""){
      alert("Description cannot be empty");
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
  //  $(this).val($(this).val().replace(regexBarcode, ''));
    console.log('out');
  });
  </script>
