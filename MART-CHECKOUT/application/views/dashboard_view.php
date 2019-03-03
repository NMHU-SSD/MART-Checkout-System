<div class="container-fluid">

		<?php echo $this->session->flashdata('message'); ?>

		<h1>Dashboard</h1>
		<br>

		<?php if($_SESSION['user_role'] != 'Student Employee'){?>
			<a class="btn btn-primary float-right mb-4" href ="<?php echo base_url(); ?>employees/password/<?php echo $_SESSION['user_id'] ?>">Reset Password</a>
		<?php } ?>

		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Banner ID</th>
					<th scope="col">Role</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $_SESSION['user_name'] ?></td>
					<td><?php echo $_SESSION['user_id'] ?></td>
					<td><?php echo $_SESSION['user_role'] ?></td>
				</tr>
			</tbody>
		</table>

	</div>
	<div>
