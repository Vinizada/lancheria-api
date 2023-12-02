<?php

namespace Database\Seeders;

use App\Models\Acesso;
use App\Repositories\Contracts\AcessoRepository;
use Illuminate\Database\Seeder;

class AcessoSeeder extends Seeder
{
    /**
     * @var array[]
     */
    private $acessos = [
        [
            'acesso' => 'CONSULTAR_CADASTROS',
            'ativo'  => 1,
        ],
        [
            'acesso' => 'PEDIDOS',
            'ativo'  => 1,
        ],
        [
            'acesso' => 'REGISTRAR_VENDA',
            'ativo'  => 1,
        ],
        [
            'acesso' => 'CADASTRO_PRODUTOS',
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
        $model = app(Acesso::class);

        if ($this->acessoRepository->exists($model)) return;

        foreach ($this->acessos as $data) {
            $this->acessoRepository->create($model, $data);
        }
    }
}
