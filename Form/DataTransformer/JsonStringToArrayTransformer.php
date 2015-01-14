<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonStringToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to string.
     *
     * @param string $array
     *
     * @return string
     */
    public function transform($array)
    {
        if (null === $array) {
            return "";
        }

        return json_encode($array);
    }

    /**
     * Transforms a json string to array.
     *
     * @param string|array $json
     *
     * @return array
     */
    public function reverseTransform($json)
    {
        if (is_array($json)) {
            return $json;
        }

        return json_decode($json, true);
    }
}


