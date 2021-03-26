<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Keywords;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        dd($options['option_var']);
//        die();
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => "appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"]
            ])
            ->add('intro', TextareaType::class, [
                'attr' => ['rows' => '3',
                'class' => "appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"]
            ])
//            ->add('slug')
            ->add('content', CKEditorType::class, array(
                'config' => array(
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => array(
                        'instance' => 'form',
                        'homeFolder' => $options['option_var']
                    )
                ),
            ),
            )
//            ->add('created_at')
//            ->add('updated_at')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
//                'download_label' => '...',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'articlespreview',
            ])
//            ->add('imageFile', VichImageType::class, [
//                'required' => false,
//                'download_link' => false,
//                'image_uri' => false
//            ])
//            ->add('Users')
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC' );
                },
                'label' => 'Categories',
                'by_reference' => false,
                'attr' => [
                    'class' => 'select2-cats relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm',
                    'style' => 'color: black !important;'
                ]

            ])
            ->add('keywords', EntityType::class, [
                'class' => Keywords::class,
//                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'keyword',
                'query_builder' => function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('k')
                        ->orderBy('k.keyword', 'ASC' );
                },
                'label' => 'keywords',
                'by_reference' => false,
                'attr' => [
                    'class' => 'select2-keyword relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
            'option_var' => false,
        ]);
    }
}
