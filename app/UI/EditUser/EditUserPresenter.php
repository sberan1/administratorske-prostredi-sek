<?php

namespace App\UI\EditUser;

use App\Core\Model\Entity\User;
use App\UI\BasePresenter;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Application\UI\Presenter;
use Nette\Security\User as NetteUser;
use Nettrine\ORM\EntityManagerDecorator;

class EditUserPresenter extends BasePresenter
{
    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }

    public function actionDefault(string $id): void
    {
        $userEntity = $this->em->getRepository(User::class)->find($id);

        if (!$userEntity) {
            $this->error('User not found');
        }

        $this->template->uzivatel = $userEntity;
    }

    protected function createComponentEditForm(): BootstrapForm
    {
        $form = new BootstrapForm();

        $form->addText('email', 'Email:')
            ->setRequired('Please enter your email.');

        $form->addText('firstName', 'First Name:')
            ->setRequired('Please enter your first name.');

        $form->addText('lastName', 'Last Name:')
            ->setRequired('Please enter your last name.');

        $form->addSelect('role', 'Role:', [
            'STUDENT' => 'Student',
            'TEACHER' => 'Teacher',
            'ADMIN' => 'Admin',
        ]);

        $form->addCheckbox('blocked', 'Blocked:');

        $form->addSubmit('save', 'Save Changes');

        $form->onSuccess[] = [$this, 'handleEdit'];

        $userEntity = $this->template->uzivatel;

        $form->setDefaults([
            'email' => $userEntity->getEmail(),
            'firstName' => $userEntity->getFirstName(),
            'lastName' => $userEntity->getLastName(),
            'role' => $userEntity->getRole(),
            'blocked' => $userEntity->isBlocked(),
        ]);

        return $form;
    }

    public function handleEdit(BootstrapForm $form, \stdClass $values): void
    {
        $userEntity = $this->template->uzivatel;

        $userEntity->setEmail($values->email);
        $userEntity->setFirstName($values->firstName);
        $userEntity->setLastName($values->lastName);
        $userEntity->setRole($values->role);
        $userEntity->setBlocked($values->blocked);

        $this->em->persist($userEntity);
        $this->em->flush();

        $this->redirect('Home:');
    }
}
