<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <span><p><?php echo $error ?></p></span>
  	<?php endforeach ?>
  </div>
<?php  endif ?>