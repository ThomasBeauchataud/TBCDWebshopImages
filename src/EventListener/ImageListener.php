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
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\HttpFoundation\File\File;
use TBCD\Webshop\Mapping\PropertyMapping;
use TBCD\Webshop\Services\ImageService;
use TBCD\Webshop\Services\ImageServiceInterface;

class ImageListener
{

    private readonly PropertyMapping $mapping;
    private readonly ImageServiceInterface $imageService;

    public function __construct(PropertyMapping $mapping, ImageServiceInterface $imageService)
    {
        $this->mapping = $mapping;
        $this->imageService = $imageService;
    }


    #[PrePersist]
    public function prePersist(object $entity): void
    {
        if ($this->supports($entity)) {
            $image = $this->mapping->getImageReference($entity);
            $image->setName(uniqid("tmp/") . '.png');
            $image->setOriginalName($image->getFile()->getClientOriginalName());
            $image->setContent($image->getFile()->getContent());
            $this->mapping->setImage($entity, $image);
        }
    }


    #[PreUpdate]
    public function preUpdate(object $entity): void
    {
        if ($this->supports($entity)) {
            $image = $this->mapping->getImageReference($entity);
            $image->setName($image->getFile()->getClientOriginalName());
            $image->setOriginalName($image->getFile()->getClientOriginalName());
            $image->setContent($image->getFile()->getContent());
            $this->mapping->setImage($entity, $image);
        }
    }

    #[PostLoad]
    public function postLoad(object $entity): void
    {
        if ($this->supports($entity)) {
            $image = $this->mapping->getImageReference($entity);
            $this->imageService->loadImage($image->getReference(), 'tmp/' . $image->getReference());
        }
    }

    private function supports(object $entity): bool
    {
        return $this->mapping->getImageProperty($entity) != null;
    }
}