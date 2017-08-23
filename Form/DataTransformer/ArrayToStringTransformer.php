<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * Transforms a string to array.
     *
     * @param string $str
     *
     * @return array
     */
    public function transform($str)
    {
        if (null === $str) {
            return array();
        }

        return json_decode($str, true);
    }

    /**
     * Transforms an array to string.
     *
     * @param array $array
     *
     * @return string
     */
    public function reverseTransform($array)
    {
        return json_encode($array);
    }
}
