<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">
      <h1>Add New Equipment</h1>
      <br>
      <?php
      //options for status dropdown
      $options = array(
        'out of commission' => 'Out of Commission',
        'available for checkout' => 'Available for Checkout',
        'reserved' => 'Reserved',
        'available after class' => 'Available After Class',
        'out for repair' => 'Out for Repair');

        $level_options = array();

        foreach ($levels as $l) {
          $level_options[] = $l->level;
        }

        echo form_open('equipment/add');
        ?>

        <div class="form-group">
          <label for="barcode" class="control-label">Barcode</label>
          <?php
          echo form_input(array('id'=>'barcode', 'name'=>'barcode', 'value'=>set_value('barcode'), 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('barcode');?></span>
        </div>

        <div class="form-group">
          <label for="name" class="control-label">Item Name</label>
          <?php
          echo form_input(array('id'=>'name', 'name'=>'name', 'value'=>set_value('name'), 'class'=>'form-control'));
          ?>
          <span class="text-danger"><?php echo form_error('name');?></span>
        </div>

        <div class="form-group">
          <label for="description" class="control-label">Description</label>
          <?php
          echo form_input(array('id'=>'description', 'name'=>'description', 'value'=>set_value('description'), 'class'=>'form-control'));
          ?>
          <span class = "text-danger"><?php echo form_error('description');?></span>
        </div>

        <div class="form-group">
          <label for="clearance">Select Clearance Level</label>
          <?php echo form_multiselect('clearance[]', $level_options , 'class="form-control" id="clearance"'); ?>
        </div>

        <div class="form-group">
          <label for="notes" class="control-label">Notes</label>
          <?php
          echo form_textarea(array('id'=>'notes', 'name'=>'notes', 'value'=>set_value('notes'), 'class'=>'form-control'));  ?>
          <span class="text-danger"><?php echo form_error('notes');?></span>
        </div>

        <div class="form-group">
          <label for="account_purchased_from" class="control-label">Account Purchased From</label>
          <?php
          echo form_input(array('id'=>'account_purchased_from', 'name'=>'account_purchased_from', 'value'=>set_value('account_purchased_from'), 'class'=>'form-control'));  ?>
          <span class = "text-danger"><?php echo form_error('account_purchased_from');?></span>
        </div>

        <div class="form-group">
          <label for="status" class="control-label">Status of Product</label>
          <?php
          echo form_dropdown('status', $options, set_value('status'), 'available for checkout' );
          ?>
        </div>
        <?php
        echo form_submit(array('id'=>'submit','value'=>'Add', 'class'=>'btn btn-primary'));
        echo form_close();
        ?>
      </div>
    </div>
  </div>
