<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Exception\NotFoundException;
use Exception;
use SebastianBergmann\Type\ObjectType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $user)
    {}

    public function findAll(): array
    {
        return $this->user->get()->toArray();
    }

    public function create(array $data): object
    {
        return $this->user->create($data);
    }

    public function update(string $email, array $data): object
    {
        $user = $user = $this->find(email: $email);
        $user->update($data);
        return $user;
    }

    public function delete(string $email): bool
    {
        if(!$user = $this->find(email: $email)) {
            throw new NotFoundException('Usuário não encontrado.');
        }
        return $user->delete();
    }

    public function find(string $email): ?object
    {
        $user = $this->user->where('email', $email)->first();
        return $user;
    }
}

