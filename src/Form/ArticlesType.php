<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Keywords;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            ->add('content', CKEditorType::class)
//            ->add('created_at')
//            ->add('updated_at')
            ->add('imageFile', VichFileType::class)
//            ->add('Users')
            ->add('keywords', EntityType::class, [
                'class' => Keywords::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
