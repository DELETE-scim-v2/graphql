<?php
namespace PoP\GraphQL\ObjectModels;

use PoP\GraphQL\ObjectModels\Field;
use PoP\GraphQL\ObjectModels\AbstractType;
use PoP\GraphQL\Facades\Registries\FieldRegistryFacade;

class FieldUtils
{
    public const ID_SEPARATOR = '|';

    public static function getID(AbstractType $type, string $field) {
        return $field.self::ID_SEPARATOR.$type->getID();
    }
    public static function getInputValueID(Field $field, string $inputValueName) {
        return $inputValueName.self::ID_SEPARATOR.$field->getID();
    }
    public static function getTypeAndField(string $id) {
        $components = explode(self::ID_SEPARATOR, $id);
        $field = $components[0];
        $fieldRegistry = FieldRegistryFacade::getInstance();
        $type = $fieldRegistry->getType($id);
        return [
            $type,
            $field
        ];
    }
    public static function getFieldAndInputValueNameFromID(string $id) {
        $components = explode(self::ID_SEPARATOR, $id);
        $inputValueName = $components[0];
        $fieldID = substr($id, strlen($inputValueName)+strlen(self::ID_SEPARATOR));
        list(
            $type,
            $field
        ) = self::getTypeAndField($fieldID);
        return [
            new Field($type, $field),
            $inputValueName
        ];
    }
}
