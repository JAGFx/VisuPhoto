<section class="row">
    <h1 class="col-xs-12 text-center">Photo</h1>

    <nav aria-label="Page navigation" class="col-xs-12">
        <ul class="pager">
            <?php
            require __DIR__ . '/../Default/partials/subMenu.partials.php';
            ?>
        </ul>
    </nav>

    <div class="col-xs-12 col-md-8 col-md-offset-2">
        <div class="thumbnail">

            <img src="<?= $data->img->getPath(); ?>" alt="<?= $data->img->getComment(); ?>" width="<?= $data->size; ?>">

            <div class="caption">

                <form method="POST" action="?a=updateModifier" data-preventDefault="yes" class="col-xs-12">


                    <div class="form-group">
                        <label for="commentaire">Description </label>
                        <input type="text" class="form-control" name="commentaire" id="commentaire"
                               value="<?= $data->img->getComment(); ?>">
                    </div>

                    <span>Liste de catégorie disponible : </span><br>
                    <select name="selectList">
                        <?php foreach ($data->navBar['list'] as $list) : ?>
                            <?php
                            if ($list[0] == $data->img->getCategory()) { ?>
                                <option selected="selected"
                                        value="<?php echo $list[0]; ?>"><?php echo $list[0]; ?> </option>
                            <?php } else { ?>
                                <option value="<?php echo $list[0]; ?>"><?php echo $list[0]; ?> </option>

                            <?php } ?>
                        <?php endforeach; ?>
                    </select><br><br>

                    <span>Ou créer une nouvelle catégorie :</span><br>
                    <input type="text" class="form-control" name="nouvelleCategorie" id="nouvelleCategorie" value="">

                    <br><br>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <div class="messageForm"></div>
                </form>


            </div>

        </div>
    </div>