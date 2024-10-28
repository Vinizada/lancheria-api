<?php

namespace Database\Seeders;

use App\Models\Colaborador;
use App\Repositories\Contracts\ColaboradorRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ColaboradorSeeder extends Seeder
{
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

    private $colaboradorRepository;

    public function __construct(ColaboradorRepository $colaboradorRepository)
    {
        $this->colaboradorRepository = $colaboradorRepository;
    }

    public function run()
    {
        $model = app(Colaborador::class);

        if ($this->colaboradorRepository->exists($model)) return;

        foreach ($this->colaboradores as $data) {
            $data['senha'] = Hash::make($data['senha']);
            $this->colaboradorRepository->create($model, $data);
        }
    }
}
