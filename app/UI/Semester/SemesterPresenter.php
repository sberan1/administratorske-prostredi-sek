<?php

namespace App\UI\Semester;

use App\Core\Model\Entity\Semester;
use App\UI\BasePresenter;


class SemesterPresenter extends BasePresenter
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
        $qb = $this->em->getRepository(Semester::class)
            ->createQueryBuilder('s')
            ->select(['s', 'c'])
            ->leftJoin('s.courses', 'c')
            ->orderBy('c.name', 'ASC')
            ->addOrderBy('s.name', 'ASC')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $this->template->semesters = $qb->getQuery()->getResult();
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(Semester::class)->count([]) / self::ITEMS_PER_PAGE);
    }

    public function actionEdit(string $id): void
    {
        $this->redirect('EditSemester:', $id);
    }

    public function actionAdd(): void
    {
        $this->redirect('EditSemester:');
    }

    public function actionDelete(string $id): void
    {
        $semester = $this->em->getRepository(Semester::class)->find($id);

        if ($semester !== null) {
            $this->em->remove($semester);
            $this->em->flush();
        }

        $this->redirect('Semester:');
    }
}
