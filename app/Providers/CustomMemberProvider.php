<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as MemberContract;

class CustomMemberProvider extends EloquentUserProvider {

    /**
    * Validate a member against the given credentials.
    *
    * @param  \Illuminate\Contracts\Auth\Authenticatable  $member
    * @param  array  $credentials
    * @return bool
    */
    public function validateCredentials(MemberContract $member, array $credentials)
    {
        $plain = $credentials['password']; // will depend on the name of the input on the login form
        $hashedValue = $member->getAuthPassword();

        if ($this->hasher->needsRehash($hashedValue) && $hashedValue === sha1($plain)) {
            $member->password = bcrypt($plain);
            $member->save();
        }

        return $this->hasher->check($plain, $member->getAuthPassword());
    }

}
