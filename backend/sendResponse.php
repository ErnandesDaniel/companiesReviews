<?php

function sendResponse($actionCompleted,$message,$content=''){
	
	$data['actionCompleted']=$actionCompleted;
	$data['message']=$message;
	$data['content']=$content;
	
	echo json_encode($data);
	
}


?>