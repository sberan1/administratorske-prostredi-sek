<?php

namespace App\UI\Course;

use App\Core\Model\Entity\Course;
use App\UI\BasePresenter;

class CoursePresenter extends BasePresenter
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
        $qb = $this->em->getRepository(Course::class)
            ->createQueryBuilder('c')
            ->select(['c', 'f'])
            ->leftJoin('c.faculty', 'f')
            ->orderBy('f.name', 'ASC')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $this->template->courses = $qb->getQuery()->getResult();
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(Course::class)->count([]) / self::ITEMS_PER_PAGE);
    }

    public function actionEdit(string $id): void
    {
        $this->redirect('EditCourse:', $id);
    }

    public function actionAdd(): void
    {
        $this->redirect('EditCourse:');
    }

    public function actionDelete(string $id): void
    {
        $course = $this->em->getRepository(Course::class)->find($id);

        if ($course !== null) {
            $this->em->remove($course);
            $this->em->flush();
        }

        $this->redirect('Course:');
    }
}
