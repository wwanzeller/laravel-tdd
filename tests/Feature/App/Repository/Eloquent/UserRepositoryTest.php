<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Exception\NotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = new UserRepository(new User());
        parent::setUp();
    }

    public function test_implements_interface()
    {
        $this->assertInstanceOf(
            UserRepositoryInterface::class, 
            $this->repository
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fild_all_empty()
    {
        $response = $this->repository->findAll();

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fild_all()
    {
        User::factory()->count(10)->create();
        
        $response = $this->repository->findAll();

        $this->assertCount(10, $response);
    }

    public function test_create()
    {
        $data = [
            'name' => 'Wenderson Wanzeller',
            'email' => 'wenderson@wanzeller.com',
            'password' => bcrypt('12345678')
        ];
        
        $response = $this->repository->create($data);

        $this->assertNotNull($response);
        $this->assertIsObject($response);
        $this->assertDatabaseHas('users', [
            'email' => 'wenderson@wanzeller.com'
        ]);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        
        $data = [
            'email' => 'wenderson@wanzeller.com.br'
        ];
        
        $response = $this->repository->update($user->email, $data);

        $this->assertNotNull($response);
        $this->assertIsObject($response);
        $this->assertDatabaseHas('users', [
            'email' => 'wenderson@wanzeller.com.br'
        ]);
    }

    public function test_delete()
    {      
        $user = User::factory()->create();
        $deleted = $this->repository->delete($user->email);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', [
            'email' => $user->email]
        );
    }

    public function test_delete_not_found()
    {
        $this->getExpectedException(NotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado.');
        $this->repository->delete('fake_email');
        
        // Outro exemplo
        // try {
        //     $this->repository->delete('fake_email');
        //     $this->assertTrue(false);
        // } catch (\Throwable $th) {
        //     $this->assertInstanceOf(NotFoundException::class, $th);
        // }
    }

    public function test_find()
    {      
        $user = User::factory()->create();
        $response = $this->repository->find($user->email);
        $this->assertIsObject($response);
        
    }

    public function test_find_not_found()
    {      
        $response = $this->repository->find('fake_email');
        $this->assertNull($response);
        
    }
}
