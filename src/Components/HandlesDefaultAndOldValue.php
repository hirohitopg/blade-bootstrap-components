<?php

namespace Hostmoz\BladeBootstrapComponents\Components;

trait HandlesDefaultAndOldValue
{
    use HandlesBoundValues;

    private function setValue(
        string $name,
        $bind = null,
        $default = null,
        $language = null
    ) {
        if ($this->isWired()) {
            return;
        }

        if (!$language) {
            $default = $this->getBoundValue($bind, $name) ?: $default;

            return $this->value = old($name, $default);
        }

        if ($bind !== false) {
            $bind = $bind ?: $this->getBoundTarget();
        }

        if ($bind) {
            $default = $bind->getTranslation($name, $language, false) ?: $default;
        }

        $this->value = old("{$name}.{$language}", $default);
    }
}
