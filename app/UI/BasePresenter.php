<?php

namespace App\UI;

use Nette\Application\UI\Presenter;
use Nette\Security\User;
use Nettrine\ORM\EntityManagerDecorator;

class BasePresenter extends Presenter
{
    protected User $user;
    protected EntityManagerDecorator $em;

    public function injectBase(User $user, EntityManagerDecorator $em)
    {
        $this->user = $user;
        $this->em = $em;
    }

    protected function startup()
    {
        parent::startup();
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
    }
}
