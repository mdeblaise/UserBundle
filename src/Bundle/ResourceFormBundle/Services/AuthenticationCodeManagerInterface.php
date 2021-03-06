<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services;

use MMC\User\Component\ResourceForm\Model\ResourceFormAuthenticationInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthenticationCodeManagerInterface
{
    public function generate(ResourceFormAuthenticationInterface $resourceForm);

    public function check(UserInterface $user, $code, $test = false);
}
