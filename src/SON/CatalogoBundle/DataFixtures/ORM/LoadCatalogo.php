<?php
/**
 * Created by PhpStorm.
 * User: Abner
 * Date: 29/04/14
 * Time: 23:42
 */

namespace SON\CatalogoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SON\CatalogoBundle\Entity\Catalogo;

class LoadCatalogo extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $user = $this->getReference('user-user');
        $catalogo = new Catalogo;
        $catalogo->setName("Quadros futuristas")
            ->setDescricao("Acervo de quadros futuristas")
            ->setLancamento(new \DateTime("now"))
            ->setImageName("futurista.png")
            ->setAutor($user)
        ;

        $catalogo2 = new Catalogo;
        $catalogo2->setName("Quadros antigos")
            ->setDescricao("Acervo de quadros antigos")
            ->setLancamento(new \DateTime("yesterday noon"))
            ->setImageName("antigos.png")
            ->setAutor($user)
        ;

        $manager->persist($catalogo);
        $manager->persist($catalogo2);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 20;
    }
}