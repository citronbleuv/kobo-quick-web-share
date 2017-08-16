<?php $view->extend('layout.html.php') ?>

<form class="edit-form" action="" method="post">
    <div class="edit-ingredients">
        <label>
            Ingrédients :
            <textarea name="ingredients"><?php echo $ingredients ?></textarea>
        </label>
    </div>

    <div class="edit-steps">
        <label>
            Étapes :
            <textarea name="steps"><?php echo $steps ?></textarea>
        </label>
    </div>
    <label>
        Nombre de couverts :
        <input type="number" name="nbperson" value="<?php echo $nbperson ?>">
    </label>
    <label>
        Nombre de couverts souhaités :
        <input type="number" name="nbpersonWant" value="<?php echo $nbpersonWant ?>">
    </label>


    <input type="submit" value="Enregistrer">
</form>
