<?php
    require_once('nav.php');
    require_once('header.php');
    
?>
<!--Estilo de la página-->
    <style type="text/css">
            body {
                background-color: #D2DAFF; 
                background-image: none; 
            }
            </style>
<?php 
    if (isset($moviesBDD)) {
        foreach ($moviesBDD as $movie) {
?>             
    <form action="<?php echo FRONT_ROOT?>Movie/selectIdMovie" method="POST" class= " mt-5">
        <div class= "container">            
            <div class="card card-body ">

                    <ul>
                        <li style="list-style:none">Cinema Name: <?php echo $movie->getTitle(); ?></li>
                        <li style="list-style:none">Cinema duration: <?php echo  $movie->getDuration(); ?></li>
                        <li style="list-style:none">Cinema Description: <?php echo $movie->getDescription();?></li>

                    </ul>  

            </div>
        </div>
        <?php
        }
        ?>
        <?php
        if(!$movies){
            ?>
            <div class="card card-body ">
                <?php echo "No movies loaded yet"?>  
            </div>
        <?php
        }
        ?>  
    </form>
    <?php
    }
    ?>
