<?php

namespace AlbertMage\Webapi\Plugin;

use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Magento\Webapi\Model\Cache\Type\Webapi as WebapiCache;
use Magento\Webapi\Controller\Rest\InputParamsResolver;

/**
 * Update Rest
 */
class SynchronousRequestProcessorChange
{

    const CACHE_METHOD = 'GET';

    /**
     * @var RestResponse
     */
    protected $response;

    /**
     * @var InputParamsResolver
     */
    private $inputParamsResolver;

    /**
     * @var WebapiCache
     */
    protected $cache;

    /**
     * @var array
     */
    protected $cacheUriList;

    /**
     * Initialize dependencies
     *
     * @param RestResponse $response
     * @param InputParamsResolver $inputParamsResolver
     * @param WebapiCache $cache
     *
     */
    public function __construct(
        RestResponse $response,
        InputParamsResolver $inputParamsResolver,
        WebapiCache $cache,
        array $cacheUriList
    ) {
        $this->response = $response;
        $this->inputParamsResolver = $inputParamsResolver;
        $this->cache = $cache;
        $this->cacheUriList = $cacheUriList ?? [];
    }

    /**
     * Executes the logic to process the request
     *
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @return void
     * @throws \Magento\Framework\Exception\AuthorizationException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function aroundProcess(\Magento\Webapi\Controller\Rest\SynchronousRequestProcessor $subject, callable $proceed, \Magento\Framework\Webapi\Rest\Request $request)
    {

        if ($request->getHttpMethod() == self::CACHE_METHOD && in_array($this->inputParamsResolver->getRoute()->getRoutePath(), $this->cacheUriList)) {

            $cache_key = $request->getRequestUri();

            $data = $this->cache->load($cache_key);
            if ($data) {
                $this->response->prepareResponse(unserialize($data));
            } else {
                $proceed($request);
                $data = json_decode($this->response->getBody());
                $this->cache->save(serialize($data), $cache_key);
            }

        } else {
            $proceed($request);
        }
    }

}
