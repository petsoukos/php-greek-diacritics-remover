<?php

if (!function_exists('removeGreekDiacritics')) {
    /**
     * Removes all diacritics from a Greek string using the 'intl' extension.
     *
     * This function leverages the ICU library's Transliterator to decompose
     * characters and strip non-spacing marks, providing a highly efficient
     * and accurate method for normalization.
     *
     * @param string $text The input string, potentially with Greek diacritics.
     * @return string The cleaned string with all diacritics removed.
     * @throws \RuntimeException If the 'intl' PHP extension is not enabled and the Transliterator cannot be created.
     */
    function removeGreekDiacritics(string $text): string
    {
        // The transformation rule first decomposes characters (NFD),
        // removes the diacritical marks, and then re-composes them (NFC).
        $transliterator = \Transliterator::create('Any-NFD; [:Nonspacing Mark:] Remove; Any-NFC');

        // If the Transliterator could not be created, it's a fatal environment error.
        if ($transliterator === null) {
            throw new \RuntimeException(
                "The 'intl' PHP extension is required to remove diacritics, but it seems to be missing or misconfigured. " .
                    "Please enable the 'intl' extension in your php.ini file."
            );
        }

        return $transliterator->transliterate($text);
    }
}
