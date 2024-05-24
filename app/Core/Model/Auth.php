<?php

namespace App\Core\Model;

use App\Core\Model\Entity\Type\Role;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;
use Nettrine\ORM\EntityManagerDecorator;
use App\Core\Model\Entity\User;


class Auth implements Authenticator
{
    public function __construct(
        private readonly EntityManagerDecorator $em
    ){}

    public function authenticate(string $user, string $password): SimpleIdentity
    {
        // TODO: Implement @method IIdentity authenticate(array $credentials)
        $row = $this->em->getRepository(User::class)->findOneBy(['email' => $user]);
        bdump($row);
        if (!$row) {
            throw new AuthenticationException('User not found.');
        }
        if (!password_verify($password, $row->getPassword())) {
            throw new AuthenticationException('Invalid password.');
        }
        if ($row->getRole() == Role::ADMIN) {
            $roles = ['admin'];
        } else {
            throw new AuthenticationException('Invalid role.');
        }

        // ověříme heslo
        // vrátíme identitu se všemi údaji z databáze
        return new SimpleIdentity($row->getId(), $roles, (array) $row);
    }
}
