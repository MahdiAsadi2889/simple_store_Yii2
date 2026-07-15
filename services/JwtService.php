<?php

namespace app\services;

use app\models\User;
use DateTimeImmutable;
use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;

class JwtService
{
    private Configuration $config;

    public function __construct()
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
            ->expiresAt($now->modify('+' . $_ENV['JWT_EXPIRE'] . 'seconds'))
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
        try {
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
            );

        } catch (\Throwable $e) {
            return false;
        }
    }
    public function getPayload(string $token): array
    {
        try {
            $token = $this->config->parser()->parse($token);

            if (!$token instanceof Plain) {
                return [];
            }

            return $token->claims()->all();

        } catch (\Throwable $e) {
            return [];
        }
    }
}
