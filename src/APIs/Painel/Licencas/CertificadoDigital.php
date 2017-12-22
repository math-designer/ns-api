<?php

namespace NS\APIs\Painel\Licencas;

use NS\Support\BaseRequest;
use NS\Support\DadosEntrada;
use NS\Support\Exceptions\CertificadoNaoAtualizadoException;

/**
 * Insere ou atualiza o certificado digital utilizado por uma licença
 * para gerenciar os documentos fiscais eletrônicos.
 * @link http://confluence.ns.eti.br/display/PUB/Certificado
 */
class CertificadoDigital extends BaseRequest
{
    use DadosEntrada;

    protected $baseUrl = 'http://painelapi.ns.eti.br/licenca/certificate/';

    protected $dadosEntrada = [
        'licencaCnpj' => null,
        'projeto' => null,
        'password' => null,
        'file' => null
    ];

    public function enviar()
    {
        $response = $this->sendRequest('post', 'save', $this->dadosEntrada);
        if ($response['status'] != 200) {
            throw new CertificadoNaoAtualizadoException($response['msg'], $response['status']);
        }

        return $response;
    }
}