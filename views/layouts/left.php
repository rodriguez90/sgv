<?php
//$items = [['label' => 'Menu', 'options' => ['class' => 'header']]];

$items = [['label' => 'Menu', 
	'options' => ['class' => 'header'],
	'items' =>[]
]];

$localization = [
	'label' => 'Localización',
    'icon' => 'map',
    'url' => '#',
	'items' => []
];

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'partido_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items=['label' => 'Eleccion', 'icon' => 'flash', 'url' => ['/eleccion/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'province_list')
    || Yii::$app->user->identity->getIsAdmin())
{
   $localization['items'][]=['label' => 'Provincias', 'icon' => 'map', 'url' => ['/province/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'canton_list', [])
    || Yii::$app->user->identity->getIsAdmin())
{
    $localization['items'][]=['label' => 'Cantones', 'icon' => 'circle', 'url' => ['/canton/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'parroquia_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $localization['items'][]  =['label' => 'Parroquias', 'icon' => 'bank', 'url' => ['/parroquia/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'zona_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $localization['items'][]=['label' => 'Zonas', 'icon' => 'map-signs', 'url' => ['/zona/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'recinto_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $localization['items'][]=['label' => 'Recinto Electoral', 'icon' => 'building', 'url' => ['/recinto-electoral/index']];
}


// Menus que tienen más relacion con la el proceso eleccionario
if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'eleccion_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Elección', 'icon' => 'houzz', 'url' => ['/eleccion/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'voto_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Voto', 'icon' => 'file', 'url' => ['/voto/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'recinto_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Recinto en Elección', 'icon' => 'square', 'url' => ['/recinto-eleccion/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'partido_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Partido', 'icon' => 'object-group', 'url' => ['/partido/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'persona_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Persona', 'icon' => 'users', 'url' => ['/persona/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'persona_list')
    || Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Postulación', 'icon' => 'paw', 'url' => ['/postulacion/index']];
}

if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),'report_view')
|| Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Reporte', 'icon' => 'line-chart', 'url' => ['/site/report']];
}

// Menus de Localización
$items[] = $localization;

if(Yii::$app->user->identity->getIsAdmin())
{
    $items[]=['label' => 'Administración', 'icon' => 'cogs', 'url' => ['/user/admin/index']];
}

//var_dump($items);die;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $items
//                'items' => [
//                    ['label' => 'Menu', 'options' => ['class' => 'header']],

//                    ['label' => 'Prestamos', 'icon' => 'money', 'url' => ['/loan/index']],
//                    ['label' => 'Cobros', 'icon' => 'credit-card', 'url' => ['/payment/index']],
//                    ['label' => 'Clientes', 'icon' => 'users', 'url' => ['/customer/index']],
//                    ['label' => 'Administración', 'icon' => 'cogs', 'url' => ['/user/admin/index']],
//                    [
//                        'label' => 'Administración',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

//                ]
                ,
            ]
        ) ?>

    </section>

</aside>
