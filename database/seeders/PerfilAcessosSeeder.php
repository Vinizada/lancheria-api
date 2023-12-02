<?php

namespace Database\Seeders;

use App\Models\PerfilAcesso;
use App\Repositories\Contracts\PerfilAcessosRepository;
use Illuminate\Database\Seeder;

class PerfilAcessosSeeder extends Seeder
{
    private $perfilAcessos = [
        [
            'perfil_id' => 1,
            'acesso_id' => 1,
        ],
        [
            'perfil_id' => 1,
            'acesso_id' => 2,
        ],
        [
            'perfil_id' => 1,
            'acesso_id' => 3,
        ],
        [
            'perfil_id' => 1,
            'acesso_id' => 4,
        ],
        [
            'perfil_id' => 2,
            'acesso_id' => 2,
        ],
        [
            'perfil_id' => 2,
            'acesso_id' => 3,
        ],
        [
            'perfil_id' => 3,
            'acesso_id' => 2,
        ],
        [
            'perfil_id' => 4,
            'acesso_id' => 1,
        ],
    ];

    /** @var PerfilAcessosRepository */
    private $perfilAcessosRepository;


    /**
     * ColaboradorSeeder constructor.
     * @param PerfilAcessosRepository $perfilAcessosRepository
     */
    public function __construct(PerfilAcessosRepository $perfilAcessosRepository)
    {
        $this->perfilAcessosRepository = $perfilAcessosRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = app(PerfilAcesso::class);

        if ($this->perfilAcessosRepository->exists($model)) return;

        foreach ($this->perfilAcessos as $data) {
            $this->perfilAcessosRepository->create($model, $data);
        }
    }
}
