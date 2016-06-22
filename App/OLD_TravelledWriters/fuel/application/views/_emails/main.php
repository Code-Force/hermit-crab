<?php

// Load the generic header.
$this->load->view('_emails/header');

// Load the content of the basic page. Loaded from the main controller of the page.
$this->load->view($module.'/'.$view_file, $email_variables);


// Load the generic footer.
$this->load->view('_emails/footer');
?>