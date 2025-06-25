# php-greek-diacritics-remover
Effortlessly remove diacritics from Greek text in PHP using the robust intl extension.

# PHP Greek Diacritics Remover

Removing diacritical marks from Greek text is a common necessity in various software applications, from database normalization to URL slug generation and search functionalities. Greek polytonic and even monotonic orthography includes accents and breathings that, while crucial for linguistic accuracy, often need to be stripped for computational purposes. This lightweight PHP function offers a highly efficient and comprehensive solution for this task.

This library leverages PHP's powerful `intl` extension, specifically the `Transliterator` class, to provide a reliable method for normalizing Greek strings. By utilizing Unicode's normalization forms and character property filters, it ensures that all diacritics—including tones (acute, grave, circumflex), breathings (smooth, rough), and iota subscripts—are accurately removed, yielding a clean, plain Greek text string. This approach avoids the limitations of manual character mapping and offers superior performance and accuracy for modern Unicode-compliant applications.

## Requirements

The core functionality of this package relies on the `intl` PHP extension. This extension is widely available and typically included with most PHP distributions. If you encounter any issues, please ensure it is enabled in your `php.ini` file.

## Installation

Since this package consists of a single, self-contained function, you can simply include the `removeGreekDiacritics.php` file (containing the function definition) into your project. For more advanced projects, you might consider packaging it as a Composer library.

First, save the following PHP code into a file named `removeGreekDiacritics.php` in your project:

```
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

```

Then, include this file in your PHP script:

```
require_once 'path/to/removeGreekDiacritics.php';

```

## Usage

Once the `removeGreekDiacritics` function is available in your application (e.g., via `require_once` or Composer autoloader), you can easily call it with any Greek string. The function will return the normalized string with all diacritical marks removed, leaving only the base Greek characters.

```
<?php

// Make sure the removeGreekDiacritics function is loaded/available here.

$textWithDiacritics = "Ἄνθρωπος ἔφυγε ἀπὸ τὸ σπίτι του. Ἡ Ἱστορία. ῥόδον Ῥήτορος. Ἀθῆναι.";
$cleanedText = removeGreekDiacritics($textWithDiacritics);

echo "Original: " . $textWithDiacritics . PHP_EOL;
echo "Cleaned: " . $cleanedText . PHP_EOL;

// Expected Output:
// Original: Ἄνθρωπος ἔφυγε ἀπὸ τὸ σπίτι του. Ἡ Ἱστορία. ῥόδον Ῥήτορος. Ἀθῆναι.
// Cleaned: Ανθρωπος εφυγε απο το σπιτι του. Η Ιστορια. ροδον Ρητορος. Αθηναι.

$textWithIotaSubscript = "Ἑλλάς, ᾠδὴ, ᾄδω";
$cleanedIotaText = removeGreekDiacritics($textWithIotaSubscript);

echo "Original (Iota Subscript): " . $textWithIotaSubscript . PHP_EOL;
echo "Cleaned (Iota Subscript): " . $cleanedIotaText . PHP_EOL;

// Expected Output:
// Original (Iota Subscript): Ἑλλάς, ᾠδὴ, ᾄδω
// Cleaned (Iota Subscript): Ελλας, ωδη, αδω
?>

```

## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT "null").
This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT "null")
