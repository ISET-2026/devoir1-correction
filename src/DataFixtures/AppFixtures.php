<?php

namespace App\DataFixtures;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const GRADES = [
        'Professeur',
        'Maître de conférences',
        'Maître assistant',
        'Assistant',
        'Chargé de cours',
        'Professeur associé',
    ];

    private const NIVEAUX = ['L1', 'L2', 'L3', 'M1', 'M2'];

    private const PRENOMS = [
        'Mohamed', 'Ahmed', 'Ali', 'Youssef', 'Omar', 'Khalil', 'Amine', 'Sami',
        'Karim', 'Nabil', 'Hichem', 'Rami', 'Tarek', 'Slim', 'Fares',
        'Fatma', 'Amira', 'Sara', 'Ines', 'Mariem', 'Nour', 'Rania', 'Yasmine',
        'Chaima', 'Sarra', 'Hana', 'Meryem', 'Dina', 'Lina', 'Salma',
    ];

    private const NOMS_FAMILLE = [
        'Ben Ali', 'Bouazizi', 'Trabelsi', 'Chaabane', 'Hamdi', 'Jebali',
        'Khelifi', 'Mansouri', 'Nouri', 'Saidi', 'Tounsi', 'Zouari',
        'Gharbi', 'Dridi', 'Ferchichi', 'Ayari', 'Belhaj', 'Chelbi',
        'Dahmani', 'Essid', 'Fakhfakh', 'Gasmi', 'Hadj', 'Jerbi',
        'Karoui', 'Lakhdari', 'Mahjoubi', 'Nasri', 'Othmani', 'Rahali',
    ];

    private const TITRES_PROJETS = [
        'Développement d\'une application de gestion scolaire',
        'Plateforme de e-learning interactive',
        'Système de gestion de bibliothèque',
        'Application mobile de covoiturage universitaire',
        'Outil de suivi des stages étudiants',
        'Plateforme de collaboration scientifique',
        'Application de gestion des emplois du temps',
        'Système de détection de plagiat',
        'Portail web de l\'université',
        'Application de gestion des examens en ligne',
    ];

    private const DESCRIPTIONS_PROJETS = [
        'Ce projet vise à concevoir et développer une application web permettant de gérer efficacement les processus administratifs liés à la scolarité universitaire.',
        'Création d\'une plateforme interactive permettant aux étudiants d\'accéder à des cours en ligne, des quiz et des ressources pédagogiques multimédias.',
        'Développement d\'un système complet de gestion de bibliothèque incluant le catalogage, les emprunts, les retours et la gestion des abonnés.',
        'Conception d\'une application mobile facilitant le covoiturage entre étudiants et membres du personnel universitaire.',
        'Mise en place d\'un outil web pour le suivi et l\'évaluation des stages effectués par les étudiants dans le cadre de leur formation.',
        'Création d\'une plateforme collaborative pour le partage de publications scientifiques et la mise en relation de chercheurs.',
        'Développement d\'un système intelligent de gestion et d\'optimisation des emplois du temps universitaires.',
        'Conception d\'un outil utilisant des algorithmes de traitement du langage naturel pour détecter le plagiat dans les travaux académiques.',
        'Refonte complète du portail web de l\'université avec une approche responsive et une expérience utilisateur modernisée.',
        'Développement d\'une plateforme sécurisée pour la gestion des examens en ligne avec surveillance automatisée.',
    ];

    public function load(ObjectManager $manager): void
    {
        $enseignants = $this->createEnseignants($manager, 30);
        $etudiants = $this->createEtudiants($manager, 100);
        $this->createProjets($manager, 10, $enseignants, $etudiants);

        $manager->flush();
    }

    /**
     * @return Enseignant[]
     */
    private function createEnseignants(ObjectManager $manager, int $count): array
    {
        $enseignants = [];

        for ($i = 0; $i < $count; $i++) {
            $prenom = self::PRENOMS[$i % count(self::PRENOMS)];
            $nom = self::NOMS_FAMILLE[$i % count(self::NOMS_FAMILLE)];

            $enseignant = new Enseignant();
            $enseignant->setNom($prenom . ' ' . $nom);
            $enseignant->setEmail(strtolower($this->slugify($prenom)) . '.' . strtolower($this->slugify($nom)) . '@univ.tn');
            $enseignant->setGrade(self::GRADES[array_rand(self::GRADES)]);

            $manager->persist($enseignant);
            $enseignants[] = $enseignant;
        }

        return $enseignants;
    }

    /**
     * @return Etudiant[]
     */
    private function createEtudiants(ObjectManager $manager, int $count): array
    {
        $etudiants = [];

        for ($i = 0; $i < $count; $i++) {
            $prenom = self::PRENOMS[array_rand(self::PRENOMS)];
            $nomIdx = ($i + 5) % count(self::NOMS_FAMILLE);
            $nom = self::NOMS_FAMILLE[$nomIdx];

            $etudiant = new Etudiant();
            $etudiant->setNom($prenom . ' ' . $nom);
            $etudiant->setEmail(strtolower($this->slugify($prenom)) . '.' . strtolower($this->slugify($nom)) . $i . '@etudiant.univ.tn');
            $etudiant->setNiveau(self::NIVEAUX[array_rand(self::NIVEAUX)]);

            $manager->persist($etudiant);
            $etudiants[] = $etudiant;
        }

        return $etudiants;
    }

    /**
     * @param Enseignant[] $enseignants
     * @param Etudiant[] $etudiants
     */
    private function createProjets(ObjectManager $manager, int $count, array $enseignants, array $etudiants): void
    {
        $statuts = [
            Projet::STATUT_EN_PREPARATION,
            Projet::STATUT_EN_COURS,
            Projet::STATUT_TERMINE,
        ];

        for ($i = 0; $i < $count; $i++) {
            $projet = new Projet();
            $projet->setTitre(self::TITRES_PROJETS[$i]);
            $projet->setDescription(self::DESCRIPTIONS_PROJETS[$i]);

            // Dates: projets répartis entre 2025 et 2026
            $startMonth = rand(1, 10);
            $startYear = rand(2025, 2026);
            $dateDebut = new \DateTime("$startYear-$startMonth-" . rand(1, 28));
            $dateFin = clone $dateDebut;
            $dateFin->modify('+' . rand(2, 6) . ' months');
            $projet->setDateDebut($dateDebut);
            $projet->setDateFin($dateFin);

            // Statut
            $projet->setStatut($statuts[$i % 3]);

            // Enseignant (chaque projet a un enseignant différent)
            $projet->setEnseignant($enseignants[$i % count($enseignants)]);

            // Ajouter entre 3 et 15 étudiants par projet
            $nbEtudiants = rand(3, 15);
            $startIdx = ($i * 10) % count($etudiants);
            for ($j = 0; $j < $nbEtudiants; $j++) {
                $idx = ($startIdx + $j) % count($etudiants);
                $projet->addEtudiant($etudiants[$idx]);
            }

            $manager->persist($projet);
        }
    }

    private function slugify(string $text): string
    {
        $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
