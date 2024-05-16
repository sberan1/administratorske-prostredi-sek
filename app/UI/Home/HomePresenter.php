<?php declare(strict_types=1);

namespace App\UI\Home;

use App\Core\Model\Entity\UserEntity;
use App\UI\BasePresenter;
use Nette;
use Nettrine\ORM\EntityManagerDecorator;


final class HomePresenter extends BasePresenter
{

    public function __construct(
        private readonly EntityManagerDecorator $em
    )
    {
    }

    public function actionDefault()
    {
        $user = new UserEntity();
        $user->setName('John Doe');
        $this->em->persist($user);
        $this->em->flush();

        $this->template->userEntity = $user;
    }
}
