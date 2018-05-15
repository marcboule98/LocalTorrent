<?php foreach($ctl->errors as $error) { ?>
	<div class="error"><?php echo $error; ?></div>
<?php } ?>

<?php foreach($ctl->info as $info) { ?>
	<div class="info"><?php echo $info; ?></div>
<?php } ?>