<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function filables(): array;
    abstract protected function casts(): array;

    /**
     * Teste para verificação de traits necessários à aplicação.
     *
     * @return void
     */
    public function test_traits()
    {
        $traits = array_keys(class_uses($this->model()));
        $this->assertEquals($this->traits(), $traits);
    }

    /**
     * Teste para verificar se campos fillables estão corretos
     *
     * @return void
     */
    public function test_fillables()
    {
        $fillable = $this->model()->getFillable();
        $this->assertEquals($this->filables(), $fillable);
    }

    /**
     * Teste para verificar se propriedade de incremento existe
     *
     * @return void
     */
    public function test_incrementing_is_false()
    {
        $incrementing = $this->model()->getIncrementing();
        $this->assertFalse($incrementing, 'Opção incrementing deve estar com valor falso.');
    }

    /**
     * Teste para verificar se casts desejados estão definidos
     *
     * @return void
     */
    public function test_has_casts()
    {
        $expectedCasts = $this->model()->getCasts();
        $this->assertEquals($this->casts(), $expectedCasts);
    }
}