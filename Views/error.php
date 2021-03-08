<div style="background-color: #000000; height: 100%; width: 100%;">
<div style="text-align:center; padding-top: 6%;">
    <img width="50%" height="50%" id="notFoundImageCard" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
    <p style="font-size:5vw; color: white;">Ooops!! Something went wrong...</p>
    <p style="font-size:2vw; color: white; text-align:center;">
    <?php if(is_array($arrayOfErrors)) { 
            foreach ($arrayOfErrors as $error) echo $error."<br>" ;
            }
            else{
                echo $arrayOfErrors;
            }?></p>
</div>
</div>