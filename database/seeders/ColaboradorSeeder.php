<?php

namespace Database\Seeders;

use App\Models\Colaborador;
use App\Repositories\Contracts\ColaboradorRepository;
use Illuminate\Database\Seeder;

class ColaboradorSeeder extends Seeder
{

    /**
     * @var array[]
     */
    private $colaboradores = [
        [
            'nome' => 'Administrador',
            'perfil_id' => 1,
            'senha' => '123456',
            'email' => 'admin@lancheria.com.br',
            'ativo' => 1,
        ],
        [
            'nome' => 'Fabiano Silveira',
            'perfil_id' => 1,
            'senha' => '123456',
            'email' => 'fabiano.silveira@lancheria.com.br',
            'ativo' => 1,
        ],
        [
            'nome' => 'Malú Lima',
            'perfil_id' => 1,
            'senha' => '123456',
            'email' => 'malu.lima@lancheria.com.br',
            'ativo' => 1,
        ],
    ];

    /** @var ColaboradorRepository */
    private $colaboradorRepository;


    /**
     * ColaboradorSeeder constructor.
     * @param ColaboradorRepository $colaboradorRepository
     */
    public function __construct(ColaboradorRepository $colaboradorRepository)
    {
        $this->colaboradorRepository = $colaboradorRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = app(Colaborador::class);

        if ($this->colaboradorRepository->exists($model)) return;

        foreach ($this->colaboradores as $data) {
            $this->colaboradorRepository->create($model, $data);
        }
    }
}
