<?php include'includes/header.php';?>
<?php include'includes/navigation.php';?>

<!--////////////////////////////////////////////////////////////////////////////-->
<div class="row  text-center" >
	<h1>We strive to journey with you</h1>
	<p><?php if(isset($_SESSION['email'])){
	echo $_SESSION['email'];
}?></p>
<script type="text/javascript">
	var email = "<?php echo $_SESSION['email']; ?>";
		console.log(email);
</script>
	<h1 class="text-center"><?php echo display_message();?></h1>

</div> 
<div class="row  text-center" style="background-color: blue">
	<h1>Free Website Design and Development</h1>
	<h3>We bring expertise to our local community, non-profit and charity based projects.</h3>
	<button class="btn btn-primary"><h2>Contact SafariDevs Now</h2></button>
</div> 
 
<div class="row jumbotron " style="background-color:#14C4B8">

	<div class="text-center">
		<h3>Count on Safari Developers For Your Project</h3>
		
	</div>
	
	<div id="hide" class="container" >
	
		<div class="col-md-4">
				<h2>Web Design/Development</h2>
				<p>PHP</p>
				<p>Python</p>
				<p>ASP.NET</p>
		</div>
		<div class="col-md-4">
				<h2>Mobile Development</h2>
				<p>Adroid Apps</p>
				<p>IOS Apps</p>
		</div>
		<div class="col-md-4">
				<h2>Application Development</h2>
				<p>Desktop</p>
				<p>Web</p>
			
		</div>
	</div>
</div> 


	<h1 class="text-center" >What We Stand For</h1>
	<h1 id="email" >What We Stand For</h1>
	<div class="row">
  
  
 				
  					<div class="col-md-4" >
  						<h2 style="background-color:#06A89D">Mision</h2>
  						<p>Our mision is to promote our community.non-profit organizations and to encourage many to contribute their time and resource to better our society</p>
  					</div>
  					<div class="col-md-4">
  						<h2 style="background-color:#06A89D">Vision</h2>
  						<p>Our vision is to make our customers achieve their goals</p>
  						
						
  						</div>
  					<div class="col-md-4">
  						<h2 style="background-color:#06A89D">Join Us</h2>
  						<p>Be part of our mission and vision</p>
  						<p>We will partner with local developers to achieve our common goal.</p>
  					</div>
  			
  			
	

	  </div>

<script>
document.getElementById('email').innerHTML = "<?php echo $_SESSION['email']; ?>";
</script>
<script>
<?php echo $email; ?>=document.getElementById('email').innerHTML;
</script>
<?php echo $email ="<script> document.getElementById('email').innerHTML </script>" ;?>
<!--////////////////////////////////////////////////////////////////////////////-->


<?php include'includes/footer.php';?>

