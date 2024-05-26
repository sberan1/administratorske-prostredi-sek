<?php

namespace App\UI\EditFaculty;

use App\Core\Model\Entity\Faculty;
use App\UI\BasePresenter;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Application\UI\Presenter;
use Nette\Forms\Form;
use Nette\Security\User as NetteUser;
use Nettrine\ORM\EntityManagerDecorator;
use Ramsey\Uuid\Uuid;

class EditFacultyPresenter extends BasePresenter
{

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }

    public function renderDefault(string $id = null):void
    {
        if ($id) {
            $faculty = $this->em->getRepository(Faculty::class)->find($id);
            $this->template->fakulta = $faculty;
        }
    }

    protected function createComponentEditForm(): BootstrapForm
    {
        $form = new BootstrapForm();
        $form->addText('name', 'Název fakulty')
            ->setRequired('Název fakulty je povinný')
            ->addRule(Form::MAX_LENGTH, 'Název fakulty může mít maximálně %d znaků', 255);


        if (isset($this->template->faculty)) {
            $faculty = $this->template->faculty;
            $form->addSubmit('save', 'Uložit změny');

            $form->onSuccess[] = [$this, 'handleEdit'];
            $form->setDefaults([
                'name' => $faculty->getName(),
            ]);
        } else {
            $form->addSubmit('save', 'Založit fakultu');
            $form->onSuccess[] = [$this, 'handleAdd'];
        }

        return $form;
    }

    public function handleEdit(BootstrapForm $form, array $values): void
    {
        $faculty = $this->template->fakulta;
        $faculty->setName($values['name']);
        $this->em->persist($faculty);
        $this->em->flush();
        $this->flashMessage('Fakulta byla úspěšně upravena', 'success');
        $this->redirect('Faculty:');
    }

    public function handleAdd(BootstrapForm $form, array $values): void
    {
        $faculty = new Faculty();
        $faculty->setId(Uuid::uuid7()->toString());
        $faculty->setName($values['name']);
        $this->em->persist($faculty);
        $this->em->flush();
        $this->flashMessage('Faculty was successfully added', 'success');
        $this->redirect('Faculty:');
    }
}
