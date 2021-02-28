<div style="background-color: #000000; height: 1000px;">
<div style="text-align:center; padding-top: 6%;">
    <img width="700" height="700" id="notFoundImageCard" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
    <pre style="font-size:40px; color: white;">Ooops!! Something went wrong...</pre>
    <pre style="font-size:20px; color: white; text-align:center;">
    <?php if(is_array($arrayOfErrors)) { 
            foreach ($arrayOfErrors as $error) echo $error."<br>" ;
            }
            else{
                echo $arrayOfErrors;
            }?></pre>
</div>
</div>