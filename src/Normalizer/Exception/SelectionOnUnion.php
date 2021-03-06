<?php

declare(strict_types = 1);

namespace Graphpinator\Normalizer\Exception;

final class SelectionOnUnion extends \Graphpinator\Normalizer\Exception\NormalizerError
{
    public const MESSAGE = 'Cannot require fields on union type, use fragments with concrete type conditions.';
}
