<?php

namespace AlbertMage\Webapi\Plugin;

/**
 * Update ServiceOutputProcessor
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class ServiceOutputProcessorChange
{

    /**
     * @param \Magento\Framework\Webapi\ServiceOutputProcessor $serviceOutputProcessor
     * @param null $result
     * @param array $data
     * @param string $type
     * @return array|object
     */
    public function afterConvertValue(
        \Magento\Framework\Webapi\ServiceOutputProcessor $serviceOutputProcessor,
        $result,
        $data,
        $type
    ) {
        if ($type === 'array') {
            return $data;
        } else {
            return $result;
        }
    }

}
