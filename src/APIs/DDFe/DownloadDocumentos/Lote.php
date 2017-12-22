<?php

namespace NS\APIs\DDFe\DownloadDocumentos;

use NS\Support\BaseRequest;
use NS\Support\DadosEntrada;
use NS\Support\Exceptions\DownloadDocumentosNaoRealizadoException;

/**
 * Retorna um lote de NF-es ou CT-es a partir do último NSU enviado.
 * O lote de retorno contém no máximo 50 documentos, carregados
 * em ordem crescente a partir de seu NSU.
 * @link http://confluence.ns.eti.br/display/PUB/Download+de+documentos+na+NS+DDF-e+API#DownloaddedocumentosnaNSDDF-eAPI-Lotededocumentos
 */
class Lote extends BaseRequest
{
    use DadosEntrada;

    protected $baseUrl = 'https://ddfe.ns.eti.br/dfe/';

    protected $dadosEntrada = [
        'CNPJInteressado' => null,
        'modelo' => 55,
        'apenasComXml' => false,
        'comEvento' => false,
        'tpAmb' => 1,
        'incluirPDF' => false,
        'apenasPendManif' => false,
        'ultNSU' => 0
    ];

    public function baixar()
    {
        $response = $this->sendRequest('post', 'bunch', $this->dadosEntrada);
        if ($response['status'] != 200) {
            throw new DownloadDocumentosNaoRealizadoException($response['motivo'], $response['status']);
        }

        return $response;
    }
}