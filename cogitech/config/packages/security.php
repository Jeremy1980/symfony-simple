<?php
use App\Entity\User;
use Symfony\Config\SecurityConfig;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

return static function (SecurityConfig $security) {
    $mainFirewall = $security->firewall('main');

    $mainFirewall->formLogin()
        ->loginPath('app_login')
        ->checkPath('app_login');

    $mainFirewall->logout()
        // the argument can be either a route name or a path
        ->path('app_logout');

    $security->provider('app_user_provider')
    ->entity()
        ->class(User::class)
        ->property('email');

    // Use native password hasher, which auto-selects and migrates the best
    // possible hashing algorithm (currently this is "bcrypt")
    $security->passwordHasher(PasswordAuthenticatedUserInterface::class)
        ->algorithm('auto');
};
?>