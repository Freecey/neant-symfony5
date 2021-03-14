<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Controller\Admin\Field\CKEditorField;

class ArticlesCrudController extends AbstractCrudController
{

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ;
    }

    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
//            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextareaField::new('intro'),
//            TextEditorField::new('content', 'content')
//                ->setFormType(CKEditorType::class),
//            TextareaField::new('content')
            TextEditorField::new('content')->setFormType(CKEditorType::class),
//            CKEditorField::new('content')->hideOnIndex(),
//            CodeEditorField::new('content'),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            AssociationField::new('Users'),
            AssociationField::new('categories'),
            AssociationField::new('keywords')
        ];
    }
}
