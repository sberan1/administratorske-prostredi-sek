<?php

namespace App\UI\EditSubject;

use App\Core\Model\Entity\RecommendedSemester;
use App\Core\Model\Entity\Semester;
use App\Core\Model\Entity\Subject;
use App\UI\BasePresenter;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Forms\Form;
use Ramsey\Uuid\Uuid;

class EditSubjectPresenter extends BasePresenter
{
    public function actionDefault(string $id = null): void
    {
        if ($id) {
            $sql = '
        SELECT s.id, sem.id AS semester_id, s.name, sem.name AS semester_name, s.code, c.name as course_name
        FROM "Subject" AS s
        JOIN "_RecommendedSemester" AS rs ON s.id = rs."B"
        JOIN "Semester" AS sem ON rs."A" = sem.id
        JOIN "Course" AS c ON sem."coursesId" = c.id
        WHERE s.id = :id;
        ';


            $sub = $this->em->getConnection()->prepare($sql);
            $sub->bindValue('id', $id);
            $subject = $sub->executeQuery()->fetchAllAssociative();
            $this->template->subject = $subject;

        }
    }

    protected function createComponentEditForm(): BootstrapForm
    {
        $form = new BootstrapForm();

        $form->addText('name', 'Subject Name')
            ->setRequired('Subject name is required')
            ->addRule(Form::MAX_LENGTH, 'Subject name can have a maximum of %d characters', 255);

        $form->addText('code', 'Subject Code')
            ->setRequired('Subject code is required')
            ->addRule(Form::MAX_LENGTH, 'Subject code can have a maximum of %d characters', 255);

        $semesters = $this->em->getRepository(Semester::class)->findAll();
        $semesterChoices = array_reduce($semesters, function ($acc, Semester $semester) {
            $acc[$semester->getId()] = $semester->getName() . " | " . $semester->getCourses()->getName();
            return $acc;
        }, []);

        $form->addMultiSelect('recommendedSemesters', 'Recommended Semesters', $semesterChoices);

        if (isset($this->template->subject)) {
            $subject = $this->template->subject;
            $form->addSubmit('save', 'Save Changes');
            bdump($subject);
            $form->onSuccess[] = [$this, 'handleEdit'];
            //bdump($subject->getRecommendedSemester()->toArray());
            //bdump($semesters[1]->getSubjects());
            $form->setDefaults([
                'name' => $subject[0]['name'],
                'code' => $subject[0]['code'],
                'recommendedSemesters' => array_map(function ($semester) {
                    return $semester['semester_id'];
                }, $subject),
            ]);
        } else {
            $form->addSubmit('save', 'Create Subject');
            $form->onSuccess[] = [$this, 'handleAdd'];
        }

        return $form;
    }

    public function handleAdd(Form $form, array $values): void
    {
        $subject = new Subject();
        $subject->setId(Uuid::uuid7()->toString());
        $subject->setName($values['name']);
        $subject->setCode($values['code']);

        foreach ($values['recommendedSemesters'] as $semesterId) {
            $recommended = new RecommendedSemester();
            $recommended->setA($semesterId);
            $recommended->setB($subject->getId());
            $this->em->persist($recommended);
            $this->em->flush();
        }

        $this->em->persist($subject);
        $this->em->flush();

        $this->redirect('Subject:');
    }

    public function handleEdit(Form $form, array $values): void
    {
        $subject = $this->template->subject;
        $subject->setName($values['name']);
        $subject->setCode($values['code']);


        foreach ($values['recommendedSemesters'] as $semesterId) {
            $recommended = new RecommendedSemester();
            $recommended->setA($semesterId);
            $recommended->setB($subject->getId());
            $this->em->persist($recommended);
            $this->em->flush();
        }

        $this->em->persist($subject);
        $this->em->flush();

        $this->redirect('Subject:');
    }
}
