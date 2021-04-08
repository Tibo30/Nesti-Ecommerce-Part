<ul>
<?php

foreach($tags as $tag){
//   echo  "<div>". $tag ->name ."</div>";
echo "<li><a href=".base_url("public/tag/".$tag->id_tag).">". $tag ->name ."</a></li>";
}
?>
</ul>

