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

use Doctrine\ORM\EntityManagerInterface;

class ImageService implements ImageServiceInterface
{

    private readonly EntityManagerInterface $em;

    public function loadImage(string $reference, string $path): void
    {
        // TODO: Implement loadImage() method.
    }
}