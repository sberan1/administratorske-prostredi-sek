<?php declare(strict_types=1);

namespace App\UI\Home;

use App\Core\Model\Entity\User;
use Nette\Security\User as NetteUser;
use App\UI\BasePresenter;
use Nettrine\ORM\EntityManagerDecorator;
use Ublaboo\DataGrid\DataGrid;


final class HomePresenter extends BasePresenter
{
    private NetteUser $user;

    public function __construct(
        private readonly EntityManagerDecorator $em,
        NetteUser $user
    )
    {
        $this->user = $user;
    }

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }

    public function renderDefault()
    {
        $this->template->setFile(__DIR__ . '/../Template/template.latte');
        bdump($this->user->getIdentity()->getData());
        $this->template->name = $this->user->getIdentity()->getData()['\x00App\Core\Model\Entity\User\x00firstName'];

        // Define the links for the layout bar
        $this->template->links = [
            ['presenter' => 'Page1', 'name' => 'Page 1'],
            ['presenter' => 'Page2', 'name' => 'Page 2'],
            ['presenter' => 'Page3', 'name' => 'Page 3'],
            // Add more links as needed
        ];
        //$this->template->name = $this->user->getIdentity()->getData()['email'];
    }

    public function actionDefault()
    {
        $this->template->users = $this->em->getRepository(User::class)->findAll();

        $qb = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select(['u', 'aus', 'f'])
            ->leftJoin('u.activeUserSemester', 'aus')
            ->leftJoin('u.faculty', 'f');

        $this->template->users2 = $qb->getQuery()->getResult();

    }

    public function createComponentSimpleGrid()
    {
        $grid = new DataGrid($this, 'simpleGrid');

        $qb = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select(['u', 'aus', 'f'])
            ->leftJoin('u.activeUserSemester', 'aus')
            ->leftJoin('u.faculty', 'f');

        $grid->setDataSource($qb);

        $grid->addColumnText('firstName', 'Name')
            ->setFilterText();
        $grid->addColumnText('lastName', 'Last')
            ->setFilterText();
        $grid->addColumnText('faculty', 'Faculty', 'faculty.name')
            ->setFilterText();

        $grid->setPagination(true);


        return $grid;
    }


}
