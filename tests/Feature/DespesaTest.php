<?php

namespace Tests\Feature;

use App\Models\Despesa;
use Database\Seeders\DespesaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DespesaTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Testa se visitante consegue acessar rota protegida.
     */
    public function testUserNotAuthenticated(): void
    {
        $response = $this->getJson('/api/despesas');

        $response->assertUnauthorized();
    }

    /**
     * Testa se visitante consegue efetuar login.
     */
    public function testLogin(): void
    {
        $response = $this->login();

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }

    /**
     * Testa se usuário consegue acessar rota de listagem de despesas.
     */
    public function testListDespesas(): void
    {
        $token = $this->login()['token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/despesas');

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->whereType('data', 'array')
        );
    }

    /**
     * Testa se usuário consegue acessar despesa não associada.
     */
    public function testShowDespesaNotAssociated(): void
    {
        $token = $this->login()['token'];

        $idDespesa = Despesa::where('user_id', "!=", 1)->first()->id;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/despesas/$idDespesa");

        $response->assertForbidden();
    }

    /**
     * Testa se usuário consegue acessar despesa associada.
     */
    public function testShowDespesaAssociated(): void
    {
        $token = $this->login()['token'];

        $idDespesa = Despesa::where('user_id', 1)->first()->id;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/despesas/$idDespesa");

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'descricao',
            'data',
            'valor',
            'user_id',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * Testa se usuário consegue atualizar despesa não associada.
     */
    public function testUpdateDespesaNotAssociated(): void
    {
        $token = $this->login()['token'];

        $idDespesa = Despesa::where('user_id', "!=", 1)->first()->id;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/despesas/$idDespesa", ['descricao' => 'Despesa de alimentação']);

        $response->assertForbidden();
    }

    /**
     * Testa se usuário consegue atualizar despesa associada.
     */
    public function testUpdateDespesaAssociated(): void
    {
        $token = $this->login()['token'];

        $idDespesa = Despesa::where('user_id', 1)->first()->id;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/despesas/$idDespesa", ['descricao' => 'Despesa de alimentação']);

        $response->assertOk();
        $response->assertSee('Despesa atualizada com sucesso.');
    }

    /**
     * Testa se usuário consegue excluir despesa não associada.
     */
    public function testDeleteDespesaNotAssociated(): void
    {
        $token = $this->login()['token'];

        $idDespesa = Despesa::where('user_id', "!=", 1)->first()->id;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/despesas/$idDespesa");

        $response->assertForbidden();
    }

    /**
     * Testa se usuário consegue excluir despesa associada.
     */
    public function testDeleteDespesaAssociated(): void
    {
        $token = $this->login()['token'];

        $idDespesa = Despesa::where('user_id', 1)->first()->id;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/despesas/$idDespesa");

        $response->assertOk();
        $response->assertSee('Despesa removida com sucesso.');
    }

    /**
     * Testa se usuário consegue criar despesa.
     */
    public function testCreateDespesa(): void
    {
        $token = $this->login()['token'];

        $input = [
            "descricao" => "Viagem de emergência para filial Manaus",
            "data" => "2024-01-22",
            "valor" => 2500
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/despesas", $input);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'descricao',
            'data',
            'valor',
            'user_id',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * Realiza login
     */
    protected function login()
    {
        return $this->postJson('/api/login', [
            "email" => "maria@example.com",
            "password" => "password",
            "device_name" => "postman"
        ]);
    }
}
