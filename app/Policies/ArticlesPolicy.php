<?php

namespace App\Policies;

use App\Articles;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlesPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Articles $article)
    {
        return $user->id === $article->user_id;
    }
}
