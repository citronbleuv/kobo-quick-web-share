<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
    <head>
        <title>Test</title>
        <meta charset="UTF-8">
        <link href="css/view.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="nbperson">
            <div class="nb"><?php echo $receipe['nbpersonWant'] ?>p.</div>
        </div>
        <div id="ingredients" class="ingredients">
            <div id="ingredients-up-area" class="up-area"></div>
            <div id="ingredients-down-area" class="down-area"></div>

            <div id="ingredients-area" class="ingredients-area area">
                <?php echo $ingredients ?>
            </div>
        </div>

        <div id="steps" class="steps">
            <div id="steps-up-area" class="up-area"></div>
            <div id="steps-down-area" class="down-area"></div>
            <div id="steps-area" class="steps-area area">
                <?php echo $steps ?>
            </div>
        </div>
        <script src="js/view.js"></script>
    </body>
</html>
