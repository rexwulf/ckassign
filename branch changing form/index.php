<?php 
	session_start();
	class student{
		var $name, $course, $branch, $sem, $cgpa, $result;
		//var $branchList, $courseList;
		var $nameErr, $courseErr, $branchErr, $semErr, $cgpaErr;
		var $Err, $subSuccess;
		function __construct($n="",$c="",$b="",$s=0,$g=0)
		{
			$this->name = $n;
			$this->course = $c;
			$this->branch = $b;
			$this->sem = $s;
			$this->cgpa = $g;
			$this->result=1;
			$this->nameErr=$this->courseErr=$this->branchErr=$this->semErr=$this->cgpaErr="";
			$this->Err=$this->subSuccess=0;
		}

		function name_valid()
		{
			if(preg_match("/^[a-zA-Z ]*$/",$this->name))
				return TRUE;
			echo $this->name." ";
			$this->nameErr = "Name can only contain alphabets and (') (.)";
			return FALSE;
		}

		function sem_valid()
		{
			if($this->sem < 3)
				return TRUE;
			$this->semErr = "You can change branch only before 3rd semester.";
			return FALSE;
		}

		function gpa_valid()
		{
			if($this->cgpa <= 10.00 && $this->cgpa > 9.00)
				return TRUE;
			$this->cgpaErr = "Your CGPA should be greater than 9.00";
			return FALSE;
		}
		
		function courseOrBranch()
		{
			if($this->course && $this->branch)
			{
				$this->courseErr.="You cannot change both branch and course.";
				$this->branchErr.="You cannot change both branch and course.";
				return false;
			}
			if($this->course==="" && !$this->branch==="")
			{
				$this->branchErr.="Both branch and course cannot be empty.";
				return false;
			}
			return true;
		}



		function nameSize()
		{
			$n = explode(" ",$this->name);
			if(count($n)>=3 && $this->course)
			{
				$this->courseErr.="You cannot change your course.";
				return FALSE;
			}
			else if(count($n)==1 && $this->branch)
			{
				$this->courseErr.="You cannot change your branch.";
				return FALSE;
			}
			return TRUE;
		}

		function validate()
		{
				if(!$this->name_valid())
					$this->Err++;
				if(!$this->sem_valid())
					$this->Err++;
				if(!$this->gpa_valid())
					$this->Err++;
				if(!$this->courseOrBranch())
					$this->Err++;
				if(!$this->nameSize())
					$this->Err++;
				if(!$this->Err)
					return FALSE;
				return TRUE;
		} 

		function submit_to_db()
		{
			require("server.php");
			
			$this->course = strtolower($this->course);
			$this->branch = strtolower($this->branch);

			$query = "INSERT INTO student( ";
			$query.= "name, course, branch, sem, cgpa, result) ";
			$query.= "VALUES( ";
			$query.= "'{$this->name}','{$this->course}','{$this->branch}','{$this->sem}','{$this->cgpa}',1)";
			$q = mysqli_query($conn, $query);
			if($q)
				{
					$this->subSuccess=1;
					return TRUE;
				}
			else
			{
				echo " FAILED: ".mysqli_error($conn);
				return FALSE;
			}
		}
	};
	
	$s = new student();	
	if(isset($_POST['submit']))
	{
		$s = new student($_POST['name'],$_POST['course'],$_POST['branch'],$_POST['sem'],$_POST['gpa']);
		$s->validate();
		
		if(!$s->Err && $s->submit_to_db())
					echo ("<div id=\"success1\">Successfully submitted.</div>");	
		else
			echo $s->Err;
	}
?>

<DOCTYPE html>
	<head><script src='//static.codepen.io/assets/editor/live/console_runner-ce3034e6bde3912cc25f83cccb7caa2b0f976196f2f2d52303a462c826d54a73.js'></script><script src='//static.codepen.io/assets/editor/live/css_live_reload_init-890dc39bb89183d4642d58b1ae5376a0193342f9aed88ea04330dc14c8d52f55.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//static.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/Lewitje/pen/BNNJjo" />

	<head>
		<title>The 200s</title>
		 <link rel="stylesheet" href="css/style.css">
	</head>
	<body class="wrapper">
<div >
	<div class="container">
		<h1>Apply for branch change</h1>
		
		<form class="form" method="post" action="index.php">
			<input type="text" name="name" placeholder="Name ?" value="<?php echo $s->name; ?>">  <span style="color:red;"><?php echo "$s->nameErr"; ?></span>
			<input type="text" name="course" placeholder="Course ?" value="<?php echo $s->course; ?>"> <span style="color:red;"><?php echo "$s->courseErr"; ?></span>
			<input type="text" name="branch" placeholder="Branch ?" value="<?php echo $s->branch; ?>"> <span style="color:red;"><?php echo "$s->branchErr"; ?></span>
			<input type="number" name="sem" placeholder="Semester ?" value="<?php echo $s->semester; ?>"> <span style="color:red;"><?php echo "$s->semErr"; ?></span>
			<input type="number" step="0.01" name="gpa" placeholder="CGPA ?" value="<?php //if(isset($s)) echo $s->gpa; ?>"> <span style="color:red;"><?php echo "$s->cgpaErr"; ?></span>
			<button type="submit" name="submit" >Submit</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<script src='//static.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script > $("#login-button").click(function(event){
		 event.preventDefault();
	 
	 $('form').fadeOut(500);
	 $('.wrapper').addClass('form-success');
});
//# sourceURL=pen.js
</script>
</body></html>