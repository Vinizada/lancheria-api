<?php

namespace Database\Seeders;

use App\Models\MetodoPagamento;
use App\Repositories\Contracts\MetodoPagamentoRepository;
use Illuminate\Database\Seeder;

class MetodoPagamentoSeeder extends Seeder
{
    /**
     * @var array[]
     */
    private $metodosPagamento = [
        [
            'metodo' => 'Caderno',
            'limite_metodo' => 300.0,
            'ativo'  => 1,
        ],
        [
            'metodo' => 'Cartão Débito',
            'ativo'  => 1,
        ],
        [
            'metodo' => 'Cartão Crédito',
            'ativo'  => 1,
        ],
        [
            'metodo' => 'Pix',
            'ativo'  => 1,
        ],
        [
            'metodo' => 'Dinheiro',
            'ativo'  => 1,
        ],
    ];

    /**
     * @var MetodoPagamentoRepository
     */
    private $metodoPagamentoRepository;

    /**
     * MetodoPagamentoSeeder constructor.
     * @param MetodoPagamentoRepository $metodoPagamentoRepository
     */
    public function __construct(MetodoPagamentoRepository $metodoPagamentoRepository)
    {
        $this->metodoPagamentoRepository = $metodoPagamentoRepository;
    }

    /**
     * @return void
     */
    public function run()
    {
        $model = app(MetodoPagamento::class);

        if ($this->metodoPagamentoRepository->exists($model)) return;

        foreach ($this->metodosPagamento as $data) {
            $this->metodoPagamentoRepository->create($model, $data);
        }
    }
}
