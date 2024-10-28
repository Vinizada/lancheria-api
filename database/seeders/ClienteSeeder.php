<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Repositories\Contracts\AcessoRepository;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * @var array[]
     */
    private $clientes = [
        [
            'nome' => 'Vinicius Lima',
            'email' => 'viniciuslima@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Julia Lima',
            'email' => 'julia@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 1000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Fabiano Silva',
            'email' => 'fabiano@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Márcio Lemos',
            'email' => 'marcio@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Malu Lima',
            'email' => 'malu@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Carlos Roberto',
            'email' => 'carlos@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Pedro Silva',
            'email' => 'pedro@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
        [
            'nome' => 'Camila Silva',
            'email' => 'camila@gmail.com',
            'celular' => '519999999',
            'limite_credito' => 2000,
            'ativo'  => 1,
        ],
    ];

    /**
     * @var AcessoRepository
     */
    private $acessoRepository;

    /**
     * AcessoSeeder constructor.
     * @param AcessoRepository $acessoRepository
     */
    public function __construct(AcessoRepository $acessoRepository)
    {
        $this->acessoRepository = $acessoRepository;
    }

    /**
     * @return void
     */
    public function run()
    {
        $model = app(Cliente::class);

        if ($this->acessoRepository->exists($model)) return;

        foreach ($this->clientes as $data) {
            $this->acessoRepository->create($model, $data);
        }
    }
}
