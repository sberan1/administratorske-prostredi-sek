<?php

namespace App\UI\EditUser;

use App\Core\Model\Entity\User;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Application\UI\Presenter;
use Nettrine\ORM\EntityManagerDecorator;

class EditUserPresenter extends Presenter
{
    private EntityManagerDecorator $em;

    public function __construct(EntityManagerDecorator $em)
    {
        $this->em = $em;
    }

    public function actionDefault(string $id): void
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

        // Fetch the user from the database
        $userEntity = $this->em->getRepository(User::class)->find($id);

        if (!$userEntity) {
            $this->error('User not found');
        }

        // Pass the user entity to the template
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

        // Fetch the user entity
        $userEntity = $this->template->uzivatel;

        // Set the default values of the form fields
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
        // Fetch the user entity
        $userEntity = $this->template->uzivatel;

        // Set the new values for the user entity
        $userEntity->setEmail($values->email);
        $userEntity->setFirstName($values->firstName);
        $userEntity->setLastName($values->lastName);
        $userEntity->setRole($values->role);
        $userEntity->setBlocked($values->blocked);

        // Persist the changes to the database
        $this->em->persist($userEntity);
        $this->em->flush();

        // Redirect the user to a success page or back to the form
        $this->redirect('Home:');
    }
}
