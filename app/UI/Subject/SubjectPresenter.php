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
        $sql = '
        SELECT s.id, sem.id AS semester_id, s.name, sem.name AS semester_name, s.code, c.name as course_name
        FROM "Subject" AS s
        JOIN "_RecommendedSemester" AS rs ON s.id = rs."B"
        JOIN "Semester" AS sem ON rs."A" = sem.id
        JOIN "Course" AS c ON sem."coursesId" = c.id;
        ';

        $subjects = $this->em->getConnection()->prepare($sql)->executeQuery()->fetchAllAssociative();
        //bdump($subjects);
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

        if ($subject !== null) {
            $this->em->remove($subject);
            $this->em->flush();
        }


        $this->redirect('Subject:');
    }
}
