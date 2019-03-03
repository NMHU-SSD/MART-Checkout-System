<div class="container-fluid">

  <?php echo $this->session->flashdata('message'); ?>

  <h1>Clearance Levels</h1>

  <?php if($_SESSION['user_role'] == "Admin"){?>
		<a class="btn btn-primary float-right mb-4" href = "<?php echo base_url(); ?>clearance/new">New Clearance Level</a>
	<?php } ?>


  <!-- Clearance Table -->
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
        <th scope="col">Name</th>
				<th scope="col">Description</th>
				<th scope="col">Courses</th>

        <?php
        if($_SESSION['user_role'] == "Admin"){
          echo '<th scope="col">Edit</th>';
  				echo '<th scope="col">Delete</th>';
        }
        ?>

			</tr>
		</thead>
		<tbody>
		<?php

			$i = 1;
			foreach($records as $r) {

				echo "<tr>";
        echo "<td>".$r->name."</td>";
				echo "<td>".$r->description."</td>";
				echo "<td>".$r->courses."</td>";

        if($_SESSION['user_role'] == "Admin"){

          echo "<th scope='col'><a href = '".base_url()."clearance/edit/".$r->id."'>Edit</a></th>";

          $delete = base_url().'clearance/delete/'.$r->id;
          echo '<th scope="col"><a href="" data-href="'.$delete.'" data-toggle="modal" data-target="#confirm-delete" data-message="'.$r->name.'" >Delete</a></th>';
        }

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
