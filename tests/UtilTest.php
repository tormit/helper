<?php

use Tormit\Helper\Util;

class UtilTest extends \PHPUnit\Framework\TestCase
{
    public function testSecureRandomString()
    {
        $randomString = \Tormit\Helper\Util::randStr(10, null, false, false);
        $this->assertEquals(10, strlen($randomString));
        $this->assertMatchesRegularExpression('/^[a-zA-Z]+$/', $randomString);
    }

    public function testSecureRandomStringWithNumbers()
    {
        $randomString = \Tormit\Helper\Util::randStr(10, null, false);
        $this->assertEquals(10, strlen($randomString));
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]+$/', $randomString);
    }

    public function testSecureRandomStringWithNumbersAndSpecialChars()
    {
        $randomString = \Tormit\Helper\Util::randStr(10, null);
        $this->assertEquals(10, strlen($randomString));
        $this->assertMatchesRegularExpression('/^[\w\W]+$/', $randomString);
    }

    public function testGetFileExtension()
    {
        $filename = 'example.txt';
        $extension = \Tormit\Helper\Util::findExt($filename);
        $this->assertEquals('txt', $extension);
    }

    public function testGetFileExtensionDotFile()
    {
        $filename = '.example';
        $extension = \Tormit\Helper\Util::findExt($filename);
        $this->assertEquals('example', $extension);
    }

    public function testGetFileExtensionDotFileWithExt()
    {
        $filename = '.example.txt';
        $extension = \Tormit\Helper\Util::findExt($filename);
        $this->assertEquals('txt', $extension);
    }


    public function testGetFileExtensionWithoutExtension()
    {
        $filename = 'example';
        $extension = \Tormit\Helper\Util::findExt($filename);
        $this->assertEmpty($extension);
    }

    public function testGetFileName()
    {
        $filename = 'example.txt';
        $extension = \Tormit\Helper\Util::findFilename($filename);
        $this->assertEquals('example', $extension);
    }

    public function testGetFileNameNoExt()
    {
        $filename = 'example';
        $extension = \Tormit\Helper\Util::findFilename($filename);
        $this->assertEquals('example', $extension);
    }

    public function testGetFileNameDotFile()
    {
        $filename = '.example';
        $extension = \Tormit\Helper\Util::findFilename($filename);
        $this->assertEquals('.example', $extension);
    }

    public function testRandomElementsSingle()
    {
        $array = [1, 2, 3, 4, 5];
        $randomElement = \Tormit\Helper\Util::arrayRandom($array, 1);
        $this->assertTrue(in_array($randomElement, $array));
    }

    public function testRandomElementsMultiple()
    {
        $array = [1, 2, 3, 4, 5];
        $randomElements = \Tormit\Helper\Util::arrayRandom($array, 2);
        $this->assertCount(2, $randomElements);
        $this->assertContainsOnly('int', $randomElements);
    }

    public function testPrependScheme()
    {
        $url = 'example.com';
        $urlWithScheme = \Tormit\Helper\Util::prependHttp($url);
        $this->assertEquals('http://example.com', $urlWithScheme);
    }

    public function testPrependSchemeHttps()
    {
        $url = 'example.com';
        $urlWithScheme = \Tormit\Helper\Util::prependHttp($url, \Tormit\Helper\Enums\PrependHttp::True);
        $this->assertEquals('https://example.com', $urlWithScheme);
    }

    public function testPrependSchemeAuto()
    {
        $url = 'example.com';
        $urlWithScheme = \Tormit\Helper\Util::prependHttp($url, \Tormit\Helper\Enums\PrependHttp::Auto);
        $this->assertEquals('http://example.com', $urlWithScheme);
    }

    public function testPrependSchemeNoDoubleScheme()
    {
        $url = 'https://example.com';
        $urlWithScheme = \Tormit\Helper\Util::prependHttp($url);
        $this->assertEquals('https://example.com', $urlWithScheme);
    }

    public function testTruncateText()
    {
        $text = "This is an example text where the keyword 'example' should be highlighted.";
        $keyword = 'example';
        $truncated = \Tormit\Helper\Util::truncateAroundKeyword($text, $keyword, 10, '');
        $this->assertEquals('...his is an example text wher...', $truncated);
    }

    public function testTruncateTextWithTag()
    {
        $text = "This is an example text where the keyword 'example' should be highlighted.";
        $keyword = 'example';
        $truncated = \Tormit\Helper\Util::truncateAroundKeyword($text, $keyword, 10);
        $this->assertEquals('...his is an <strong>example</strong> text wher...', $truncated);
    }

    public function testFormatBytes()
    {
        $bytes = 1024;
        $formatted = \Tormit\Helper\Util::fileSize($bytes);
        $this->assertEquals('1.00 KiB', $formatted);
    }

    public function testMimeFromExtension()
    {
        $filename = 'example.jpg';
        $mimeType = \Tormit\Helper\Util::guessMime($filename);
        $this->assertEquals('image/jpeg', $mimeType);
    }

    public function testMimeFromExtensionDefault()
    {
        $filename = 'example.unknown';
        $mimeType = \Tormit\Helper\Util::guessMime($filename);
        $this->assertEquals('application/octet-stream', $mimeType);
    }

    public function testIniValueToBytes()
    {
        $iniKey = 'memory_limit';
        $currentValue = ini_get($iniKey);
        ini_set($iniKey, '129M');
        $bytes = \Tormit\Helper\Util::iniGetBytes($iniKey);
        ini_set($iniKey, $currentValue);
        $this->assertEquals(135266304, $bytes);
    }

    public function testParseYouTubeVideoCode()
    {
        $validUrl = "https://www.youtube.com/watch?v=8Af372EQLck&list=RDMM&start_radio=1&rv=dQw4w9WgXcQ";
        $this->assertSame("8Af372EQLck", \Tormit\Helper\Util::parseYouTubeVideoCode($validUrl));

        $invalidUrl = "https://www.example.com/watch?v=8Af372EQLck&list=RDMM&start_radio=1&rv=dQw4w9WgXcQ";
        $this->assertNull(\Tormit\Helper\Util::parseYouTubeVideoCode($invalidUrl));

        $missingQueryUrl = "https://www.youtube.com/watch";
        $this->assertNull(\Tormit\Helper\Util::parseYouTubeVideoCode($missingQueryUrl));

        $malformedUrl = "This is not a URL";
        $this->assertNull(\Tormit\Helper\Util::parseYouTubeVideoCode($malformedUrl));
    }

    public function testToSingleLine()
    {
        $text = "Hello,\nHow are you?\r\nI'm fine!";
        $singleLine = \Tormit\Helper\Util::singlelinefy($text);
        $this->assertEquals("Hello, How are you? I'm fine!", $singleLine);
    }

    public function testParseStringFloat()
    {
        $stringFloat = "1.23";
        $float = \Tormit\Helper\Util::floatval($stringFloat);
        $this->assertSame(1.23, $float);
    }

    public function testParseStringFloatScientific()
    {
        $stringFloat = "1.23E-2";
        $float = \Tormit\Helper\Util::floatval($stringFloat);
        $this->assertSame(0.0123, $float);
    }

    public function testIsTextFile()
    {
        $file = 'test.txt';
        file_put_contents($file, 'This is a test text file.');
        $isTextFile = \Tormit\Helper\Util::isTextFile($file);
        unlink($file);
        $this->assertTrue($isTextFile);
    }

    public function testStripHtmlTags()
    {
        $html = "<p>Hello <strong>World</strong>!</p>";
        $tagsToRemove = ["strong"];

        $expectedOutputKeepContent = "<p>Hello World!</p>";
        $actualOutputKeepContent = \Tormit\Helper\Util::stripSelectedTags($html, $tagsToRemove);
        $this->assertSame($expectedOutputKeepContent, $actualOutputKeepContent);

        $expectedOutputStripContent = "<p>Hello !</p>";
        $actualOutputStripContent = \Tormit\Helper\Util::stripSelectedTags($html, $tagsToRemove, true);
        $this->assertSame($expectedOutputStripContent, $actualOutputStripContent);
    }

    public function testTransliterateToUrl()
    {
        $inputString = "Héllo, hòw áre ýou? I'm fîne! 你好吗？";
        $outputString = \Tormit\Helper\Transliterator::urlize($inputString);
        $this->assertEquals("hello-how-are-you-im-fine", $outputString);
    }

    public function testRandomFloat()
    {
        $randomFloat = \Tormit\Helper\Util::randFloat(1, 2, 2);
        $this->assertGreaterThanOrEqual(1, $randomFloat);
        $this->assertLessThanOrEqual(2, $randomFloat);
    }

    public function testRandomFloat2()
    {
        $randomFloat = \Tormit\Helper\Util::randFloat(0, 1, 5);
        $this->assertGreaterThanOrEqual(0, $randomFloat);
        $this->assertLessThanOrEqual(1, $randomFloat);
    }

    public function testIsSerialized()
    {
        $serialized = serialize(['test' => 'value']);
        $this->assertTrue(\Tormit\Helper\Util::isSerialised($serialized));

        $notSerialized = 'This is not serialized data.';
        $this->assertFalse(\Tormit\Helper\Util::isSerialised($notSerialized));
    }

    public function testRecursiveMerge()
    {
        $array1 = ['a' => 1, 'b' => 2];
        $array2 = ['b' => 3, 'c' => 4];
        $merged = \Tormit\Helper\Util::arrayMergeDeep($array1, $array2);

        $this->assertEquals(['a' => 1, 'b' => 3, 'c' => 4], $merged);
    }

    public function testRecursiveMergeDoNotMerge()
    {
        $array1 = ['a' => 1, 'b' => 2, '___doNotMerge' => true];
        $array2 = ['b' => 3, 'c' => 4];
        $merged = \Tormit\Helper\Util::arrayMergeDeep($array1, $array2);

        $this->assertEquals(['a' => 1, 'b' => 2], $merged);
    }

    public function testGenerateConstants()
    {
        $keyValuePairs = [
            'example_key' => 'example_value',
            'another_key' => 42,
        ];

        $prefix = 'MY_';
        $suffix = '_CONST';

        $expectedOutput = [
            "const MY_EXAMPLE_KEY_CONST = 'example_value';",
            "const MY_ANOTHER_KEY_CONST = 42;",
        ];

        $generatedConstants = \Tormit\Helper\Util::generatePhpConstants($keyValuePairs, $prefix, $suffix);
        $this->assertSame($expectedOutput, explode(PHP_EOL, trim($generatedConstants)));

        $expectedOutputWithoutPrefixSuffix = [
            "const EXAMPLE_KEY = 'example_value';",
            "const ANOTHER_KEY = 42;",
        ];

        $generatedConstantsWithoutPrefixSuffix = \Tormit\Helper\Util::generatePhpConstants($keyValuePairs);
        $this->assertSame($expectedOutputWithoutPrefixSuffix, explode(PHP_EOL, trim($generatedConstantsWithoutPrefixSuffix)));
    }
}