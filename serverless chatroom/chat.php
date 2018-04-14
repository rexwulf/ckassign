<?php
	session_start();
	require_once('fpdf/fpdf.php');
	class chat
	{
		public $user;
		public $history;
	}
	
	class msg
	{
		public $text;
		public $time;
		public $date;
		public $filePath;
		public $from;

		function __construct($from, $text, $time, $date, $filePath="") {
			$this->text = $text;
			$this->time = $time;
			$this->date = $date;
			$this->from = $from;
			$this->filePath = $filePath;
		}	
		
		function fileValid()
		{
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			if(isset($_POST["submit"])) {
  			  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    			if($check !== false) 
			{
     			   echo "File is an image - " . $check["mime"] . ".";
 			       $uploadOk = 1;
   			 } else {
 			       echo "File is not an image.";
  			      $uploadOk = 0;
   				 }
			}
			if ($_FILES["fileToUpload"]["size"] > 200000) {
 			   echo "Sorry, your file is too large.";
    				$uploadOk = 0;
			}
			
			if(in_array($imageFileType,array("jpg","png","jpeg","gif","doc","docx","xml","ppt","pptx" ))){
  				  echo "Sorry,this file type is not supported.";
   				 $uploadOk = 0;
			}
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) 
			{
			    echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} 
			else 
			{
 			   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			     echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
 			  else 
			    echo "Sorry, there was an error uploading your file.";
    			  
			}
		}
	}
		
	
	class PDF extends FPDF
	{
		
		function LoadData($lines)
		{
 		   $data = array();
  		  foreach($lines as $line)
   		     $data[] = explode(';',trim($line));
  		  return $data;
		}

		// Simple table
	
		function BasicTable($header, $data)
		{
   	 	// Header
   		 foreach($header as $col)
       			 $this->Cell(40,7,$col,1);
   		 $this->Ln();
   		 // Data
    		foreach($data as $row)
    		{
      		  foreach($row as $col)
         	   $this->Cell(40,6,$col,1);
       		 $this->Ln();
    		}
	}

}
	
	
	if(!isset($_SESSION['çhat']))
	{
		$m = new msg(0,"Connection Established!",date("h:i:sa"),date("Y.m.d"));
		$c = new chat;
		$c->history = array($m);
		$_SESSION['chat'] = $c;
	}	
?>



<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>RB CHAT</title>
</head>

<body>

  
<!DOCTYPE html><html lang='en' class=''>
<head><script src='//static.codepen.io/assets/editor/live/console_runner-ce3034e6bde3912cc25f83cccb7caa2b0f976196f2f2d52303a462c826d54a73.js'></script><script 

src='//static.codepen.io/assets/editor/live/css_live_reload_init-890dc39bb89183d4642d58b1ae5376a0193342f9aed88ea04330dc14c8d52f55.js'></script><meta charset='UTF-8'><meta name="robots" 

content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link 

rel="mask-icon" type="" href="//static.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" 

href="https://codepen.io/volya/pen/oomegr?q=css+chat&limit=all&type=type-pens" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style class="cp-pen-styles">* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

*:hover,
*:focus {
  outline: none;
}
html, body {
    max-width: 100%;
    overflow-x: hidden;
}
.chat {
  width: 100%;
  max-width: 800px;
  height: calc(100vh - 50px);
  min-height: 100%;
  padding: 15px 30px;
  margin: 0 auto;
  overflow-y: scroll;
  background-color: #fff;
  transform: rotate(180deg);
  direction: rtl;
}
.chat__wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column-reverse;
  flex-direction: column-reverse;
  -webkit-box-pack: end;
  -ms-flex-pack: end;
  justify-content: flex-end;
}
.chat__message {
  font-size: 18px;
  padding: 10px 20px;
  border-radius: 25px;
  color: #000;
  background-color: #e6e7ec;
  max-width: 600px;
  width: -webkit-fit-content;
  width: -moz-fit-content;
  width: fit-content;
  position: relative;
  margin: 15px 0;
  word-break: break-all;
  transform: rotate(180deg);
  direction: ltr;
}
.chat__message:after {
  content: "";
  width: 20px;
  height: 12px;
  display: block;
  background-image: url("https://stageviewcincyshakes.firebaseapp.com/icon-gray-message.e6296433d6a72d473ed4.png");
  background-repeat: no-repeat;
  background-position: center;
  background-size: contain;
  position: absolute;
  bottom: -2px;
  left: -5px;
}
.chat__message-own {
  color: #fff;
  margin-left: auto;
  background-color: #00a9de;
}
.chat__message-own:after {
  width: 19px;
  height: 13px;
  left: inherit;
  right: -5px;
  background-image: url("https://stageviewcincyshakes.firebaseapp.com/icon-blue-message.2be55af0d98ee2864e29.png");
}

.chat__form {
  background-color: #e0e0e0;
}

</style>
</head>
  <body>
    <div class="row">
      <div class="col-md-6">
                                  <div class="chat">
                                	 <div class="chat__wrapper">
						<?php foreach($_SESSION['chat']->history as $msg)
                                  	    		{
								if($msg->from == 2){
								echo "<div class=\"chat__message\"><div class=\"date\"></div><div>".$msg->text." </br><small>".$msg->time." ".$msg->date."</small>/div></div>";
								}
                                   	 			else{
								 echo "<div class=\"chat__message chat__message-own\"><div class=\"date\"></div><div>".$msg->text."</br><small>".$msg->time." ".$msg->date."</small></div></div>";
								}
							}
						?>	
                               		 </div>
                           	</div>

                      <div class="chat__form" >
                              <form class="form-group " action="index.php" method="post"  id="chat__form" enctype="multipart/form-data">
                                <input name="newmsg" type="text" placeholder="Type your message">
				<input type='hidden' name='user' value='2'/>
				<button type="submit" name="submit" id="b1">Send</button>
				<input type="file" name="Upfile" id="fileToUpload">
                              </form>
				<button name="pdf" id="pdf">Download pdf</button>
                            </div>
              </div>
                  
			<div class="col-md-6">
                                  <div class="chat">
                                	 <div class="chat__wrapper">
						<?php foreach($_SESSION['chat']->history as $msg)
                                  	    		{
								if($msg->from == 1){
								echo "<div class=\"chat__message\"><div class=\"date\"></div><div>".$msg->text." </br><small>".$msg->time." ".$msg->date."</small></div></div>";
								}
                                   	 			else{
								 echo "<div class=\"chat__message chat__message-own\"><div class=\"date\"></div><div>".$msg->text." </br><small>".$msg->time." ".$msg->date."</small></div></div>";
								}
							}
						?>	
                               		 </div>
                           	</div>

                           	 <div class="chat__form" >
                            	  	<form class="form-group " action="index.php" method="post"  id="chat__form" enctype="multipart/form-data">
                             	  		 <input name="newmsg" type="text" placeholder="Type your message">
						<input type='hidden' name='user' value='1'/>
						<button type="submit" name="submit" id="b2">Send</button>
						<input type="file" name="Upfile" id="fileToUpload">
                             		 </form>
					<div class="form-group" action="index.php" method="post">
					<button name="pdf" id="pdf">Download pdf</button>
					</div>
                          	  </div>
                           	 <div id="result"></div>
                  	  </div>
   	</div>

</body>
</html>
  
