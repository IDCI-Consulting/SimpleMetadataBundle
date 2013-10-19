<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonStringToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to string
     *
     * @param string $array
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
     * @param string $str
     * @return array
     */
    public function reverseTransform($str)
    {
        return json_decode($str, true);
    }
}


