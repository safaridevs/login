
	 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container" >
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SafariDevs</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse"  >
          <ul class="nav navbar-nav" >
      
            <li class="active"><a href="./index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><?php if(logged_in()):?>
            	<a href="admin.php">Admin</a>
            <?php endif?>
            <li><?php if(logged_in()){
				echo '<a href="logout.php">Logout</a>';}else{echo '<a href="login.php">Login</a>';}?></li>
           	
           
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>