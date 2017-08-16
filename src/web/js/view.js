var ingredientsUpArea = document.getElementById('ingredients-up-area'),
    ingredientsDownArea = document.getElementById('ingredients-down-area'),
    stepsUpArea = document.getElementById('steps-up-area'),
    stepsDownArea = document.getElementById('steps-down-area'),
    ingredientsArea = document.getElementById('ingredients-area'),
    stepsArea = document.getElementById('steps-area'),
    ingredients = document.getElementById('ingredients'),
    steps = document.getElementById('steps'),
    ingredientsAreaHeight = ingredientsArea.offsetHeight;

function scrollDown(event)
{
    if (event.target.id == 'ingredients-down-area') {
        var element = ingredientsArea;
    }
    else {
        var element = stepsArea;
    }

    element.scrollTop += element.offsetHeight;
    return false;
}

function scrollUp(event)
{
    if (event.target.id == 'ingredients-up-area') {
        var element = ingredientsArea;
    }
    else {
        var element = stepsArea;
    }

    element.scrollTop -= element.offsetHeight;
    return false;
}

function resize()
{
    var middle = window.innerHeight / 2;

    if (ingredientsAreaHeight > middle) {
        ingredients.style.height = '50%';
        steps.style.height = '50%';
    }
    else {
        ingredients.style.height = ingredientsAreaHeight +'px';
        steps.style.height = (window.innerHeight - ingredients.offsetHeight) +'px'; 
    }
}

ingredientsUpArea.addEventListener('click', scrollUp, false);
ingredientsDownArea.addEventListener('click', scrollDown, false);
stepsUpArea.addEventListener('click', scrollUp, false);
stepsDownArea.addEventListener('click', scrollDown, false);
ingredientsArea.style.overflow = 'hidden';
ingredientsArea.style.height = '100%';

resize();

window.addEventListener('resize', function(event) {
    resize();
});

