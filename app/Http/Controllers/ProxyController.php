<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProxyExportRequest;
use App\Http\Resources\JsonResourceCollection;
use App\Http\Responses\CSVResponse;
use Proxy\App\Service\ProxyCollectionReader;
use Proxy\App\Service\ProxyCollectionStringFormatter;
use Proxy\App\Service\ProxyStringFormatter\Factory;

class ProxyController extends Controller
{
    public function __construct(private readonly ProxyCollectionReader $proxyCollectionReader)
    {
    }

    public function list(): JsonResourceCollection
    {
        return JsonResourceCollection::make($this->proxyCollectionReader->read());
    }

    public function export(ProxyExportRequest $request, Factory $stringFormatterFactory): CSVResponse
    {
        $collection = $this->proxyCollectionReader->read();
        $stringFormatter = $stringFormatterFactory->make($request->formatValue());
        $collectionStringFormatter = new ProxyCollectionStringFormatter($stringFormatter);
        $stringCollection = $collectionStringFormatter->format($collection);
        array_unshift($stringCollection, 'Proxy');

        return CSVResponse::make($stringCollection);
    }
}