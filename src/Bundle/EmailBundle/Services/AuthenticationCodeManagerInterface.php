<?php

namespace MMC\User\Bundle\EmailBundle\Services;

use MMC\User\Component\ResourceForm\Model\ResourceFormAuthenticationInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthenticationCodeManagerInterface
{
    public function generate(ResourceFormAuthenticationInterface $resourceForm);

    public function check(UserInterface $user, $code, $test = false);
}
