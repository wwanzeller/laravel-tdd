<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserTest extends ModelTestCase
{
    /**
     * Teste para verificar a model user.
     *
     * @return Model
     */
    protected function model(): Model
    {
        return new User();
    }

    /**
     * Teste para verificar traits necessárias na model user.
     *
     * @return void
     */
    public function traits(): array
    {
        return [
            HasApiTokens::class, 
            HasFactory::class, 
            Notifiable::class
        ];
    }

    /**
     * Teste para verificar se campos fillables da model User estão corretos
     *
     * @return void
     */
    public function filables(): array
    {
        return [
            'name',
            'email',
            'password'
        ];
    }

     /**
     * Teste para verificar se casts desejados da model User estão definidos
     *
     * @return void
     */
    public function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
        ];
    }
}
