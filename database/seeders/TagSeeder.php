<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Lead Quente',    'color' => '#ef4444', 'description' => 'Alta probabilidade de fechamento'],
            ['name' => 'Em Negociação',  'color' => '#f59e0b', 'description' => 'Proposta enviada'],
            ['name' => 'Follow-up',      'color' => '#3b82f6', 'description' => 'Necessita retorno'],
            ['name' => 'VIP',            'color' => '#8b5cf6', 'description' => 'Cliente de alto valor'],
            ['name' => 'Suporte Ativo',  'color' => '#10b981', 'description' => 'Ticket de suporte aberto'],
            ['name' => 'Inativo',        'color' => '#64748b', 'description' => 'Sem interação recente'],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($tag['name'])], $tag);
        }
    }
}
