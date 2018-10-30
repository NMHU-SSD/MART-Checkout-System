<div class="container-fluid">
	<?php echo $this->session->flashdata('message'); ?>

	<h1>Faculties</h1>
	<a class="btn btn-primary float-right m-2" href = "<?php echo base_url(); ?>faculty/new">New Faculty</a>

	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Banner ID</th>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Phone</th>
				<th scope="col">Clearance Levels</th>
				<!-- <th scope="col">Amount Owed</th> -->
				<!-- <th scope="col">Enrollment</th> -->
				<!-- <th scope="col">Eligibility</th> -->
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach($faculties as $f) {
				echo "<tr>";
				echo "<td>".$i++."</td>";
				echo "<th scope='row'>".$f->banner_id."</th>";
				echo "<td>".$f->name."</td>";
				echo "<td>".$f->email."</td>";
				echo "<td>".$f->phone."</td>";
				echo "<td>".$f->clearance_level."</td>";
				// echo "<td>$".$f->amount_owed."</td>";
				// echo "<td>".$f->enrollment."</td>";
				// echo "<td>".$f->eligibility."</td>";
				echo "<th scope='col'><a href = '".base_url()."faculty/edit/"
				.$f->banner_id."'>Edit</a></th>";

				$delete = base_url().'faculty/delete/'.$f->banner_id;
				echo '<th scope="col"><a href="" data-href="'.$delete.'"
				data-toggle="modal" data-target="#confirm-delete" data-message="'.$f->name.'" >Delete</a></th>';
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
					<h5 class="modal-title" id="ModalLabel">Delete Faculty</h5>
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
