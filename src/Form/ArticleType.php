<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('author')
//            ->add('date_creation')
//            ->add('date_update')
            ->add('category', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'attr' => ['style' => "width:100%;",
                    'class' => "appearance-none bg-grey-lighter border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-blue-light"]
            ])
            ->add('intro', TextareaType::class, [
                'attr' => ['rows' => '3',
                    'style' => "width:100%;"]
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['rows' => '25',
                    'style' => "width:100%;"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Article::CATEGORY;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;

    }
}
