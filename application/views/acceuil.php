<nav class="navbar navbar-expand-lg navbar-fixed">
    <i class="fa fa-leaf" style="font-size : 40px ; color: white;">Leaf</i>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo validation_errors() ;
            ?>
            <?php
                echo form_open('connect', ['class'=>'form-group formulaire container-fluid shadow p-3 mt-5', 'id'=>'myForm']) ;
            ?>
                <input type="mail" class="form-control mt-2" name="mail" placeholder="Mail...">
                <input type="password" class="form-control mt-2" name="motDePasse" placeholder="Mot de passe...">
                <input type="submit" class="btn mt-2" value="Se connecter">
                <p class="float-right mt-3">Vous n'avez pas de compte? <a href="#" id="Link">S'incrire</a></p>
            </form>
        </div>

        <div id="modalInscription">
            <div class="modalContent">
                    <span><h5>Inscription</h5></span>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <?php echo form_open('inscription', ['class'=>'form-group shadow p-3  mt-5']) ; ?> 
                    <input type="mail" class="form-control mt-2" name="mailRegister" placeholder="Mail...">
                    <input type="text" class="form-control mt-2" name="nom" placeholder="Nom...">
                    <input type="text" class="form-control mt-2" name="prenoms" placeholder="Prenom(s)...">
                    <label for="datedenaissance" class="mt-3">Saisissez votre date de naissance (format : mm/jj/aaaa) :</label>
                    <input type="date" class="form-control" name="datedenaissance">
                    <input type="number" class="form-control mt-2" name="age" placeholder="Age...">
                    <input type="password" class="form-control mt-2" name="password" placeholder="Mot de passe...">
                    <input type="submit" class="btn mt-2" value="Enregistrer">
                </form>
            </div>
        </div>
    </div>
</div>