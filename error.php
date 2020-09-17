<?php if (count($errors) > 0): ?>
	<div class="error">
		<?php foreach ($errors as $error): ?>
			<p ><?php  echo '<label class="text-danger">' . $error . '</label>'; ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?> 