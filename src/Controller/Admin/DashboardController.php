<?php

namespace App\Controller\Admin;
use App\Entity\GetToken;
use App\Entity\GetData;
use App\Entity\VirtualRoom;



use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
        return $this->render('admin/dashboard.html.twig');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('(R+)');
        //->setTitle('ACME Corp.');
    }

    public function configureMenuItems(): iterable
    {
       // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

         yield MenuItem::linkToDashboard('VirtualRoom', 'fa fa-home');
         yield MenuItem::linkToCrud('Клієнт', 'fa fa-user', VirtualRoom::class);
        //FormField::addTab('Налаштування живлення','plug');
        yield MenuItem::linkToCrud('GetToken', 'fa fa-file-text', GetToken::class);
        yield MenuItem::linkToCrud('GetData', 'fa fa-file-text', GetData::class);
       // return [
         //   MenuItem::linkToCrud('VirtualRoom', 'fa fa-file-text', VirtualRoom::class),
       //     MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

     //       MenuItem::section('VirtualRoom'),
      //      MenuItem::linkToCrud('VirtualRoom', 'fa fa-tags', VirtualRoom::class),
         //   MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class),

         //   MenuItem::section('Users'),
          //  MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
           // MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
       // ];
    }
}
