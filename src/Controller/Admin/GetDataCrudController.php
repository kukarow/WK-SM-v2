<?php

namespace App\Controller\Admin;

use App\Entity\GetData;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GetDataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GetData::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Налаштування')
            ->setEntityLabelInPlural('Параметри для отримання данних')
            ->setPageTitle('index', 'Налаштування з сервером ДЕ, для отримання данних')

            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('authorizationServer','Сервер авторизації'),
            TextField::new('login','Логін'),
            TextField::new('password','Пароль'),
            TextField::new('token','Токен')
           // TextEditorField::new('description'),
        ];
    }

}
