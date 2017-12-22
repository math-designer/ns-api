<?php

namespace NS\APIs\DDFe\DownloadDocumentos;

use NS\Support\BaseRequest;
use NS\Support\DadosEntrada;
use NS\Support\Exceptions\DownloadDocumentosNaoRealizadoException;

/**
 * Retorna dados de uma NF-e ou CT-e a partir do fornecimento da chave de acesso.
 * @link http://confluence.ns.eti.br/display/PUB/Download+de+documentos+na+NS+DDF-e+API#DownloaddedocumentosnaNSDDF-eAPI-Documentoespec%C3%ADfico
 */
class Unico extends BaseRequest
{
    use DadosEntrada;

    protected $baseUrl = 'https://ddfe.ns.eti.br/dfe/';

    protected $dadosEntrada = [
        'CNPJInteressado' => null,
        'chave' => null,
        'modelo' => 55,
        'apenasComXml' => false,
        'comEvento' => false,
        'tpAmb' => 1,
        'incluirPDF' => false,
        'nsu' => 0
    ];

    public function baixar()
    {
        if ($this->dadosEntrada['nsu'] != 0) {
            unset($this->dadosEntrada['chave']);
        }

        $response = $this->sendRequest('post', 'unique', $this->dadosEntrada);
        if ($response['status'] != 200) {
            throw new DownloadDocumentosNaoRealizadoException($response['motivo'], $response['status']);
        }

        return $response;
    }
}