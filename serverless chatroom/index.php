<?php
	require_once('chat.php');
	
	if(!empty($_REQUEST)){
		$c = $_SESSION['chat'];
		$c->history[] = new msg($_REQUEST['user'],$_REQUEST['newmsg'],date("h:i:sa"),date("Y.m.d"));		
		$_SESSION['chat'] = $c;
	}

	
	

	if(isset($_REQUEST['user'])){	
		if($_REQUEST['user']==1){
			echo '<script type="text/javascript">','disable2();','</script>';
		}
		else{
			echo '<script type="text/javascript">','disable1();','</script>';
		}
		
			
	}
?>
<html>
	<body>
		<script>
			function disable1() {
   				 document.getElementById("b1").disabled = true;
			}

			function enable1() {
  				  document.getElementById("b1").disabled = false;
			}
			function disable2() {
   				 document.getElementById("b2").disabled = true;
			}

			function enable2() {
  				  document.getElementById("b2").disabled = false;
			}
		</script>

	</body>
</html>
