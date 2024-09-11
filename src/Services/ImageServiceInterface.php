<?php

/*
 * This file is part of the tbcd/cas project.
 *
 * (c) Thomas Beauchataud <thomas.beauchataud@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Author Thomas Beauchataud
 * From 11/09/2024
 */

namespace TBCD\Webshop\Services;

interface ImageServiceInterface
{

    /**
     * Load the image identified by his reference at the given path
     *
     * @param string $reference
     * @param string $path
     */
    public function loadImage(string $reference, string $path): void;

}