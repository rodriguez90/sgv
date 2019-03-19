<?php
//$items = [['label' => 'Menu', 'options' => ['class' => 'header']]];

$items = [['label' => 'Menu', 
	'options' => ['class' => 'header'],
	'items' =>[]
]];

$eleccion = [
    'label' => 'Elección',
    'icon' => 'flash',
    'url' => '#',
    'items' => []
];

$localization = [
	'label' => 'Localización',
    'icon' => 'map',
    'url' => '#',
	'items' => []
];


if(Yii::$app->user !== null && Yii::$app->user->identity !== null)
{

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'site/index') ||
        Yii::$app->user->identity->getIsAdmin())
    {
        $items[]=['label' => 'Inicio', 'icon' => 'home', 'url' => ['/site/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'province/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $localization['items'][]=['label' => 'Provincias', 'icon' => 'map', 'url' => ['/province/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'canton/list', [])
        || Yii::$app->user->identity->getIsAdmin())
    {
        $localization['items'][]=['label' => 'Cantones', 'icon' => 'circle', 'url' => ['/canton/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'parroquia/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $localization['items'][]  =['label' => 'Parroquias', 'icon' => 'bank', 'url' => ['/parroquia/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'zona/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $localization['items'][]=['label' => 'Zonas', 'icon' => 'map-signs', 'url' => ['/zona/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'recinto/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $localization['items'][]=['label' => 'Recinto Electoral', 'icon' => 'building', 'url' => ['/recinto-electoral/index']];
    }

// Menus que tienen más relacion con la el proceso eleccionario
    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'eleccion/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $eleccion['items'][]=['label' => 'Elección', 'icon' => 'houzz', 'url' => ['/eleccion/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'recinto/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $eleccion['items'][]=['label' => 'Recinto en Elección', 'icon' => 'th-large', 'url' => ['/recinto-eleccion/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'juntas/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $eleccion['items'][]=['label' => 'Juntas Receptoras de Votos', 'icon' => 'archive', 'url' => ['/junta/index']];
    }
    elseif (!Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'voto/index') &&
        Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'voto/create')) {
        $eleccion['items'][]=['label' => 'Juntas Receptoras de Votos', 'icon' => 'archive', 'url' => ['/junta/index']];
    }

//    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'voto/index') ||
//        Yii::$app->user->identity->getIsAdmin())
//    {
//        $eleccion['items'][]=['label' => 'Voto', 'icon' => 'file', 'url' => ['/voto/index']];
//    }
//    elseif (!Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'voto/index') &&
//        Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'voto/create')) {
//        $eleccion['items'][]=['label' => 'Voto', 'icon' => 'file', 'url' => ['/voto/create']];
//    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'partido/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $eleccion['items'][]=['label' => 'Partido', 'icon' => 'object-group', 'url' => ['/partido/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'persona/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $eleccion['items'][]=['label' => 'Persona', 'icon' => 'users', 'url' => ['/persona/index']];
    }

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'persona/index')
        || Yii::$app->user->identity->getIsAdmin())
    {
        $eleccion['items'][]=['label' => 'Postulación', 'icon' => 'paw', 'url' => ['/postulacion/index']];
    }

    if(count($eleccion['items']) > 0) // Menus de Localización
        $items[] = $eleccion;

//if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'report/view')
//    || Yii::$app->user->identity->getIsAdmin())
//{
//    $items[]=['label' => 'Reporte', 'icon' => 'line-chart', 'url' => ['/site/report']];
//}

    if(count($localization['items']) > 0) // Menus de Localización
        $items[] = $localization;

    if(Yii::$app->user->identity->getIsAdmin())
    {
        $items[]= ['label' => 'Administración', 'icon' => 'cogs', 'url' => ['/user/admin/index']];
    }
}


?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>
