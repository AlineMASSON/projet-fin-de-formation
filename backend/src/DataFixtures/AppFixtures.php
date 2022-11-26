<?php

namespace App\DataFixtures;

use App\Entity\Coach;
use App\Entity\Collaboration;
use App\Entity\Review;
use App\Entity\Training;
use App\Entity\Triathlete;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * reset the auto increment value
     */
    private function truncate()
    {
        $this->connection->executeQuery('SET foreign_key_checks = 0');
        $this->connection->executeQuery('TRUNCATE TABLE user');
        $this->connection->executeQuery('TRUNCATE TABLE triathlete');
        $this->connection->executeQuery('TRUNCATE TABLE training');
        $this->connection->executeQuery('TRUNCATE TABLE coach');
        $this->connection->executeQuery('TRUNCATE TABLE collaboration');
        $this->connection->executeQuery('TRUNCATE TABLE review');
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncate();

        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$mjm2Y2Nbo5QWikCJ.M/ZQuxA.we0xHlnhqIjnKwh18WJDUE1Tqgiy');
        $user->setProfile(0);
        $user->setLastname('adminLastname');
        $user->setFirstname('adminFirstname');
        $user->setDateBirth(new DateTimeImmutable('2005-08-15T15:52:01+00:00'));
        $user->setDescription('Description admin');
        $user->setGender(rand(1, 2));
        $user->setCity('Paris');
        $manager->persist($user);

        $users = [];
        $num_array = [];
        for($i = 0; $i < 5; $i++) $num_array[$i] = 2;
        for($i = 5; $i < 20; $i++) $num_array[$i] = 1;
        shuffle($num_array);

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword('$2y$13$NmY6gQBoVvDVsmay4knIuuNFtM43H4fcjjtcD3Vgc86VNOuOF1sXS');
            $user->setProfile($num_array[$i]);
            $user->setLastname('userLastname' . $i);
            $user->setFirstname('userFirstname' . $i);
            $user->setDateBirth(new DateTimeImmutable('2005-08-15T15:52:01+00:00'));
            $user->setDescription('Description numéro' . $i);
            $user->setGender(rand(1, 2));
            $user->setCity('Paris');
            $manager->persist($user);
            $users[] = $user;
        }

        $triathletes = [];
        $coachs = [];

        foreach ($users as $user) {
            if ($user->getProfile() === 1) {
                $triathlete = new Triathlete();
                $triathlete->setPalmares('Palmares du traithlète');
                $triathlete->setWeight(rand(58, 100));
                $triathlete->setSize(rand(145, 190));
                $triathlete->setUser($user);
                $manager->persist($triathlete);
                $triathletes[] = $triathlete;
            }

            if ($user->getProfile() === 2) {
                $coach = new Coach();
                $coach->setSwim(rand(0, 1));
                $coach->setBike(rand(0, 1));
                $coach->setRun(rand(0, 1));
                $coach->setExperience('Experience du coach');
                $coach->setUser($user);
                $manager->persist($coach);
                $coachs[] = $coach;
            }
        }


        $sports = ['Natation', 'Cyclisme', 'Course à pied'];
        $feelings = ['Trop facile', 'Facile', 'Modéré', 'Difficile', 'Trop difficile'];
        $types = ['Entraînement', 'Compétition'];
        $tags = ['Endurance', 'Seuil', 'VMA', 'Force', 'Vélocité'];

        $trainings = [];

        foreach ($triathletes as $triathlete) {
            for ($i = 0; $i < 3; $i++) {
                $training = new Training();
                $training->setTitle('Title' . $i);
                $training->setDuration(rand(30, 180));
                $training->setDescription('Description' . $i);
                $training->setDate(new DateTime());
                $training->setSport($sports[rand(0, 2)]);
                $training->setIsPpg(rand(0, 1));
                $training->setFeeling($feelings[rand(0, 4)]);
                $training->setType($types[rand(0, 1)]);
                $training->setTag($tags[rand(0, 4)]);
                $training->setUser($triathlete->getUser());
                $training->setTriathlete($triathlete);
                $manager->persist($training);
                $trainings[] = $training;
            }
        }

        foreach ($coachs as $coach) {
            if (!$coach->isSwim() && !$coach->isBike() && !$coach->isRun()) {
                $coach->setRun(1);
                $manager->persist($coach);
            }
        }

        $collaborations = [];

        foreach ($coachs as $coach) {
            $sports = [];
            if ($coach->isSwim()) {
                $sports[] = 'Natation';
            }
            if ($coach->isBike()) {
                $sports[] = 'Cyclisme';
            }
            if ($coach->isRun()) {
                $sports[] = 'Course à pied';
            }

            foreach ($sports as $sport) {

                $collaboration = new Collaboration();
                $collaboration->setSport($sport);
                $collaboration->setCoach($coach);
                $collaboration->setTriathlete($triathletes[mt_rand(0, count($triathletes) - 1)]);
                $manager->persist($collaboration);
                $collaborations[] = $collaboration;
            }
        }

        foreach ($trainings as $training) {
            $review = new Review();
            $review->setContent('Contenu du commentaire du triathlète');
            $review->setUser($training->getTriathlete()->getUser());
            $review->setTraining($training);
            $manager->persist($review);
        }

        $manager->flush();


        foreach ($collaborations as $collaboration) {
            $trainings_by_coach = $manager->getRepository(Training::class)->findAllWhereCollaborationExists($collaboration->getCoach()->getId());
                foreach ($trainings_by_coach as $training) {
                $review = new Review();
                $review->setContent('Contenu du commentaire du coach');
                $review->setUser($collaboration->getCoach()->getUser());
                $review->setTraining($manager->getRepository(Training::class)->find(intval($training['id'])));
                $manager->persist($review);
            }
        }

        $training1 = new Training();
        $training1->setTitle('Footing');
        $training1->setDuration(60);
        $training1->setDescription('Courir une heure en aisance respiratoire');
        $training1->setDate(new DateTime());
        $training1->setSport('Course à pied');
        $training1->setIsPpg(0);
        $training1->setType('Entraînement');
        $training1->setTag('Endurance');
        $training1->setUser($triathlete->getUser());
        $training1->setTriathlete($triathletes[0]);
        $manager->persist($training1);

        $training3 = new Training();
        $training3->setTitle('Force');
        $training3->setDuration(60);
        $training3->setDescription('Echauffement 3000m suivi de 3 x 400m PP recup 3 minute');
        $training3->setDate(new DateTime());
        $training3->setSport('Natation');
        $training3->setIsPpg(0);
        $training3->setType('Entraînement');
        $training3->setTag('Force');
        $training3->setUser($triathlete->getUser());
        $training3->setTriathlete($triathletes[0]);
        $manager->persist($training3);

        $training4 = new Training();
        $training4->setTitle('Ballade cool pour tourner les jambes');
        $training4->setDuration(180);
        $training4->setDescription('3h souple, parcours assez plat');
        $training4->setDate(new DateTime('now +1 day'));
        $training4->setSport('Cyclisme');
        $training4->setIsPpg(0);
        $training4->setType('Entraînement');
        $training4->setTag('Endurance');
        $training4->setUser($triathlete->getUser());
        $training4->setTriathlete($triathletes[0]);
        $manager->persist($training4);

        $training2 = new Training();
        $training2->setTitle('Footing rythmé');
        $training2->setDuration(80);
        $training2->setDescription('20 minutes échauffement suivi de 5 x 4 minutes à 3\'50min/km recup 2 minutes');
        $training2->setDate(new DateTime('now +2 day'));
        $training2->setSport('Course à pied');
        $training2->setIsPpg(0);
        $training2->setType('Entraînement');
        $training2->setTag('Seuil');
        $training2->setUser($triathlete->getUser());
        $training2->setTriathlete($triathletes[0]);
        $manager->persist($training2);

        $training5 = new Training();
        $training5->setTitle('HT Force');
        $training5->setDuration(60);
        $training5->setDescription('10 minutes échauffement suivi de 8 x 4 minutes à 280W 60RPM recup 2 minutes + retour au calme');
        $training5->setDate(new DateTime('now +3 day'));
        $training5->setSport('Cyclisme');
        $training5->setIsPpg(0);
        $training5->setType('Entraînement');
        $training5->setTag('Force');
        $training5->setUser($triathlete->getUser());
        $training5->setTriathlete($triathletes[0]);
        $manager->persist($training5);

        $training6 = new Training();
        $training6->setTitle('Seuil en bassin');
        $training6->setDuration(60);
        $training6->setDescription('3000m, echauffement avec 3 x 800m en pull allongé, finir par 2 x 100 jambes');
        $training6->setDate(new DateTime('now +4 day'));
        $training6->setSport('Natation');
        $training6->setIsPpg(0);
        $training6->setType('Entraînement');
        $training6->setTag('Seuil');
        $training6->setUser($triathlete->getUser());
        $training6->setTriathlete($triathletes[0]);
        $manager->persist($training6);

        $training7 = new Training();
        $training7->setTitle('Sortie longue');
        $training7->setDuration(90);
        $training7->setDescription('Courir une heure et demi en aisance respiratoire');
        $training7->setDate(new DateTime('now +5 day'));
        $training7->setSport('Course à pied');
        $training7->setIsPpg(0);
        $training7->setType('Entraînement');
        $training7->setTag('Endurance');
        $training7->setUser($triathlete->getUser());
        $training7->setTriathlete($triathletes[0]);
        $manager->persist($training7);

        $manager->flush();
    }
}
