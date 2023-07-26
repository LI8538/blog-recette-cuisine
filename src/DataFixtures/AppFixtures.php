<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create($fakerLocale = 'fr_FR');

        // ARTICLES
        $articles = [
            [
                'title' => 'Délicieuses pâtes à la carbonara',
                'content' => 'Découvrez le plaisir de déguster des pâtes à la carbonara faites maison. Faites bouillir des pâtes al dente, puis mélangez-les avec une sauce crémeuse à base d\'œufs, de parmesan, de pancetta croustillante et de poivre fraîchement moulu. Savourez ce plat italien classique et réconfortant qui plaira à toute la famille. Buon appetito!',
                'image' => '3.jpeg'
            ],
            [
                'title' => 'Risotto crémeux aux champignons',
                'content' => 'Laissez-vous tenter par un délicieux risotto crémeux aux champignons. Faites revenir des champignons frais dans du beurre jusqu\'à ce qu\'ils soient tendres. Ajoutez ensuite du riz Arborio et du bouillon chaud progressivement en remuant jusqu\'à ce que le riz soit crémeux et al dente. Terminez en ajoutant du parmesan râpé et du persil frais pour une touche de saveur. Servez chaud et régalez-vous.',
                'image' => '4.jpeg'
            ],
            [
                'title' => 'Poulet rôti aux herbes',
                'content' => 'Préparez un savoureux poulet rôti aux herbes pour un repas copieux. Farcissez l\'intérieur du poulet avec des herbes fraîches telles que le thym, le romarin et l\'ail. Assaisonnez la peau du poulet avec du sel, du poivre et de l\'huile d\'olive. Faites rôtir au four jusqu\'à ce que le poulet soit doré et juteux. Accompagnez-le de légumes rôtis pour un festin délicieux.',
                'image' => '5.jpeg'
            ],
            [
                'title' => 'Gâteau au chocolat fondant',
                'content' => 'Succombez à la tentation d\'un gâteau au chocolat fondant qui ravira les amateurs de chocolat. Mélangez du beurre fondu avec du sucre et des œufs, puis incorporez de la farine et du cacao en poudre. Versez la pâte dans un moule et faites cuire jusqu\'à ce que le gâteau ait une texture moelleuse à l\'extérieur et fondante à l\'intérieur. Dégustez-le tiède avec une boule de glace à la vanille pour une expérience ultime.',
                'image' => '6.jpeg'
            ],
            [
                'title' => 'Salade de quinoa aux légumes frais',
                'content' => 'Préparez une salade de quinoa saine et délicieuse avec des légumes frais. Faites cuire le quinoa selon les instructions, puis mélangez-le avec des légumes croquants tels que des concombres, des tomates cerises, des poivrons et des oignons rouges. Assaisonnez avec une vinaigrette légère à base de jus de citron, d\'huile d\'olive et d\'herbes aromatiques. Cette salade colorée et nutritive est parfaite pour les repas estivaux.',
                'image' => '7.jpeg'
            ],
            [
                'title' => 'Pizza maison aux quatre fromages',
                'content' => 'Préparez une pizza maison savoureuse avec une garniture généreuse de quatre fromages. Étalez de la sauce tomate sur une pâte à pizza fraîche, puis ajoutez du fromage mozzarella, du gorgonzola, du parmesan et du fromage de chèvre. Agrémentez de quelques feuilles de basilic frais avant de faire cuire au four jusqu\'à ce que le fromage soit fondu et la croûte croustillante. Régalez-vous avec cette pizza gourmande.',
                'image' => '8.jpeg'
            ],
            [
                'title' => 'Smoothie aux fruits exotiques',
                'content' => 'Rafraîchissez-vous avec un délicieux smoothie aux fruits exotiques. Mélangez de l\'ananas frais, de la mangue juteuse et de la papaye avec du yaourt nature et du lait de coco. Ajoutez une touche de miel pour sucrer légèrement le mélange. Mixez jusqu\'à obtention d\'une texture onctueuse et savourez ce délicieux breuvage tropical rempli de vitamines.',
                'image' => '9.jpeg'
            ],
            [
                'title' => 'Tarte aux pommes maison',
                'content' => 'Préparez une tarte aux pommes classique et réconfortante. Étalez une pâte brisée dans un moule à tarte, puis garnissez-la de tranches de pommes sucrées. Saupoudrez de sucre et de cannelle, puis ajoutez quelques noisettes de beurre avant de couvrir avec une deuxième abaisse de pâte. Faites cuire jusqu\'à ce que la tarte soit dorée et les pommes tendres. Dégustez-la tiède avec une boule de glace à la vanille.',
                'image' => '10.jpeg'
            ],
        ];



        // CATÉGORIES
        // Je liste les catégories que je veux créer
        $categories = [
            'amuse-bouche',
            'Entrée',
            'plat',
            'dessert',
            'cocktail'
        ];

        foreach ($categories as $item) {

            // Je crée un nouvel objet catégorie
            $categorie = new Category();
            // J'utilise la méthode setName pour définir le nom de la catégorie
            $categorie->setName($item);
            // J'enregistre la catégorie en base de données avec Doctrine
            $manager->persist($categorie);
        }



        foreach ($articles as $item) {
            // AUTEURS
            // Je crée un nouvel objet auteur
            $auteur = new Author();
            // J'utilise la méthode setName pour définir le nom de l'auteur
            $auteur->setName($faker->name());
            // J'enregistre l'auteur en base de données avec Doctrine
            $manager->persist($auteur);

            // Je crée un nouvel objet article
            $article = new Article();
            // J'utilise la méthode setTitle pour définir le titre de l'article
            $article->setTitle($item['title']);
            // J'utilise la méthode setContent pour définir le contenu de l'article
            $article->setContent($item['content']);
            // J'utilise la méthode setCategory pour définir la catégorie de l'article
            $article->setCategory($categorie);
            // J'utilise la méthode setAuthor pour définir l'auteur de l'article
            $article->setAuthor($auteur);
            // J'utilise la méthode setAuthor pour définir l'auteur de l'article
            $article->setImage($item['image']);
            // J'enregistre l'article en base de données avec Doctrine
            $manager->persist($article);
        }
        $manager->flush();
    }
}
