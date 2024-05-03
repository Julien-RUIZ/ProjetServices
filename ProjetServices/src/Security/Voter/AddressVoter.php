<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\UserAddress;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AddressVoter extends Voter
{
    public const EDIT = 'ADDRESS_EDIT';
    public const VIEW = 'ADDRESS_VIEW';
    public const CREATE = 'ADDRESS_CREATE';


    protected function supports(string $attribute, mixed $subject): bool
    {

        return in_array($attribute, [self::CREATE]) || in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\UserAddress;
    }

    /**
     * @param UserAddress|null $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        //$attribute c'est la permission
        //$subject c'est notre entité, donc pour nous userAddress
        //TokenInterface et le token de sécurité

        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $subject->getUser()->getId() === $user->getId();
                break;

            case self::VIEW:
            case self::CREATE:
                return true;
                break;
        }

        return false;
    }
}
