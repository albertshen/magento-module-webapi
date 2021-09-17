<?php
/**
 * Copyright © PHPDigital, Inc. All rights reserved.
 *
 * Module Created By : Albert Shen
 */
namespace Albert\Magento\Webapi\Model;

use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Reflection\MethodsMap;
use Magento\Framework\Reflection\TypeProcessor;
use Laminas\Code\Reflection\ClassReflection;

/**
 * Data object converter
 *
 * @api
 * @since 100.0.2
 */
class ServiceOutputProcessor extends \Magento\Framework\Webapi\ServiceOutputProcessor
{

    /**
     * Convert associative array into proper data object.
     *
     * @param array $data
     * @param string $type
     * @return array|object
     */
    public function convertValue($data, $type)
    {   
        if ($type === 'array') {
            return $data;
        }

        if (is_array($data)) {
            $result = [];
            $arrayElementType = substr($type, 0, -2);
            foreach ($data as $datum) {
                if (is_object($datum)) {
                    $datum = $this->processDataObject(
                        $this->dataObjectProcessor->buildOutputDataArray($datum, $arrayElementType)
                    );
                }
                $result[] = $datum;
            }
            return $result;
        } elseif (is_object($data)) {
            return $this->processDataObject(
                $this->dataObjectProcessor->buildOutputDataArray($data, $type)
            );
        } elseif ($data === null) {
            return [];
        } else {
            /** No processing is required for scalar types */
            return $data;
        }
    }
}
