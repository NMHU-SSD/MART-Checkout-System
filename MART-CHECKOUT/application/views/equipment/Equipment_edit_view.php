<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Edit Equipment</h1>
      <br>
      <?php
      $options = array(
        'out of commission' => 'Out of Commission',
        'available for checkout' => 'Available for Checkout',
        'reserved' => 'Reserved',
        'available after class' => 'Available After Class',
        'out for repair' => 'Out for Repair');

        $new_clear = array();
        // New array with key clearance id and value clearance level
        foreach ($clearance as $l) {
          $new_clear[$l->id] = $l->level;
        }

        echo form_open('Equipment/update/'.$records->barcode);
        echo form_hidden('old_barcode', $records->barcode);

        ?>

        <div class="form-group">
          <label for="barcode" class="control-label">Equipment Barcode</label>
          <?php
          echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>$records->barcode, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('barcode');?></span>
        </div>

        <div class="form-group">
          <label for="name" class="control-label">Name</label>
          <?php
          echo form_input(array('id'=>'name', 'name'=>'name', 'value'=>$records->name, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('name');?></span>
        </div>

        <div class="form-group">
          <label for="description" class="control-label">Description</label>
          <?php
          echo form_input(array('id'=>'description', 'name'=>'description', 'value'=>$records->description, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('description');?></span>
        </div>

        <div class="form-group">
          <label for="clearance">Select Clearance Level</label><br>
          <?php echo form_multiselect('clearance[]', $new_clear , 'class="form-control" id="clearance"'); ?>
        </div>

        <div class="form-group">
          <label for="notes" class="control-label">Notes</label>
          <?php
          echo form_textarea(array('id'=>'notes',  'name'=>'notes', 'value'=>$records->notes, 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('notes');?></span>
        </div>

        <div class="form-group">
          <label for="account_purchased_from" class="control-label">Account Purchased From</label>
          <?php
          echo form_input(array('id'=>'account_purchased_from', 'name'=>'account_purchased_from', 'value'=>$records->account_purchased_from, 'class'=>'form-class_name'));
          ?>
          <span class = "text-danger"><?php echo form_error('account_purchased_from');?></span>
        </div>

        <div class="form-group">
          <label for="status" class="control-label">Status of Product</label>
          <?php
          echo form_dropdown('status', $options, $records->status);
          ?>
        </div>

        <?php

        echo form_submit(array('id'=>'submit','value'=>'Update', 'class'=>'btn btn-primary'));
        echo form_close();
        ?>
      </div>
    </div>
  </div>
