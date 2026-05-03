<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasMasks
{
    /**
     * Formata CNPJ/CPF ao salvar.
     */
    protected function formatDocument(string $value): string
    {
        $doc = preg_replace('/\D/', '', $value);

        if (strlen($doc) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $doc);
        }

        if (strlen($doc) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $doc);
        }

        return $doc;
    }

    /**
     * Formata Telefone ao salvar.
     */
    protected function formatPhone(string $value): string
    {
        $phone = preg_replace('/\D/', '', $value);

        if (strlen($phone) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        }

        if (strlen($phone) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
        }

        return $phone;
    }
}
