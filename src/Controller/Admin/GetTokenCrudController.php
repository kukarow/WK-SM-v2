<?php

namespace App\Controller\Admin;

use App\Entity\GetToken;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GetTokenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GetToken::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Налаштування')
            ->setEntityLabelInPlural('Параметри для отримання ключа')
            ->setPageTitle('index', 'Налаштування з сервером ДЕ, для отримання токена')

        ->setPaginatorPageSize(10);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
           // IdField::new('serverDe','lol'),

            TextField::new('serverDe','Адресса сервера')->hideOnDetail(),

           // DateTimeField::new('srverDe','Адресса сервера dthhjdghjdgfhjdf')->onlyOnDetail(),
            TextField::new('login','Логін'),
            TextField::new('password','Пароль'),
           // TextEditorField::new('Login'),
        ];
    }

}
