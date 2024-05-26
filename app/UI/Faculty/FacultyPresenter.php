<?php

namespace App\UI\Faculty;

use App\Core\Model\Entity\Faculty;
use App\UI\BasePresenter;
use Nette\Security\User as NetteUser;
use Nettrine\ORM\EntityManagerDecorator;

class FacultyPresenter extends BasePresenter
{
    private EntityManagerDecorator $em;
    private NetteUser $user;
    private const ITEMS_PER_PAGE = 15;
    public function __construct(EntityManagerDecorator $em, NetteUser $user)
    {
        $this->em = $em;
        $this->user = $user;
    }

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }
    public function renderDefault(int $page=1): void
    {
        $data = $this->user->getIdentity()->getData();
        $this->template->name = $data["firstName"] . " " . $data['lastName'] ?? "ADMIN";

        $this->template->links = [
            ['presenter' => 'Home:', 'name' => 'Home'],
            ['presenter' => 'Faculty:', 'name' => 'Fakulty'],
            ['presenter' => 'Course:', 'name' => 'Studijní obory'],
            ['presenter' => 'Semester:', 'name' => 'Semestry'],
            ['presenter' => 'Subject:', 'name' => 'Předměty'],
            ['presenter' => 'SubjectQuestion:', 'name' => 'Jádrové výstupy'],
            ['presenter' => 'Competence:', 'name' => 'Kompetence'],
        ];

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
