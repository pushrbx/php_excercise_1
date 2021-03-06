<?php
/**
 * Created by PhpStorm.
 * User: Haku
 * Date: 2018. 10. 08.
 * Time: 17:47
 */

namespace App\Controller;


use App\Entity\Pokemon;
use PhpParser\Node\Expr\Isset_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PokeController
 * @package App\Controller
 * @Route(path="/pokemon")
 */
class PokeController extends Controller
{
    /**
     * @var string
     */
    private $filename ="../templates/poke/pokedata.txt";

    /**
     * @var array
     */
    private $pokemons;

    public function __construct()
    {
        if (!isset($this->pokemons)){
            $this->pokemons = $this->getPokemonsFromFile();
        }
    }

    /**
     * @Route(path="/", name="pokeIndex")
     * @param Request $request
     * @return Response
     */
    public function pokeIndexAction(Request $request) : Response{
        if (isset($this->pokemons)){
            var_dump($this->pokemons);
            return $this->render('poke/pokelist.html.twig', $this->pokemons["pokemons"]);
        }
        die("HUPSZ");
    }

    private function getPokemonsFromFile() : array {
        if (file_exists($this->filename)){
            $rows = file($this->filename, FILE_IGNORE_NEW_LINES);
            foreach ($rows as $row){
                $entity = explode("@", $row);
                $poke = new Pokemon();
                $poke->setName($entity[0]);
                $poke->setType($entity[1]);
                $poke->setAbilitytype($entity[2]);
                $poke->setWeight(doubleval($entity[3]));
                $poke ->setAtck(intval($entity[4]));
                $poke->setDef(intval($entity[5]));
                $returnarray["pokemons"][] = $poke;
            }
        }
        return $returnarray;
    }

}