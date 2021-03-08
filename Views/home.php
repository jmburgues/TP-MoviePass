<!-- background -->
<style>
* {
  box-sizing: border-box;
}

.header {
  padding: 1px;
}

body{
    background-image: url('<?php echo FRONT_ROOT?>/Views/img/homeBgNew.jpeg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}

.row::after {
  content: "";
  clear: both;
  display: table;
}

[class*="colu-"] {
  float: left;
  padding: 15px;

}

.card{
    width: 100%;
    height: 100vh;
    border: 1px solid black;
    border-radius: 5px;
    padding: 0px 0px 0px 0px;
    margin-left: 5px;
    align-items: center;
}

.card-img{
  width: 14vw;
  height: 50vh;
  border: 1px solid white;
  padding: 1px;
}
}

.card-title{
  width: 100%;
  height: 40%;
  font-family: 'Courier New', Courier, monospace bold;
  font-size: 5em;
  text-align: center;
  padding-top: 1px;
  padding-bottom: 1px;
  margin-top: 5px;
  margin-bottom: 5px;
  border: 5px red;
  border-style: dotted;
}

.card-body-text{
  width: 90%;
  height: 100%;
  border: 1px solid black;
  text-align: justify;
  font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  font-size: 1em;

}

.colu-1 {width: 8.33%;}
.colu-2 {width: 16.66%;}
.colu-3 {width: 25%;}
.colu-4 {width: 33.33%;}
.colu-5 {width: 41.66%;}
.colu-6 {width: 50%;}
.colu-7 {width: 58.33%;}
.colu-8 {width: 66.66%;}
.colu-9 {width: 75%;}
.colu-10 {width: 83.33%;}
.colu-11 {width: 91.66%;}
.colu-12 {width: 100%;}

@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  [class*="colu-"] {
    width: 100px;
    height:auto;
  }
  
  .card{
    width: 80%;
  } 
  .card-img{
    width: 50%;
    height: 60%;
    border: 1px solid black;
    padding-top: 5px;
  }
}
</style>

  <?php
    $total = count($movies);
    $articlePerPage = 5;
    $pages = ($total / $articlePerPage );
    $pages = ceil($pages);
    $init = ($page-1)*$articlePerPage;
    ?>


  <!--Primer vista al entrar a la página-->
  <!--Jumbotron-->
  <!--  <img height="155" width="200"  -->
  <div style="align-items: center;">
    <img height="150vh" width="200vw" style="display: block; margin-left: auto; margin-right: auto;" src="<?php echo FRONT_ROOT?>/Views/img/MoviePass-noBgW.png">
  </div>

  <div>
    <hr class="mt-2 mb-4 bg-danger text-dark">
    <h3 class="header text-white text-center" ><?php echo $title;?><h3>
    <hr class=" mt-4 mb-1 bg-danger text-dark">
  </div>
        
  <div class="colu-1">
  </div>
    
  <div class="row">
    <?php for($i = $init; $i < $init+5; $i++ ){ 
        if (isset($movies[$i])) { ?>  
          
          <div class="colu-2 card">
            <?php if($movies[$i]->getPoster() == null){ ?>
              <img class="card-img" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
                <?php }else{ ?>
              <img class="card-img" src="https://image.tmdb.org/t/p/w400/.<?php echo $movies[$i]->getPoster()?>">
                <?php } ?>
              <div class="card-title">
                <?php if(strlen($movies[$i]->getTitle()<40)){ ?>
                <h4><?php echo $movies[$i]->getTitle();?></h4>
                <?php } else { ?>
                <h5><?php echo $movies[$i]->getTitle();?></h5>
                <?php } ?>  
              </div>                  
              <div class="card-body-text">
              <!-- BUYING BUTTON -->
              <?php if(!isset($_SESSION['loggedUser'])){ ?> 
                <form action="<?php echo FRONT_ROOT?>User/showLoginForm" method="POST" >
                <?php }else{ ?>
                <form action="<?php echo FRONT_ROOT?>Ticket/selectShow" method="POST" >
                <?php } ?>
                <button value="<?php echo $movies[$i]->getMovieID()?>" name="movieId" class="btn btn-secondary bg-danger text-black mb-2"  type="submit">Buy Tickets</button>   
                </form>

                <p style=text-align:justify;>
                <?php
                    if ($movies[$i]->getDescription()) {
                        if (strlen($movies[$i]->getDescription()) < 100) {
                            echo $movies[$i]->getDescription();
                        } else {
                            echo substr($movies[$i]->getDescription(), 0, 100);
                            echo "...";
                        }
                    } else {
                        echo $movies[$i]->getTitle();
                    } ?>
                </p>
                <?php if ($movies[$i]->getDescription() && strlen($movies[$i]->getDescription()) >= 100) {?>
                  <div>
                    <a class="btn dropdown-toggle card-text aDropCards" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <small class="text-muted" >Read more</small>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-2 dropDownCard" id="dropDownCard" aria-labelledby="dropdownMenuLink">
                      <strong> <?php echo $movies[$i]->getDescription(); ?> </strong>
                    </div>
                  </div>   
                  <?php } } ?>
                </div>
            </div>
                <?php } ?>
      </div>
<div>
  <?php if ($movies != null) { ?>
  <div class ="marginTop100" >
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3 ">
      <li class="page-item border-0 <?php echo $page <= 1 ? "disabled" : "" ?>"><a class="page-link text-dark btn btn-danger " href="<?php echo FRONT_ROOT?>Home/Index/<?php echo $page-1 ?>">Previous</a></li>
      
      <?php for($i=0; $i<$pages; $i++) {?>
        <li class="page-item border-0 <?php echo $page == $i+1 ? "active" : ""?>"><a style="background-color: <?php echo $page == $i+1 ? "red" : ""?>" class="page-link text-dark btn btn-danger" href="<?php echo  FRONT_ROOT?>Home/Index/<?php echo $i+1?>"> <?php echo $i+1?></a></li>
      <?php }?>

      <li class="page-item border-0 <?php echo $page >= $pages ? "disabled " : "" ?>"><a class="page-link text-dark btn btn-danger" href="<?php echo FRONT_ROOT?>Home/Index/<?php echo $page+1 ?>">Next</a></li>
    </ul>
  </nav>

  <hr class=" mt-4 mb-1 bg-danger text-dark">
  </div >
  <?php }else{
    ?><img id="noMovieImg" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">   <?php
    ?><p class="text-white text-center font-weight-bold fontWeight">NO LOADED MOVIES YET</p>
    <p class="text-muted text-center mb-5"> <?php echo "PLEASE TRY AGAIN LATER"?><p><?php
  } ?>
    </div>
    
