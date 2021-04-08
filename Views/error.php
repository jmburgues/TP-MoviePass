<div class="error-width">
    <div class="error-padding">
        <img width="50%" height="50%" id="notFoundImageCard" src="<?php echo IMG_NOMOVIEIMG?> ">
        <p class="error-p">Ooops!! Something went wrong...</p>
        <p class="error-p-align">
            <?php if(is_array($arrayOfErrors)) { 
            foreach ($arrayOfErrors as $error) echo $error."<br>" ;
            }
            else{
                echo $arrayOfErrors;
            }?></p>
    </div>
</div>