<?php
if($page != 'activity_model'){}
//$this->load->view('includes/header' , $header_view);
?>

<div>
	<?php 
	//echo validation_errors('<div class=error_message>', '</div>');

	//echo $this->session->flashdata('message');

	//if (!empty($message)) echo '<div class=message>'.$message.'</div>';
	//if (!empty($error_message)) echo '<div class=error_message>'.$error_message.'</div>';
	//if (!empty($success_message)) echo '<div class=success_message>'.$success_message.'</div>';
	?>

	<?php 
	if($page == 'cat')
		$this->load->view('pages/'.$page, $main_view);
	else if($page == 'main_view_')
		$this->load->view('pages/'.$page , $my_collection_view);
	else  if($page == 'activity_view')
		$this->load->view('pages/'.$page , $activity_view);
	else if ($page == 'scoreboard_view')
		$this->load->view('pages/'.$page , $scoreboard_view);
	else
		$this->load->view('pages/'.$page);
	?>

</div>

<?php // $this->load->view('includes/footer'); ?>