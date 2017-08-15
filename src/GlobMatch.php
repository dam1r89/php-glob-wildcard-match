<?php

namespace dam1r89\GlobMatch;

class GlobMatch
{
    public function match($pattern, $string)
    {
        $pattern = $this->escapeAllButKeywords($pattern, $string);

        return preg_match(sprintf('/^%s$/', $pattern), $string) === 1;
    }

    private function escapeAllButKeywords($pattern, $string)
    {
        list($ALL, $CHAR) = $this->getPlaceholders($string);
        $pattern = strtr($pattern, ['*' => $ALL, '?' => $CHAR]);
        $pattern = preg_quote($pattern, '/');
        $pattern = strtr($pattern, [$ALL => '.*', $CHAR => '.']);

        return $pattern;
    }

    private function getPlaceholders($subject)
    {
        $i = 0;
        while (strpos($subject, $placeholder = "__MATCH_PLACEHOLDER_{$i}__") !== false) {
            $i += 1;
        }
        $i += 1;
        $start = $placeholder;
        while (strpos($subject, $placeholder = "__MATCH_PLACEHOLDER_{$i}__") !== false) {
            $i += 1;
        }

        return [$start, $placeholder];
    }
}
