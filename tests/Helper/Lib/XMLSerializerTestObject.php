<?php
namespace inklabs\kommerce\tests\Helper\Lib;

class XMLSerializerTestObject
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var XMLSerializerTestSingleObject */
    public $singleObject;

    /** @var XMLSerializerTestSingleObject[] */
    public $multipleObject = [];
}
