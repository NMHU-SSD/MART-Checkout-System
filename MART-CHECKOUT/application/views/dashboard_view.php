<div class="container-fluid">

	<div class="container">
		<?php echo $this->session->flashdata('message'); ?>

		<h6>Banner ID: <?php echo $_SESSION['user_id'] ?></h6>
		<h6>Name: <?php echo $_SESSION['user_name'] ?></h6>
		<h6>Role: <?php echo $_SESSION['user_role'] ?></h6>

		<?php if($_SESSION['user_role'] != "Student Employee"){ ?>
			<?php echo form_open('employees/password/'.$_SESSION['user_id']); ?>
			<!-- Password reset button -->
			<div class="form-group">
				<input id="btn_register" name="btn_register" type="submit" class="btn btn-primary" value="Reset Password" />
			</div>
			<?php echo form_close(); ?>
		<?php } ?>

	</div>
	<div>
