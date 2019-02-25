<?php

/*
 * Ce fichier est la propriété de C57.fr
 *
 * (c) Membre@c57.fr - 2019
 *
 * Et C57... C'est à VOUS !
 *
 * Sérieusement, ce fichier source est sujet à la license MIT*.
 * Mais je compte sur vous pour toujours chercher à l'améliorer et à votre tour, en faire profiter
 * un max de monde grâce aux techniques offertes dans c57.fr.
 *
 * @Bi1tô, & Bon code !
 *
 *  *: En gros...: Vous en faites ce que vous voulez !!!
 */

namespace Rafie\SitepointDemo\Models;

use Model;

/**
 * Team Model.
 */
class Team extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var string the database table used by the model
     */
    public $table = 'rafie_sitepointDemo_teams';

    /**
     * @var array Relations
     */
    public $hasOne  = [];
    public $hasMany = [
        'projects' => '\Rafie\SitepointDemo\Projects',
        'users'    => '\Backend\Models\User',
    ];
    public $belongsTo     = [];
    public $belongsToMany = [];
    public $morphTo       = [];
    public $morphOne      = [];
    public $morphMany     = [];
    public $attachOne     = [];
    public $attachMany    = [];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    public function getUsersOptions()
    {
        return \Backend\Models\User::lists('login', 'id');
    }
}
