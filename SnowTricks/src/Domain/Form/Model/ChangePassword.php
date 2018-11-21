<?php


namespace App\Domain\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword( message = "Mot de passe invalide")
     */
    public $oldPassword;

    /**
     * @Assert\NotBlank(message="Merci de compléter ce champ")
     * @Assert\Length(min=8, minMessage="La longueur de votre mot de passe doit être d'au moins {{ limit }} caractères.", max=4096, maxMessage="La longueur de votre mot de passe ne peut pas excéder {{ limit }} caractères.")
     */
    private $newPassword;

    /**
     * @param string
     */
    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }


}