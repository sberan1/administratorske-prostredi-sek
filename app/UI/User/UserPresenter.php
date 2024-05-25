<?php

namespace App\UI\User;

use App\Core\Model\Entity\User;
use Nette\Application\UI\Presenter;
use Nettrine\ORM\EntityManagerDecorator;

class UserPresenter extends Presenter
{
    private EntityManagerDecorator $em;

    public function __construct(EntityManagerDecorator $em)
    {
        $this->em = $em;
    }

    public function actionEdit(string $id): void
    {
        // Pass the user to the template
        //$this->template->user = $user;
        $this->redirect('EditUser:', $id);
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
}
