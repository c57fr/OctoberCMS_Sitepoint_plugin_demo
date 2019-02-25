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

namespace Rafie\SitepointDemo\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

/**
 * Teams Back-end Controller.
 */
class Teams extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['rafie.sitepointDemo.manage_teams'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Rafie.SitepointDemo', 'sitepointdemo', 'teams');
    }

    public function formExtendFields($form)
    {
        if ('update' === $form->getContext()) {
            $team             = $form->model;
            $userField        = $form->getField('users');
            $userField->value = $team->users->lists('id');
        }
    }

    public function create_onSave()
    {
        $inputs = post('Team');

        // save team
        $teamModel       = new \Rafie\SitepointDemo\Models\Team();
        $teamModel->name = $inputs['name'];
        $teamModel->save();

        // update users team_id
        if ($inputs['users']) {
            \Backend\Models\User::whereIn('id', $inputs['users'])
            ->update(['team_id' => $teamModel->id]);
        }

        \Flash::success('Team saved successfully');

        return $this->makeRedirect('update', $teamModel);
    }

    public function update_onSave($recordId, $context = null)
    {
        $inputs = post('Team');

        \Backend\Models\User::where('team_id', $recordId)
            ->update(['team_id' => 0]);

        // update users team_id
        \Backend\Models\User::whereIn('id', $inputs['users'])
            ->update(['team_id' => $recordId]);

        $this->asExtension('FormController')->update_onSave($recordId, $context);
    }

    public function formAfterDelete($model)
    {
        \Backend\Models\User::where('team_id', $model->id)
            ->update(['team_id' => 0]);
    }
}
