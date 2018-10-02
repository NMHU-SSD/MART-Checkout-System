<div class="container-fluid">

  <?php echo $this->session->flashdata('message'); ?>

  <h1>Clearance</h1>

  <a href="clearance/new" type="submit" class="btn btn-primary float-right m-2" id="btn_new_user" name="btn_new_user" >New Clearance Level</a>

  <!-- Clearance Table -->
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
        <th scope="col">Clearance Level</th>
				<th scope="col">Barcode</th>
				<th scope="col">Description</th>
				<th scope="col">Class</th>
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$i = 1;
			foreach($records as $r) {
				echo "<tr>";
				echo "<th scope='row'>".$i++."</th>";
        echo "<td>".$r->level."</td>";
				echo "<td>".$r->barcode."</td>";
				echo "<td>".$r->description."</td>";
				echo "<td>".$r->class."</td>";
				echo "<td><a href = '".base_url()."clearance/edit/".$r->id."'>Edit</a></td>";
				echo '<th scope="col"><a href="" data-href="'.base_url().'clearance/delete/'.$r->id.'"data-toggle="modal" data-target="#confirm-delete" data-message="'.$r->level.'" >Delete</a></th>';
				echo "<tr>";
			}
			?>
		</tbody>
	</table>


  <!-- Modal/Pop up -->
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">Delete Clearance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="" class="btn-confirm"><button type="button" class="btn btn-primary">Delete</button></a>
        </div>
      </div>
    </div>
  </div>

</div>
