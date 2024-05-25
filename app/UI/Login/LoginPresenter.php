<?php declare(strict_types=1);

namespace App\UI\Login;

use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use App\UI\BasePresenter;
use App\Core\Model\Auth;
use Nettrine\ORM\EntityManagerDecorator;

final class LoginPresenter extends BasePresenter
{
    private Auth $auth;

    protected function startup()
    {
        parent::startup();
        if ($this->user->isLoggedIn()) {
            $this->redirect('Home:');
        }
    }
    public function __construct(EntityManagerDecorator $em)
    {
        $this->auth = new Auth($em);
    }

    protected function createComponentLoginForm(): Form
    {
        $form = new BootstrapForm();

        $form->addText('email', 'Email:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addSubmit('login', 'Log in');

        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        return $form;
    }

    public function loginFormSucceeded(Form $form, \stdClass $values): void
    {
            $user = $this->getUser();
            $user->setAuthenticator($this->auth);
            try {
                $user->login($values->email, $values->password);
                $user->setExpiration('30 minutes', true);
                $this->redirect('Home:');
            } catch (AuthenticationException $e) {
                $form->addError('Incorrect username or password.');
            }

    }
}
