<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PostOwnerVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['POST_CREATE', 'POST_EDIT']) && $subject instanceof Post;
    }

    protected function voteOnAttribute($attribute, $post, TokenInterface $token)
    {
        /** @var \App\Entity\User $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        switch ($attribute) {
            case 'POST_EDIT':
                if ($user->getAuthor() === $post->getWrittenBy()) {
                    return true;
                }
                break;
            case 'IS_AUTHENTICATED_REMEMBERED':
                return true;
        }

        return false;
    }
}
