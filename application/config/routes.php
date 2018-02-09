<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['perfil'] = 'home/perfil';
$route['token'] = 'home/token';

$route['registro'] = 'user/index';
$route['login'] = 'user/login_view';
$route['salir'] = 'user/user_logout';

$route['porenviar'] = 'home/porenviar';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['ajax/enviados'] = 'sms/lista';
$route['ajax/porenviar'] = 'sms/porenviar';

$route['api/list']['get'] = 'api/mensajes/sms/sms_get';
$route['api/disponibles']['get'] = 'api/mensajes/consultar/consultar_get';
$route['api/create']['post'] = 'api/mensajes/sms/sms_post';
$route['api/status/(:any)']['get'] = 'api/mensaje/sms/id/$1';
$route['assets/(:any)'] = 'assets/$1';
