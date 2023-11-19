<?php

namespace App\Enums;

enum UserTypeEnum: int
{
    case ADMINISTRATOR = 1;

    public function label(): string {
        return self::getLabel($this);
    }

    public function abilities(): array
    {
        return self::getAbilities($this);
    }
    private  static function getAbilities(self $value): array {
        return match ($value) {
            self::ADMINISTRATOR => ['administrator'],
        };
    }

    private static function getLabel(self $value): string {
        return match ($value) {
            self::ADMINISTRATOR => 'Administrador'
        };
    }
}
