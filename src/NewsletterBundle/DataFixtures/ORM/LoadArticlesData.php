<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NewsletterBundle\Entity\Article;

class LoadUserData implements FixtureInterface
{
public function load(ObjectManager $manager)
{

    $article = new Article();
    $article->setBody("test body");
    $article->setTitle("test title");

    $manager->persist($article);
    $manager->flush();
    }
}