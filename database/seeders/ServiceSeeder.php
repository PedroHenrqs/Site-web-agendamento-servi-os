<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ["name" => "Formatação de computador", "description" => "Formatação completa com reinstalação do sistema operacional e drivers.", "price_cents" => 8000],
            ["name" => "Instalação de sistema operacional", "description" => "Instalação limpa do Windows ou Linux, sem formatação.", "price_cents" => 6000],
            ["name" => "Limpeza interna", "description" => "Limpeza física de poeira e troca de pasta térmica.", "price_cents" => 5000],
            ["name" => "Manutenção de hardware", "description" => "Diagnóstico e reparo de componentes com defeito.", "price_cents" => 9000],
            ["name" => "Instalação de software", "description" => "Instalação e configuração de programas essenciais.", "price_cents" => 4000],
            ["name" => "Diagnóstico de problemas", "description" => "Avaliação geral para identificar falhas no equipamento.", "price_cents" => 3000],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(["name" => $service["name"]], $service + ["active" => true]);
        }
    }
}
