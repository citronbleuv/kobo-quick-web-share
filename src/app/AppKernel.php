<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

require __DIR__.'/../vendor/autoload.php';

class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle()
        );

        return $bundles;
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        // PHP equivalent of config.yml
        $c->loadFromExtension('framework', array(
            'secret' => '129$C38Cf29Ffh#*$fj1JFCjf28',
            'templating' => [
                'engines' => ['php']
            ]
        ));
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/', 'kernel:viewAction', 'view');
        $routes->add('/edit', 'kernel:editAction');
    }

    public function viewAction()
    {
        $receipe = $this->getReceipe();

        if ($receipe['nbpersonWant'] != $receipe['nbperson']) {

            $ingredients = $this->changeProportion($receipe, 'ingredients');
            $steps = $this->changeProportion($receipe,  'steps');
        }
        else {
            $ingredients = $receipe['ingredients'];
            $steps = $receipe['steps'];
        }

		$ingredients = str_replace("\n", '<br>', trim($ingredients));
		$steps = str_replace("\n", '<br>', trim($steps));

        return $this->container->get('templating')->renderResponse('view.html.php', [
			'ingredients' => $ingredients,
			'steps' => $steps,
			'receipe' => $receipe
		]);
    }

    public function editAction()
    {
        $receipe = $this->getReceipe();

        if ( ! $receipe) {
            $receipe = [
                'ingredients' => '',
                'steps' => '',
                'nbperson' => 1,
                'nbpersonWant' => 1
            ];
        }

        if ($_POST) {

            $nbperson = (int) $_POST['nbperson'];
            if ( ! $nbperson) {
                $nbperson = 1;
            }
            $nbpersonWant = (int) $_POST['nbpersonWant'];
            if ( ! $nbpersonWant) {
                $nbperson = $nbpersonWant;
            }

            $receipe['ingredients'] = $this->filterText($_POST['ingredients']);
            $receipe['steps'] = $this->filterText($_POST['steps']);
            $receipe['nbperson'] = $nbperson;
            $receipe['nbpersonWant'] = $nbpersonWant;

            $this->persistReceipe($receipe);
        }

        return $this->container->get('templating')->renderResponse('edit.html.php', [
            'steps' => $receipe['steps'],
            'ingredients' => $receipe['ingredients'],
            'nbperson' => $receipe['nbperson'],
            'nbpersonWant' => $receipe['nbpersonWant'],
        ]);
    }

    private function getReceipe()
    {
        $contents = @file_get_contents(dirname(__DIR__) .'/data/receipe.txt');
        $contents = json_decode($contents, true);
        return $contents;
    }

    private function persistReceipe($receipe)
    {
        $contents = json_encode($receipe);
        file_put_contents(dirname(__DIR__) .'/data/receipe.txt', $contents);
    }

	private function filterText($text)
    {
        $text = preg_replace('/ +/', ' ', $text);
        $text = preg_replace('/^\n+/', "\n", $text);
        $text = preg_replace('/ *\n */', "\n", $text);
        $text = preg_replace('/ $/', '', $text);
        return $text;
    }

	private function formatNumber($number)
	{
        if (strpos($number, '/') !== false) {
            $number = explode('/', $number);
            return ((int) $number[0] / (int) $number[1]);
        }
        return (double) $number;
	}

    private function changeProportion($receipe, $type = 'ingredients')
    {
        $text = $receipe[$type];

        $units  = 'g|kg|gr|gramme';
        $units .= '|l|cl|ml|litres?';
        $units .= '|p(?:a|â){1}tes?|cuillères?|(?:jaunes? (?:d\')?)?(?:oe|œ)ufs?|gousses?|c ?(?:a|à) ?s|pincées?';

        $text = preg_replace_callback('/(([0-9.\/]+) *('. $units .'))([.,;:]|\s|$)/', function($matches) use ($receipe) {

            $valueReceipe = $this->formatNumber($matches[2]);
            $valueGet = (($valueReceipe * $receipe['nbpersonWant']) / $receipe['nbperson']);
            $unit = $matches[3];

            return '<strong>'. round($valueGet, 2) .' '. $unit .'</strong>'. $matches[4];

        }, $text);

        if ($type == 'ingredients') {

            $text = preg_replace_callback('/(^|\n)(([0-9.\/]+) *('. $units .'){0})([\s.,;:]|$)/', function($matches) use ($receipe) {

                $valueReceipe = $this->formatNumber($matches[3]);
                $valueGet = (($valueReceipe * $receipe['nbpersonWant']) / $receipe['nbperson']);

                return $matches[1] .'<strong>'. round($valueGet, 2) .'</strong>'. $matches[5];

            }, $text);
        }

        return $text;
    }
}
