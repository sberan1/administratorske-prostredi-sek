<?php

namespace App\UI\Faculty;

use App\Core\Model\Entity\Faculty;
use App\UI\BasePresenter;
use Nette\Security\User as NetteUser;
use Nettrine\ORM\EntityManagerDecorator;

class FacultyPresenter extends BasePresenter
{
    private const ITEMS_PER_PAGE = 15;

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }
    public function renderDefault(int $page=1): void
    {
        $qb = $this->em->getRepository(Faculty::class)
            ->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $this->template->faculties = $qb->getQuery()->getResult();
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(Faculty::class)->count([]) / self::ITEMS_PER_PAGE);
    }

    public function actionEdit(string $id): void
    {
        $this->redirect('EditFaculty:', $id);
    }
    public function actionAdd(): void
    {
        $this->redirect('EditFaculty:');
    }



}
