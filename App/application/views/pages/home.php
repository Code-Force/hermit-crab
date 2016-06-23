<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container">
	<h1>Welcome to being a towel</h1>

	<div id="body">
		No you're a towel
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
