<?php declare(strict_types=1);

namespace App\UI\Home;

use App\Core\Model\Entity\User;
use Nette\Security\User as NetteUser;
use App\UI\BasePresenter;
use Nettrine\ORM\EntityManagerDecorator;
use Ublaboo\DataGrid\DataGrid;


final class HomePresenter extends BasePresenter
{
    private const ITEMS_PER_PAGE = 15;

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }

    public function renderDefault(int $page = 1)
    {

        $qb = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select(['u', 'f'])
            ->leftJoin('u.faculty', 'f')
            ->orderBy('u.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $this->template->users = $qb->getQuery()->getResult();
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(User::class)->count([]) / self::ITEMS_PER_PAGE);
    }

    public function actionDelete(string $id): void
    {
        // Fetch the user from the database
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            $this->error('User not found');
        }

        // Remove the user from the database
        $this->em->remove($user);
        $this->em->flush();

        // Redirect the user to the homepage
        $this->redirect('Home:');
    }
    public function actionEdit(string $id): void
    {
        $this->redirect('EditUser:', $id);
    }
}
