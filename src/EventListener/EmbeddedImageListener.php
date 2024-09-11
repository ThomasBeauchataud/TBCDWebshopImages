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
 * From 10/09/2024
 */

namespace TBCD\Webshop\EventListener;

use Doctrine\ORM\Mapping\PostLoad;
use TBCD\Webshop\Mapping\PropertyMapping;
use TBCD\Webshop\Services\ImageServiceInterface;

class EmbeddedImageListener
{

    private readonly PropertyMapping $mapping;
    private readonly ImageServiceInterface $imageService;

    public function __construct(PropertyMapping $mapping, ImageServiceInterface $imageService)
    {
        $this->mapping = $mapping;
        $this->imageService = $imageService;
    }


    #[PostLoad]
    public function postLoad(object $entity): void
    {
        if ($this->supports($entity)) {
            $imageReference = $this->mapping->getImageReference($entity);
            $imageReference->setPath('tmp/' . $imageReference->getReference());
            $this->imageService->loadImage($imageReference->getReference(), $imageReference->getPath());
        }
    }

    private function supports(object $entity): bool
    {
        return $this->mapping->getImageProperty($entity) != null;
    }
}