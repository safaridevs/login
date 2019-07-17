<?php include'includes/header.php';?>
<?php include'includes/navigation.php';?>



	<div class="jumbotron">
		<h1 class="text-center">Admin</h1>
		<p id="user"></p>
		<?php 
			if(logged_in()){
				echo "logged in";
			}else{
				redirect("index.php");
			}
		
		?>
		
		<script>
			var user ={
				login: <?php echo logged_in();?>,
				email :"<?php echo $_SESSION['email'];?>",
				
			};
			document.getElementById('user').innerHTML = user.email + " logged in "+ user.login;
		</script>
		
		
	</div>



<?php include'includes/footer.php';?>
