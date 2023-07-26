<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Article;
use App\Entity\Category;
use Faker\Core\File;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add(
                'content',
                CKEditorType::class,
                array(
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'basic',
                    )
                )
            )
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control mt-3 mb-3'
                ],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Auteur',
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
            ])


            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => 'Titre de l\'article',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('isPublished', CheckboxType::class, [
                'required' => false,
                'label' => 'Voulez-vous publier l\'article ?',
                'attr' => [
                    'class' => 'form-check-input mx-3 mb-3',
                    'type' => 'checkbox'
                ]
            ])



            ->add('Publier', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary rounded-pill mb-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
