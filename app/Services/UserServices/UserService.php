<?php

namespace App\Services\UserServices;

use App\Models\User;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{

    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function getAll($filters = [])
    {
      return $this->userRepository->all($filters, $filters['with'] ?? []);
    }

    public function findById($id, $with= [])
    {
        return $this->userRepository->findById($id, $with);
    }

    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data)
    {
        return $this->userRepository->update($user, $data);
    }

    public function delete(User $user)
    {
         $this->userRepository->delete($user);
    }

}
