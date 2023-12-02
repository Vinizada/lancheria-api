<?php

namespace Database\Seeders;

use App\Models\Perfil;
use App\Repositories\Contracts\PerfilRepository;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * @var array[]
     */
    private $perfis = [
        [
            'perfil' => 'Administrador',
            'ativo' => 1,
        ],
        [
            'perfil' => 'Vendedor',
            'ativo' => 1,
        ],
        [
            'perfil' => 'Cliente',
            'ativo' => 1,
        ],
        [
            'perfil' => 'Fornecedor',
            'ativo' => 1,
        ],
    ];

    /** @var PerfilRepository */
    private $perfilRepository;


    /**
     * PerfilSeeder constructor.
     * @param PerfilRepository $perfilRepository
     */
    public function __construct(PerfilRepository $perfilRepository)
    {
        $this->perfilRepository = $perfilRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = app(Perfil::class);

        if ($this->perfilRepository->exists($model)) return;

        foreach ($this->perfis as $data) {
            $this->perfilRepository->create($model, $data);
        }
    }
}
