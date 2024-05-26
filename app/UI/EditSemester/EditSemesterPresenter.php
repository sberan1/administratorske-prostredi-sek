<?php

namespace App\UI\EditSemester;

use App\Core\Model\Entity\Course;
use App\Core\Model\Entity\Semester;
use App\UI\BasePresenter;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Forms\Form;
use Ramsey\Uuid\Uuid;

class EditSemesterPresenter extends BasePresenter
{
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
            $semester = $this->em->getRepository(Semester::class)->find($id);
            $this->template->semester = $semester;
        }
    }

    protected function createComponentEditForm(): BootstrapForm
    {
        $courses = $this->em->getRepository(Course::class)->findAll();
        $semesters = $this->em->getRepository(Semester::class)->findAll();
        $form = new BootstrapForm();

        $form->addText('name', 'Název semestru')
            ->setRequired('Název semestru je povinný')
            ->addRule(Form::MAX_LENGTH, 'Název semestru může mít maximálně %d znaků', 255);

        $form->addSelect('course', 'Kurz:', array_reduce($courses, function ($acc, Course $course) {
            $acc[$course->getId()] = $course->getName();
            return $acc;
        }, []) );

        $form->addSelect('nextSemester', 'Následující semestr:', array_reduce($semesters, function ($acc, Semester $semestr) {
            $acc[$semestr->getId()] = $semestr->getName() . " | " . $semestr->getCourses()->getName();
            $acc[null] = ['Žádný'];
            return $acc;
        }, []) );



        if (isset($this->template->semester)) {
            $semester = $this->template->semester;
            $form->addSubmit('save', 'Uložit změny');

            $form->onSuccess[] = [$this, 'handleEdit'];
            $form->setDefaults([
                'name' => $semester->getName(),
                'course' => $semester->getCourses()->getId(),
                'nextSemester' => $semester->getNextSemester() ? $semester->getNextSemester()->getId() : null,
                ]);
        } else {
            $form->addSubmit('save', 'Založit Semestr');
            $form->onSuccess[] = [$this, 'handleAdd'];
        }


        return $form;
    }

    public function handleAdd(Form $form, array $values): void
    {
        $semester = new Semester();
        $semester->setId(Uuid::uuid7()->toString());
        $semester->setName($values['name']);
        $semester->setCourses($this->em->getRepository(Course::class)->find($values['course']));

        $this->em->persist($semester);
        $this->em->flush();

        $this->flashMessage('Semestr byl úspěšně vytvořen', 'success');
        $this->redirect('Semester:');
    }

    public function handleEdit(Form $form, array $values): void
    {
        $semester = $this->template->semester;
        $semester->setName($values['name']);
        $semester->setCourses($this->em->getRepository(Course::class)->find($values['course']));

        $this->em->persist($semester);
        $this->em->flush();

        $this->flashMessage('Semestr byl úspěšně upraven', 'success');
        $this->redirect('Semester:');
    }

}
