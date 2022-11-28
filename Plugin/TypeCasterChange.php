<?php

namespace Albert\Magento\Webapi\Plugin;

/**
 * Update TypeCaster
 */
class TypeCasterChange
{

    /**
     * @param \Magento\Framework\Reflection\TypeCaster $TypeCaster
     * @param null $result
     * @param array $data
     * @param string $type
     * @return array|object
     */
    public function afterCastValueToType(
        \Magento\Framework\Reflection\TypeCaster $TypeCaster,
        $result,
        $data,
        $type
    ) {
        if ($type == 'array') {
            return $data;
        } else {
            return $result;
        }
    }

}
