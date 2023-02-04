<nav class="navbar shadow">
    <i class="fa fa-leaf" style="font-size : 40px ; color: #66ff66;">Leaf</i>
    <h1 style="color : black ;"><i class="fa fa-user-circle" style="font-size : 40px ;"></i>
    <?php echo $_SESSION['userlastname'];?></h1>
    <a class="disconnect" href="<?php echo base_url().'index.php/disconnect'?>"><i class="fa fa-power-off"></i></a>
</nav>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-4 mt-5" style="text-align: center;">
            <?php
                echo form_open('publish', ["id"=>"formPub"]) ;
            ?>
                <textarea name="comment" placeholder="Publiez quelque chose..."></textarea><br>
                <input type="submit" value="Publier" class="btn" style="background-color: #00ff00; color: white;">
            </form>
        </div>

        <div class="col-md-5 mt-5" style="text-align: center;">
            <?php for($i=0; $i<count($mydata); $i++) :?>
                <i class="fa fa-user" style="font-size: 20px;">
                <?php echo $mydata[$i]->username ;?></i>
                <p style="margin-bottom: 0rem;"><?php echo $mydata[$i]->pubValue ;?></p>

                    <div id="icons">
                        <?php $f = 0; ?>
                        <?php for($w=0; $w<count($mydataLikes); $w++) :?>
                            <p>
                                <?php
                                    if($mydataLikes[$w]->idpub == $mydata[$i]->idPub) {
                                        $f = $f+1;
                                    }
                                ?>
                            </p>
                        <?php endfor; ?>
                        <?php
                            if(count($mydataLikesColor) != 0) {
                                $donnees = $mydataLikesColor[$i]->color;
                            }
                            else {
                                $donnees = "red";
                            }
                        ?>
                        
                        <a class="mr-5 like" href="<?php echo base_url()."index.php/welcome/like/{$mydata[$i]->idPub}" ;?>">
                            <i class="fa fa-thumbs-up like" id="like" style="font-size: 20px; color: <?php echo $donnees; ?>;">
                            <?php echo $f; ?></i>
                        </a>

                        <a class="mr-5" href="<?php echo base_url()."index.php/welcome/share" ;?>"
                            style="text-decoration: none; color: black">
                            <i class="fa fa-share" style="font-size: 20px; color :#00ff00;"></i>
                        </a>
                   
                        <?php $c = 0; ?>
                        <?php for($z=0; $z<count($mydatas); $z++) :?>
                            <p>
                                <?php
                                    if($mydatas[$z]->IdPub == $mydata[$i]->idPub) {
                                        $c = $c+1;
                                    }
                                ?>
                            </p>
                        <?php endfor; ?>
                    
                        <a class="mr-5" href="#" style="text-decoration: none; color: black" id ="commentaire"
                            data-id="<?php echo $mydata[$i]->idPub ; ?>">
                            <i class="fa fa-comment" style="font-size: 20px; color :#00ff00;">
                            <?php echo $c; ?></i> 
                        </a>
                  
                        <a class="mr-5" href="<?php echo base_url()."index.php/welcome/supprimer/{$mydata[$i]->idPub}" ;?>"
                            style="text-decoration: none; color: black">
                            <i class="fa fa-trash-alt" style="font-size: 20px; color :red;"></i>
                        </a>
                    </div>
                
                <span class="<?php echo "formComment{$mydata[$i]->idPub}";?>" style="display: none;">
                    <?php $n = 0; ?>
                    <?php for($j=0; $j<count($mydatas); $j++) :?>
                        <p>
                            <?php
                                if($mydatas[$j]->IdPub == $mydata[$i]->idPub) {
                                    $n = $n+1;
                                    echo "<i class='fa fa-user' style='font-size : 12px;'> {$mydatas[$j]->commentOwner}</i>";
                                    echo "<br>";
                                    echo "<p style='font-size : 12px; margin: -15px -15px;'>{$mydatas[$j]->commentValue}</p>";
                                    echo "<i class='fa fa-trash-alt' style='font-size: 12px; margin-top: 17px;'></i>";
                                }
                            ?>
                        </p>
                    <?php endfor; ?>            
                    <?php
                        echo form_open('comment', ["class"=>"mt-2 formComment{$mydata[$i]->idPub}",
                        "style"=>"display: none"]) ;
                    ?>
                        <input type="text" name="idPublication" value="<?php echo $mydata[$i]->idPub ;?>"
                        style="display:none;">
                        <input type="text" name="commentOwner" value="<?php echo $_SESSION['username'].' '.$_SESSION['userlastname'];?>"
                        style="display:none;">
                        <textarea name="comment"></textarea><br>
                        <input type="submit" value="Commenter" class="btn" style="background-color: #00ff00; color: white;">
                    </form>
                </span><br>
            <?php endfor; ?>
        </div>
    </div>
</div>      