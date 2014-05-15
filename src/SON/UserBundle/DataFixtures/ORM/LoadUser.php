<?php
/**
 * Created by PhpStorm.
 * User: Abner
 * Date: 28/04/14
 * Time: 21:48
 */

namespace SON\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SON\UserBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{

    private $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user')
            ->setPassword($this->encodePassword($user,'user'))
            ->setIsActive(true)
            ->setEmail('user@son.com');

        $manager->persist($user);

        $this->addReference('user-user',$user);

        $admin = new User();
        $admin->setUsername('admin')
            ->setPassword($this->encodePassword($admin,'admin'))
            ->setIsActive(true)
            ->setRoles(array('ROLE_ADMIN'))
            ->setEmail('admin@son.com');

        $manager->persist($admin);

        $manager->flush();
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 10;
    }
}