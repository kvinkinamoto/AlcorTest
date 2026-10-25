<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain;

use App\Payroll\Earning\Domain\Exception\CommentRequired;
use Stringable;

/** The mandatory explanation of a manual correction. */
final readonly class Comment implements Stringable
{
    public string $text;

    public function __construct(string $text)
    {
        $text = trim($text);
        if ($text === '') {
            throw new CommentRequired();
        }
        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
