<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Approvisionnement;
use App\Entity\Fournisseur;
use App\Entity\LigneAppro;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* =====================
           FOURNISSEURS
        ====================== */
        $fournisseurs = [];

        foreach ([
            'Textiles Dakar',
            'Mercerie Centrale',
            'Tissus Premium',
            'Couture Express'
        ] as $nom) {
            $f = (new Fournisseur())->setNom($nom);
            $manager->persist($f);
            $fournisseurs[] = $f;
        }

        /* =====================
           ARTICLES
        ====================== */
        $articles = [];

        foreach ([
            'Tissu Wax',
            'Fil',
            'Bouton',
            'Fermeture',
            'Dentelle',
            'Élastique'
        ] as $libelle) {
            $a = (new Article())
                ->setLibelle($libelle)
                ->setPrix(rand(500, 5000));

            $manager->persist($a);
            $articles[] = $a;
        }

        /* =====================
           APPROVISIONNEMENTS
        ====================== */
        $referenceIndex = 1;

        for ($i = 0; $i < 15; $i++) {

            $appro = new Approvisionnement();
            $appro->setReference(sprintf('APP-2023-%03d', $referenceIndex++));
            $appro->setDate(
                new \DateTimeImmutable(sprintf('-%d days', rand(1, 60)))
            );
            $appro->setStatut(rand(0, 1) ? 'RECU' : 'EN_ATTENTE');
            $appro->setFournisseur(
                $fournisseurs[array_rand($fournisseurs)]
            );

            $manager->persist($appro);

            /* =====================
               LIGNES D’APPRO
            ====================== */
            $nbLignes = rand(2, 5);
            $total = 0;

            $usedArticles = [];

            for ($j = 0; $j < $nbLignes; $j++) {

                $article = $articles[array_rand($articles)];

                // éviter le même article deux fois dans le même appro
                if (in_array($article, $usedArticles, true)) {
                    continue;
                }

                $usedArticles[] = $article;

                $quantite = rand(5, 30);
                $prix = $article->getPrix();

                $ligne = new LigneAppro();
                $ligne->setArticle($article);
                $ligne->setApprovisionnement($appro);
                $ligne->setQuantite($quantite);
                $ligne->setPrixUnitaire($prix);

                $total += $quantite * $prix;

                $manager->persist($ligne);
            }

            $appro->setTotal($total);
        }

        $manager->flush();
    }
}
