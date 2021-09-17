<?php

namespace Albert\Magento\Webapi\Plugin;

/**
 * Update ServiceOutputProcessor
 */
class ServiceOutputProcessorChange
{

    /**
     * @param \Magento\Framework\Webapi\ServiceOutputProcessor $ServiceOutputProcessor
     * @param null $result
     * @param array $data
     * @param string $type
     * @return array|object
     */
    public function afterConvertValue(
        \Magento\Framework\Webapi\ServiceOutputProcessor $ServiceOutputProcessor,
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
