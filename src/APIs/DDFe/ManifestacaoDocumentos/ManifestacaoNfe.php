<?php

namespace NS\APIs\DDFe\ManifestacaoDocumentos;

use NS\Support\BaseRequest;
use NS\Support\DadosEntrada;
use NS\Support\Exceptions\ManifestacaoNaoEfetuadaException;

/**
 * Este serviço permite que o destinatário da Nota Fiscal eletrônica confirme
 * a sua participação na operação acobertada pela Nota Fiscal Eletrônica emitida para o seu CNPJ.
 * @link http://confluence.ns.eti.br/pages/viewpage.action?pageId=15171663
 */
class ManifestacaoNfe extends BaseRequest
{
    use DadosEntrada;

    protected $baseUrl = 'https://ddfe.ns.eti.br/events/';

    protected $dadosEntrada = [
        'CNPJInteressado' => null,
        'nsu' => null,
        'chave' => null,
        'manifestacao' => [
            'tpEvento' => null,
            'xJust' => null
        ]
    ];

    public function manifestar()
    {
        $this->definirIdentificador();

        $response = $this->sendRequest('post', 'manif', $this->dadosEntrada);
        if ($response['status'] != 200) {
            throw new ManifestacaoNaoEfetuadaException($response['motivo'], $response['status']);
        }

        return $response;
    }

    private function definirIdentificador()
    {
        if (!is_null($this->dadosEntrada['nsu'])) {
            unset($this->dadosEntrada['chave']);
        }
        if (!is_null($this->dadosEntrada['chave'])) {
            unset($this->dadosEntrada['nsu']);
        }

    }
}