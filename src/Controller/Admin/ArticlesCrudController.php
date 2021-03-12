<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Users;
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

class ArticlesCrudController extends AbstractCrudController
{

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
//             TextareaField::new('content')->onlyOnForms()->setFormType(CKEditorType::class),
            TextEditorField::new('content'),
//            CodeEditorField::new('content'),
            TextareaField::new('imageFile')->setFormType(VichImageType::class),
            AssociationField::new('Users'),
            AssociationField::new('categories'),
            AssociationField::new('keywords')
        ];
    }
}
