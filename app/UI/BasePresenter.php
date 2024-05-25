<?php

namespace App\UI;

use Nette\Application\UI\Presenter;
use Nette\Security\User;

class BasePresenter extends Presenter
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function renderDefault()
    {
        //$this->template->setFile(__DIR__ . '/@layout.latte');
        //$this->template->name = '';

        // Define the links for the layout bar
        $this->template->links = [
            ['presenter' => 'Page1', 'name' => 'Page 1'],
            ['presenter' => 'Page2', 'name' => 'Page 2'],
            ['presenter' => 'Page3', 'name' => 'Page 3'],
            // Add more links as needed
        ];
    }
}
