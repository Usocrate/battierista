<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
  <jdoc:include type="head" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style.css" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <header>
    	<nav id="nav1" class="navbar navbar-expand-lg"><div><jdoc:include type="modules" name="header-nav1-menu" /></div></nav>

		<nav id="nav2" class="navbar navbar-expand-lg">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#">Parc des Battières</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    	<jdoc:include type="modules" name="header-nav2-menu" />
		    </div>
		  </div>
		</nav>
    </header>
    
    <div id="page">
	    <jdoc:include type="modules" name="jumbotron" />
	    
	    <jdoc:include type="modules" name="focus" />
	    
	    <main>
	    	<jdoc:include type="message" />
	    	<jdoc:include type="modules" name="main" />
	       	<jdoc:include type="component" />
	    </main>
	    
	    <jdoc:include type="modules" name="more" />
    </div>
    
    <footer>
    	<div>
        	<nav><jdoc:include type="modules" name="footer" /></nav>
        </div>
    </footer>
</body>
</html>
