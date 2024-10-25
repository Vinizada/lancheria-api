<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Repositories\Contracts\CategoriaRepository;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    private $categorias = [
        [
            'nome'  => 'Bebidas',
            'ativo' => 1
        ],
        [
            'nome'  => 'Fritos',
            'ativo' => 1
        ],
        [
            'nome'  => 'Cafés',
            'ativo' => 1
        ],
        [
            'nome'  => 'Salgados',
            'ativo' => 1
        ],
        [
            'nome'  => 'Doces',
            'ativo' => 1
        ],
        [
            'nome'  => 'Chocolates',
            'ativo' => 1
        ],
        [
            'nome'  => 'Chás',
            'ativo' => 1
        ],
    ];

    /** @var CategoriaRepository */
    private $categoriaRepository;

    /**
     * @param CategoriaRepository $categoriaRepository
     */
    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = app(Categoria::class);

        if ($this->categoriaRepository->exists($model)) return;

        foreach ($this->categorias as $data) {
            $this->categoriaRepository->create($model, $data);
        }
    }
}
