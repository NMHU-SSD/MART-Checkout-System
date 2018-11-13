<div class="container">
  <div class="row pl-2 pr-2">
    <div class="col-sm-6 col-lg-6 ml-auto mr-auto mt-5">

      <h1>Edit Student</h1>
      <br>
      <?php
      $active_options = array(
        'inactive' => 'Inactive',
        'active' => 'Active'
      );
      $eligible_options = array(
        'ineligible' => 'Ineligible',
        'eligible' => 'Eligible'
      );

      $new_clear = array();
      // New array with key clearance id and value clearance level
      foreach ($clearance as $l) {
        $new_clear[$l->id] = $l->level;
      }

      echo form_open('students/update/'.$records->banner_id);
      echo form_hidden('old_banner_id', $records->banner_id);
      ?>

      <!-- banner id -->
      <div class="form-group">
        <label for="banner_id" class="control-label">Banner ID</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>

          <?php
          echo form_input(array('id'=>'banner_id', 'name'=>'banner_id', 'value'=>$records->banner_id, 'class' => 'form-control'));
          ?>

        </div>
        <span class="text-danger"><?php echo form_error('banner_id'); ?></span>
      </div>

      <?php
      echo form_label('Name');
      echo form_input(array('id'=>'name','name'=>'name', 'value'=>$records->name, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('name');?></span>
      <br>

      <?php
      echo form_label('Email');
      echo form_input(array('id'=>'email','name'=>'email', 'value'=>$records->email, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('email');?></span>
      <br>

      <?php
      echo form_label('Phone');
      echo form_input(array('id'=>'phone','name'=>'phone', 'value'=>$records->phone, 'class' => 'form-control'));
      ?>
      <span class = "text-danger"><?php echo form_error('phone');?></span>
      <br>

      <div class="form-group">
        <label for="clearance">Select Clearance Level</label><br>
        <?php
        // When editing recheck all boxes that were checked
        // temp var
        $temp = "";
        // seperate clearance numbers on ,
        $pieces = explode(",", $records->clearance_level);

        echo '<div style="height: 100px; overflow-y: scroll;">';

        // loop through new clearance array
        foreach($new_clear as $c=>$label_text){
          // Loop through clearance numbers
          foreach($pieces as $p){
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
          echo form_label(form_checkbox($data) . $label_text, $c.'-label', array('for' => $c));
          echo '</div>';
        }
        // complete form
        echo '</div>';
        ?>
      </div>
      <br>
      <?php
      echo form_label('Amount Owed');
      echo form_input(array('id'=>'amount_owed','name'=>'amount_owed', 'value'=>$records->amount_owed, 'class' => 'form-control'));
      ?>
      <br>

      <div class="form-group">
        <label for="active" class="control-label">Enrollment Status</label>
        <?php
        echo form_dropdown('active', $active_options, $records->enrollment );
        ?>
      </div>

      <div class="form-group">
        <label for="eligible" class="control-label">Eligibility Status</label>
        <?php
        echo form_dropdown('eligible', $eligible_options, $records->eligibility );
        ?>
      </div>

      <?php
      echo form_input(array('type'=>'submit','value'=>'Update', 'class'=> 'btn btn-primary'));
      echo form_close();
      ?>
    </div>
  </div>
</div>
