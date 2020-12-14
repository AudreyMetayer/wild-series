<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Program;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
            'category' => 'categorie_4',
            'country' => 'USA',
            'year' => 2009,
            'poster' => 'https://m.media-amazon.com/images/I/61tRV7ZclaL._AC_SY679_.jpg',
        ],
        'The Haunting Of Hill House' => [
            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
            'category' => 'categorie_4',
            'country' => 'USA',
            'year' => 2010,
            'poster' => 'https://fr.web.img2.acsta.net/pictures/18/09/19/18/46/2766026.jpg',
        ],
        'American Horror Story' => [
            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',
            'category' => 'categorie_4',
            'country' => 'USA',
            'year' => 2012,
            'poster' => 'https://fr.web.img4.acsta.net/pictures/18/09/05/16/15/4496847.jpg',
        ],
        'Love Death And Robots' => [
            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
            'category' => 'categorie_4',
            'country' => 'USA',
            'year' => 2008,
            'poster' => 'https://fr.web.img2.acsta.net/pictures/19/02/15/09/58/1377321.jpg',
        ],
        'Penny Dreadful' => [
            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',
            'category' => 'categorie_4',
            'country' => 'USA',
            'year' => 2010,
            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/81JOozAtc3L.jpg',
        ],
        'Fear The Walking Dead' => [
            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
            'category' => 'categorie_4',
            'country' => 'USA',
            'year' => 2020,
            'poster' => 'https://fr.web.img6.acsta.net/pictures/20/09/25/11/43/3207723.jpg',

        ],
    ];

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $i=0;
        foreach (self::PROGRAMS as $title => $data) {

            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setCountry($data['country']);
            $program->setYear($data['year']);
            $program->setPoster($data['poster']);
            $program->setCategory($this->getReference('category_' . rand(0,count(CategoryFixtures::CATEGORIES)-1)));
            $manager->persist($program);
            $this->addReference('program_' . $i, $program);
            $i++;

        }

        $manager->flush();
    }




}