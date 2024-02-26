<?php

namespace App\Controller\Admin;

use App\Entity\VirtualRoom;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;


use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class VirtualRoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VirtualRoom::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Кабінет')
            ->setEntityLabelInPlural('Параметри для налаштування кабінета')
            ->setPageTitle('index', 'Параметри віртуальних кабінетів')

            ->setPaginatorPageSize(20);
    }
    public function configureFields(string $pageName): iterable
    {
        return array(
           // IdField::new('id')->hideOnForm(),
            FormField::addTab('Налаштування кабінета','wrench'),

            //IdField::new('id','ID')->hideOnIndex(),
            //TextField::new('id','ID'),
            TextField::new('venID','VenID'),
            TextField::new('mac','MAC'),
            TextField::new('status','Статус'),
            TextField::new('clientAddress','IP адреса'),
            TextField::new('dataRoom','Данні кабінета')->hideOnIndex(),


            FormField::addTab('Відображення інформації','info'),
            BooleanField::new('userDesc','Відображати опис лікаря?')->hideOnIndex(),
            TextField::new('userDescMaxLengthTex','Яку кількість символів відображати в описі лікаря?')->hideOnIndex(),
            BooleanField::new('userName','Відображати П.І.Б ?')->hideOnIndex(),
            BooleanField::new('userPhoto','Відображати фото ?')->hideOnIndex(),
            BooleanField::new('userSpeciality','Відображати спеціалізацію лікаря ?')->hideOnIndex(),
            TextField::new('userSpecialityMaxLengthText','Яку кількість символів відображати в спеціалізації лікаря ?')->hideOnIndex(),
            BooleanField::new('venueName','Відображати номер кабінета ?')->hideOnIndex(),

            FormField::addTab('Налаштування живлення','plug'),
            TextField::new('turnOFFin','Час увімкненя клієнта')->hideOnIndex(),
            TextField::new('turnONin','Час вимкнення клієнта')->hideOnIndex(),

            FormField::addTab('Відео контент','video'),
            TextField::new('video','Відео')->hideOnIndex(),
            //TextEditorField::new('description'),
            FormField::addTab('Налаштування сторінки клієнта','image'),

            ImageField::new('background','зображення заднього фону')
                ->setBasePath('uploads/images/')
                ->setUploadDir(uploadDirPath: 'public/uploads/images/')
                ->setSortable(false)
                ->setFormTypeOption('required',false),

            ImageField::new('docFree', 'зображенння - лікар вільний')
                ->setBasePath('uploads/images/')
                ->setUploadDir(uploadDirPath: 'public/uploads/images/')
                ->setSortable(false)
                ->setFormTypeOption('required' ,false),
            ImageField::new('docBusy', 'зображення - лікар зайнятий')
                ->setBasePath('uploads/images/')
                ->setUploadDir(uploadDirPath: 'public/uploads/images/')
                ->setSortable(false)
                ->setFormTypeOption('required' ,false),
            ImageField::new('wait','зображення - статус зачекайте')
                ->setBasePath('uploads/images/')
                ->setUploadDir(uploadDirPath: 'public/uploads/images/')
                ->setSortable(false)
                ->setFormTypeOption('required' ,false),

        );
    }

}
