<?php
	if(!empty($arrayOfErrors)){
		$arrayOfErrors = implode('\n',$arrayOfErrors);
		echo "<script type='text/javascript'>alert('$arrayOfErrors');</script>" ;
	}
?>

<!--Boton HOME-->
<nav class="navbar navbar-expand-lg p-0 navClass ">
    <ul class="navbar-nav mr-auto  mt-1 mt-lg-0 ">
        <div class="nav-item active homeButton">
            <strong><a class=" nav-link text-white ml-2" href="/TP-MoviePass">Home</a></strong>
        </div>
    </ul>

    <!--Dropdown buscar por género-->
    <div class=" mr-3  btn-group">
        <div class="nav-item">
            <div class="dropdown">
                <form class="form-inline my-2 my-lg-2 " action="<?php echo FRONT_ROOT?>Show/listByGenre" method=POST>
                    <button class=" btn btn-secondary btn-dark dropdown-toggle marginRight10 " id="marginRight10"
                        type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" <?php if($genresList==null){ ?> disabled <?php } ?>>
                        Genre
                    </button>
                    <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                        <?php if(isset($genresList) && $genresList != null) { 
								foreach ($genresList as $genre){ ?>
                        <button type="submit" class="dropdown-item btn btn-danger" name="genreId"
                            value="<?php echo $genre->getId(); ?>"><?php echo $genre->getName();?></button>
                        <?php 
								} 
							}?>
                    </div>
                </form>
            </div>
        </div>

        <!--Dropdown calendario, buscar por fecha-->
        <div>
            <div class="dropdown">
                <form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>Show/getMoviesByDate"
                    method=POST?>
                    <button class="btn btn-secondary btn-dark dropdown-toggle " id="marginRight10" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        <?php if($moviesYearList==null) { ?> disabled <?php } ?>>
                        Year
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php  if(isset($moviesYearList) && $moviesYearList != null) { foreach($moviesYearList as $year){ ?>
                        <button type="submit" class="dropdown-item btn btn-danger" name="year"
                            value="<?php echo $year;?>"><?php echo $year;?></button>
                        <?php } } ?>
                    </div>
                </form>
            </div>
        </div>

        <!--SESSION USER DROPDOWN-->
        <div>
            <div class="dropdown">
                <form class="form-inline my-2  my-lg-2 ">
                    <?php if(!isset($_SESSION['loggedUser'])){ ?>
                    <!--  USER NOT LOGGED -->
                    <button class="btn btn-secondary btn-dark dropdown-toggle" id="marginRight10" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hello Guest!
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button type="button" class="dropdown-item btn btn-danger" value="Sing In"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/showLoginForm'">Sing In</button>
                        <button type="button" class="dropdown-item btn btn-danger" value="Register"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/register'">Register</button>
                    </div>
                    <?php } else { ?>
                    <!--IS LOGGED -->

                    <button class="btn btn-secondary btn-dark dropdown-toggle" id="marginRight10" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hello <?=$_SESSION['loggedUser']?>!
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button type="button" class="dropdown-item btn btn-danger"
                            value="<?php echo $_SESSION['loggedUser']?>" name="userName"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/userView'">My Account</button>

                        <?php if($_SESSION['role'] == 'admin') { ?>
                        <!-- IS ADMIN -->
                        <button type="button" class="dropdown-item btn btn-danger" value="AdminTools"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'">Admin Tools</button>
                        <?php } else if($_SESSION['role'] == 'owner'){?>
                        <button type="button" class="dropdown-item btn btn-danger" value="AdminTools"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'">Admin Tools</button>
                        <button type="button" class="dropdown-item btn btn-danger" value="OwnerTools"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/ownerView'">Owner Tools</button>
                        <?php } ?>
                        <button type="button" class="dropdown-item btn btn-danger" value="Logout"
                            onclick="window.location.href='<?php echo FRONT_ROOT?>User/logout'">Logout</button>
                    </div>
                    <?php }?>
                </form>
            </div>
        </div>
    </div>
</nav>