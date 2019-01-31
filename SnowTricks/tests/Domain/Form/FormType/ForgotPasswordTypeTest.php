<?php

namespace App\Tests\Domain\Form\FormType;

use App\Domain\Entity\User;
use App\Domain\Form\FormType\ForgotPasswordType;
use Symfony\Component\Form\Test\TypeTestCase;

class ForgotPasswordTypeTest extends TypeTestCase
{

    public function testSubmitValidData()
    {
        $formData = [
            'userMail' => 'testMail',
        ];

        $userObjectToCompare = new User();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ForgotPasswordType::class, $userObjectToCompare);

        $user = new User();
        // populate $object properties with the data stored in $formData
        $user->setUserMail($formData['userMail']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($user, $userObjectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}