<?php
namespace Beehive\Repo\Auth;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;
use Beehive\Repo\User\UserRepo;


class AuthRepoImpl extends GenericRepository implements AuthRepo
{
    protected $userRepo;
    protected $expirationMinutes;

    public function __construct(Model $model, UserRepo $authRepo, $expiration=30)
    {
        $this->model = $model;
        $this->authRepo = $authRepo;
        $this->expirationMinutes = $expiration;
    }

    public function getToken($access_token)
    {
        $token = $this->model
            ->where('token', '=', $access_token)
            ->first();

        return $token;
    }

    public function validateRestToken($access_token)
    {
        if(!$token = $this->getToken($access_token)) {
            throw new \BeehiveRestException('', \BeehiveRestException::INVALID_TOKEN);
        }

        if ($this->expired($token)) {
            throw new \BeehiveRestException('', \BeehiveRestException::EXPIRED_TOKEN);
        }
    }

    private function exipired($token)
    {
        $token_date = $token->created_at->addMinutes($this->expirationMinutes);
        $now = new DateTime();

        if ($token_date > $now) {
            return false;
        }

        return true;
    }
}
