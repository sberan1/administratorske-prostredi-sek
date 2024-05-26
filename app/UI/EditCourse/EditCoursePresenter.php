<?php

namespace App\UI\EditCourse;

use App\Core\Model\Entity\Course;
use App\Core\Model\Entity\Faculty;
use App\UI\BasePresenter;
use App\UI\Course\CoursePresenter;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Forms\Form;
use Ramsey\Uuid\Uuid;

class EditCoursePresenter extends BasePresenter
{
    private Course $course;
    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }

    public function actionDefault(string $id = null):void
    {
        if ($id) {
            $this->course = $this->em->getRepository(Course::class)->find($id);
            $this->template->course = $this->course;
        }
    }
    protected function createComponentEditForm(): BootstrapForm
    {
        $faculty = $this->em->getRepository(Faculty::class)->findAll();
        $form = new BootstrapForm();

        $form->addText('name', 'Název studijního programu')
            ->setRequired('Název studijního programu je povinný')
            ->addRule(Form::MAX_LENGTH, 'Název studijního programu může mít maximálně %d znaků', 255);

        $form->addSelect('faculty', 'Fakulta:', array_reduce($faculty, function ($acc, Faculty $faculty)
        {
            $acc[$faculty->getId()] = $faculty->getName();
            return $acc;
        }, []) );


        if (isset($this->course)) {
            $course = $this->course;
            $form->addSubmit('save', 'Uložit změny');

            $form->onSuccess[] = [$this, 'handleEdit'];
            $form->setDefaults([
                'name' => $course->getName(),
                'faculty' => $course->getFaculty()->getId(),
            ]);
        } else {
            $form->addSubmit('save', 'Založit Studijní Obor');
            $form->onSuccess[] = [$this, 'handleAdd'];
        }

        return $form;
    }

    public function handleAdd(Form $form, array $values): void
    {
        $course = new Course();
        $course->setId(Uuid::uuid7()->toString());
        $course->setName($values['name']);
        $course->setFaculty($this->em->getRepository(Faculty::class)->find($values['faculty']));

        $this->em->persist($course);
        $this->em->flush();

        $this->flashMessage('Studijní Obor byl úspěšně vytvořen', 'success');
        $this->redirect('Course:');
    }

    public function handleEdit(Form $form, array $values): void
    {
        $course = $this->course;
        $course->setName($values['name']);
        $course->setFaculty($this->em->getRepository(Faculty::class)->find($values['faculty']));

        $this->em->persist($course);
        $this->em->flush();

        $this->flashMessage('Studijní Obor byl úspěšně upraven', 'success');
        $this->redirect('Course:');
    }

}
