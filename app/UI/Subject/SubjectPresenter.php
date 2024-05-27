<?php

namespace App\UI\Subject;

use App\Core\Model\Entity\Subject;
use App\UI\BasePresenter;

class SubjectPresenter extends BasePresenter
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
        $qb = $this->em->getRepository(Subject::class)
            ->createQueryBuilder('s')
            ->select(['s', 'rs', 'sem'])
            ->leftJoin('s.recommendedSemester', 'rs')
            ->leftJoin('rs.A', 'sem')
            ->orderBy('s.name', 'ASC')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $subjects = $qb->getQuery()->getResult();
        $this->template->subjects = $subjects;
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(Subject::class)->count([]) / self::ITEMS_PER_PAGE);
    }

    public function actionEdit(string $id): void
    {
        $this->redirect('EditSubject:', $id);
    }

    public function actionAdd(): void
    {
        $this->redirect('EditSubject:');
    }

    public function actionDelete(string $id): void
    {
        $subject = $this->em->getRepository(Subject::class)->find($id);

        if ($subject === null) {
            $this->flashMessage('Předmět s poskytnutým ID nebyl nalezen', 'error');
        } else {
            $this->em->remove($subject);
            $this->em->flush();
            $this->flashMessage('Předmět byl úspěšně smazán', 'success');
        }

        $this->redirect('Subject:');
    }
}
