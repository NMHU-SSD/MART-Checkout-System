<div class="container">

	<div class="row pl-2 pr-2">
		<div class="col-sm-6 col-lg-3 ml-auto mr-auto mt-5">

			<?php echo $this->session->flashdata('message'); ?>

			<?php echo form_open('login/verify'); ?>
			<h1 class="text-center">Login</h1>

			<!-- banner id -->
			<div class="form-group">
				<label for="form_id" class="control-label">Banner ID</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">@</span>
					</div>

					<input class="form-control" id="form_id" name="form_id" placeholder="Enter ID" type="text" autocomplete="off"  aria-describedby="basic-addon1" value="<?php echo set_value('form_id'); ?>" />

				</div>

				<div class="form-group" id="divPassword" style="display: none">
					<input type="password" class="form-control" id="form_password" name="form_password" placeholder="Enter Password" type="text"  aria-describedby="basic-addon1" value="<?php echo set_value('form_password'); ?>" />
				</div>

				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="chkPassword">
					<label class="form-check-label" for="exampleCheck1">Manager/Assistant</label>
				</div>

				<!-- Only used for managers -->

			</div>
		</div>
	</div>

	<span class="text-danger"><?php echo form_error('form_id'); ?></span>

	<!-- login button -->
	<div class="form-group">
		<input type="submit" id="btn_login" name="btn_login" value="Login" class="btn btn-primary btn-block"/>
	</div>
	<?php echo form_close(); ?>

</div>
</div>
</div>


<script>
$(function () {
	$("#chkPassword").click(function () {
		if ($(this).is(":checked")) {
			$("#divPassword").show();
		} else {
			$("#divPassword").hide();
		}
	});
});
</script>
