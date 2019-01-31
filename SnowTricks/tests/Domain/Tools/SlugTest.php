<?php


namespace App\Tests\Domain\Tools;

use App\Domain\Tools\Slug;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{

    public function testSlugify()
    {
        $textTest = 'Simple Text Test ¨¨^^';
        $slug = new Slug();
        $this->assertSame('simple-text-test', $slug->slugify($textTest));

    }

}