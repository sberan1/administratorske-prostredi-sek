<?php

namespace App\UI\EditSubjectQuestion;

use App\Core\Model\Entity\Subject;
use App\Core\Model\Entity\SubjectQuestion;
use App\UI\BasePresenter;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Forms\Form;
use Ramsey\Uuid\Uuid;

class EditSubjectQuestionPresenter extends BasePresenter
{
    public function actionDefault(string $id = null):void
    {
        if ($id) {
            $question = $this->em->getRepository(SubjectQuestion::class)->find($id);
            $this->template->question = $question;
        }
    }

    protected function createComponentEditForm(): BootstrapForm
    {
        $subjects = $this->em->getRepository(Subject::class)->findAll();
        $form = new BootstrapForm();

        $form->addTextArea('title', 'Název')
            ->setRequired('Název je povinný')
            ->addRule(Form::MAX_LENGTH, 'Název může mít maximálně %d znaků', 255);

        $form->addSelect('scaleType', 'Typ škály: ', [
            'FOUR_POINT' => 'Čtyřbodová škála',
            'PERCENTAGE' => 'Procentuální škála',
            ])
            ->setRequired('Typ škály je povinný');

        $form->addSelect('subject', 'Předmět:', array_reduce($subjects, function ($acc, Subject $subject) {
            $acc[$subject->getId()] = $subject->getName();
            return $acc;
        }, []) );

        if (isset($this->template->question)) {
            $question = $this->template->question;
            $form->addSubmit('save', 'Uložit změny');

            $form->onSuccess[] = [$this, 'handleEdit'];
            $form->setDefaults([
                'title' => $question->getTitle(),
                'scaleType' => $question->getScaleType(),
                'subject' => $question->getSubject()->getId(),
            ]);
        } else {
            $form->addSubmit('save', 'Vytvořit otázku');
            $form->onSuccess[] = [$this, 'handleAdd'];
        }

        return $form;
    }

    public function handleAdd(Form $form, array $values): void
    {
        $question = new SubjectQuestion();
        $question->setId(Uuid::uuid7()->toString());
        $question->setTitle($values['title']);
        $question->setScaleType($values['scaleType']);
        $question->setSubject($this->em->getRepository(Subject::class)->find($values['subject']));

        $this->em->persist($question);
        $this->em->flush();

        $this->redirect('SubjectQuestion:');
    }

    public function handleEdit(Form $form, array $values): void
    {
        $question = $this->template->question;
        $question->setTitle($values['title']);
        $question->setScaleType($values['scaleType']);
        $question->setSubject($this->em->getRepository(Subject::class)->find($values['subject']));

        $this->em->persist($question);
        $this->em->flush();

        $this->redirect('SubjectQuestion:');
    }
}
