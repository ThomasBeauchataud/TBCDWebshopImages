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

namespace TBCD\Webshop\Mapping;

use ReflectionClass;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use TBCD\Webshop\Entity\Image;
use TBCD\Webshop\Entity\EmbeddedImage;

final class PropertyMapping
{

    private readonly PropertyAccessorInterface $accessor;

    public function __construct(PropertyAccessorInterface $accessor)
    {
        $this->accessor = $accessor;
    }


    /**
     * @param object $entity
     * @return Image|null
     */
    public function getImageReference(object $entity): ?EmbeddedImage
    {
        $property = self::getImageProperty($entity);
        return $property == null ? null : $this->accessor->getValue($entity, $property);
    }

    /**
     * @param object $entity
     * @param Image $image
     * @return void
     */
    public function setImage(object $entity, Image $image): void
    {
        $property = self::getImageProperty($entity);
        if ($property != null) {
            $this->accessor->setValue($entity, $property, $image);
        }
    }

    /**
     * @param object $object
     * @return string|null
     */
    public function getImageProperty(object $object): ?string
    {
        $reflect = new ReflectionClass($object);
        $fields = $reflect->getProperties();

        foreach ($fields as $field) {
            $fieldName = $field->getName();
            if ($field->getType()->getName() == Image::class && $this->accessor->isReadable($object, $fieldName) && $this->accessor->isWritable($object, $fieldName)) {
                return $fieldName;
            }
        }

        return null;
    }
}