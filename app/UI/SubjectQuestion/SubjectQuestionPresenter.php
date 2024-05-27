<?php

namespace App\UI\SubjectQuestion;

use App\Core\Model\Entity\SubjectQuestion;
use App\UI\BasePresenter;

class SubjectQuestionPresenter extends BasePresenter
{
    private const ITEMS_PER_PAGE = 15;

    public function renderDefault(int $page = 1): void
    {
        $qb = $this->em->getRepository(SubjectQuestion::class)
            ->createQueryBuilder('sq')
            ->select(['sq', 's'])
            ->leftJoin('sq.subject', 's')
            ->orderBy('sq.title', 'ASC')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $subjectQuestions = $qb->getQuery()->getResult();
        $this->template->subjectQuestions = $subjectQuestions;
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(SubjectQuestion::class)->count([]) / self::ITEMS_PER_PAGE);
    }

    public function actionAdd(): void
    {
        $this->redirect('EditSubjectQuestion:');
    }

    public function actionEdit(string $id): void
    {
        $this->redirect('EditSubjectQuestion:', $id);
    }

    public function actionDelete(string $id): void
    {
        $subjectQuestion = $this->em->getRepository(SubjectQuestion::class)->find($id);

        if ($subjectQuestion === null) {
            $this->flashMessage('Subject question with provided ID was not found', 'error');
        } else {
            $this->em->remove($subjectQuestion);
            $this->em->flush();
            $this->flashMessage('Subject question was successfully deleted', 'success');
        }

        $this->redirect('SubjectQuestion:');
    }
}
