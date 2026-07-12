<?php

namespace app\services;

use app\models\User;
use DateTimeImmutable;
use DateTimeZone;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\ValidAt;

class JWTService
{
    public function __construct(private Configuration $config)
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($_ENV['JWT_SECRET_KEY'])
        );
    }
    public function generate(User $user): string
    {
        $now = new DateTimeImmutable();

        $token = $this->config->builder()
            ->issuedBy($_ENV['APP_URL'])
            ->issuedAt($now)
            ->expiresAt($now->modify('+' . $_ENV['JWT_EXPIRE' . 'seconds']))
            ->relatedTo((string)$user->id)
            ->withClaim('username', $user->username)
            ->getToken(
                $this->config->signer(),
                $this->config->signingKey()
            );

        return $token->toString();
    }

    public function validate(string $token): bool
{
    $token = $this->config->parser()->parse($token);

    if (!$token instanceof Plain) {
        return false;
    }

    return $this->config->validator()->validate(
        $token,
        new SignedWith(
            $this->config->signer(),
            $this->config->verificationKey()
        ),
        new IssuedBy($_ENV['APP_URL']),
        new ValidAt(new SystemClock(new DateTimeZone('UTC')))
    );
}
    public function getPayload(string $token): array {}
}
