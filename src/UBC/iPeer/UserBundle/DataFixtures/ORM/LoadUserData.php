<?php

namespace UBC\iPeer\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UBC\iPeer\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setFirstName("Admin");
        $userAdmin->setLastName("Prime");
        $userAdmin->setEmail("admin@ipeer.ubc");

        $manager->persist($userAdmin);
        $manager->flush();
    }
}