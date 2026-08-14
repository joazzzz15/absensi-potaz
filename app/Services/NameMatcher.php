<?php
namespace App\Services;
class NameMatcher
{
    public static function isSameName(string $a, string $b): bool
    {
        $tokensA = self::tokenize($a);
        $tokensB = self::tokenize($b);
        if (count($tokensA) === 0 || count($tokensB) === 0) {
            return false;
        }
        if ($tokensA === $tokensB) {
            return true;
        }
        return self::matchesAsAbbreviation($tokensA, $tokensB)
            || self::matchesAsAbbreviation($tokensB, $tokensA);
    }
    private static function matchesAsAbbreviation(array $short, array $long): bool
    {
        if (count($short) > count($long)) {
            return false;
        }

        $pointerLong = 0;
        $matchedTokens = 0;
        $fullWordMatches = 0;

        foreach ($short as $tokenShort) {
            $found = false;

            while ($pointerLong < count($long)) {
                $tokenLong = $long[$pointerLong];
                $pointerLong++;

                if (self::tokensMatch($tokenShort, $tokenLong)) {
                    $found = true;
                    $matchedTokens++;

                    if (mb_strlen($tokenShort) > 1 && $tokenShort === $tokenLong) {
                        $fullWordMatches++;
                    }

                    break;
                }
            }

            if (!$found) {
                return false;
            }
        }
        if ($matchedTokens < 2 || $fullWordMatches < 1) {
            return false;
        }
        return true;
    }
    private static function tokensMatch(string $tokenShort, string $tokenLong): bool
    {
        if ($tokenShort === $tokenLong) {
            return true;
        }
        if (mb_strlen($tokenShort) === 1) {
            return mb_substr($tokenLong, 0, 1) === $tokenShort;
        }
        if (mb_strlen($tokenLong) === 1) {
            return mb_substr($tokenShort, 0, 1) === $tokenLong;
        }
        return false;
    }
    /**
     *
     * @return string[]
     */
    private static function tokenize(string $name): array
    {
        $name = mb_strtolower(trim($name));
        $name = preg_replace('/[^\p{L}\s]/u', ' ', $name); 
        $name = preg_replace('/\s+/', ' ', $name);
        $name = trim($name);

        if ($name === '') {
            return [];
        }
        return explode(' ', $name);
    }
}