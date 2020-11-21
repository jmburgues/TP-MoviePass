<div class = "backgroundBlack">
<div style="text-align:center">
    <img width="700" height="700" id="notFoundImageCard" src="<?php echo FRONT_ROOT ?>/Views/img/nomovies.svg">
    <pre style="font-size:40px">Ooops!! Something went wrong...</pre>
    <pre style="font-size:20px"><pre>
    <?php if(is_array($arrayOfErrors)) { 
            foreach ($arrayOfErrors as $error) echo $error."<br>";
            }
            else{
                echo $arrayOfErrors;
            }?></pre>
</div>
</div>