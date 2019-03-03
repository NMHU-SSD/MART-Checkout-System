<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add New Equipment</h1>
      <br>
      <?php

        echo form_open('equipment/add', 'onsubmit="return validateForm()"');
        ?>

        <!-- Barcode -->
        <div class="form-group">
          <label for="barcode" class="control-label">Barcode</label>
          <?php
          echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>set_value('barcode'), 'class'=>'form-control', 'autocomplete' => 'off', 'type' => 'text', 'style'=>"text-transform: uppercase"));
          ?>
          <span class = "text-danger"><?php echo form_error('barcode');?></span>
        </div>

        <!-- Item Name -->
        <div class="form-group">
          <label for="name" class="control-label">Product Name</label>
          <?php
          echo form_input(array('id'=>'name', 'name'=>'name', 'value'=>set_value('name'), 'class'=>'form-control'));
          ?>
          <span class="text-danger"><?php echo form_error('name');?></span>
        </div>

        <!-- Description -->
        <div class="form-group">
          <label for="description" class="control-label">Description</label>
          <?php
          echo form_textarea(array('id'=>'description', 'name'=>'description', 'value'=>set_value('description'), 'class'=>'form-control', 'rows'=>'4'));
          ?>
          <span class = "text-danger"><?php echo form_error('description');?></span>
        </div>

        <!-- Notes -->
        <div class="form-group">
          <label for="notes" class="control-label">Notes</label>
          <?php
          echo form_textarea(array('id'=>'notes', 'name'=>'notes', 'value'=>set_value('notes'), 'class'=>'form-control', 'rows'=>'4',));  ?>
          <span class="text-danger"><?php echo form_error('notes');?></span>
        </div>

        <!-- Purchased -->
        <div class="form-group">
          <label for="account_purchased_from" class="control-label">Account Purchased From</label>
          <?php
          echo form_input(array('id'=>'account_purchased_from', 'name'=>'account_purchased_from', 'value'=>set_value('account_purchased_from'), 'class'=>'form-control'));  ?>
          <span class = "text-danger"><?php echo form_error('account_purchased_from');?></span>
        </div>

        <!-- Clearance Level -->
        <div class="form-group">
          <label for="clearance">Select Clearance Level</label><br>
          <?php

          $new_clear = array();
          // New array with key clearance id and value clearance level
          foreach ($clearance_options as $l) {
            $new_clear[$l->id] = $l->name;
          }

          foreach($new_clear as $c=>$label_text){
            $data = array(
              'name' => 'clearance[]',
              'id' => $c,
              'value' => $c,
              'checked' => FALSE,
              'class' => 'form-check-input'
            );

            echo '<div class="form-check">';
            echo form_label(form_checkbox($data) . $label_text, $c.'-label', array('for' => $c));
            echo '</div>';
          }
          ?>
        </div>


        <!-- Status -->
        <div class="form-group">
          <label for="form_status" class="control-label">Status</label>

          <!-- helper function to generate select form field with options -->
          <?php

          $selected = set_value($status);
          echo form_dropdown('form_status', $states, $status, "class='form-control'");
          ?>

          <span class="text-danger"><?php echo form_error('form_status'); ?></span>
        </div>

        <!--Submit Button -->
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


  </script>
