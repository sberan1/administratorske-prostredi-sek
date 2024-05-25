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
    private const ITEMS_PER_PAGE = 15;


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

    public function renderDefault(int $page = 1)
    {
        $data = $this->user->getIdentity()->getData();
        $this->template->name = $data["firstName"] . " " . $data['lastName'] ?? "ADMIN";

        $this->template->links = [
            ['presenter' => 'Home:', 'name' => 'Home'],
            ['presenter' => 'Faculty:', 'name' => 'Fakulty'],
            ['presenter' => 'Semester:', 'name' => 'Semestry'],
            ['presenter' => 'Course:', 'name' => 'Studijní obory'],
            ['presenter' => 'Subject:', 'name' => 'Předměty'],
            ['presenter' => 'SubjectQuestion:', 'name' => 'Jádrové výstupy'],
            ['presenter' => 'Competence:', 'name' => 'Kompetence'],
        ];

        $qb = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select(['u', 'f'])
            ->leftJoin('u.faculty', 'f')
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        $this->template->users = $qb->getQuery()->getResult();
        $this->template->currentPage = $page;
        $this->template->totalPages = ceil($this->em->getRepository(User::class)->count([]) / self::ITEMS_PER_PAGE);
    }


}
