<?php

return
[
	'views_style_directory'=> 'default-theme',
	'separate_style_according_to_actions' =>
    [
        'index'=>
        [
            'extends'=>'theme.layout.master',
            'section'=>'content'
        ],
        'create'=>
        [
            'extends'=>'theme.layout.master',
            'section'=>'content'
        ],
        'edit'=>
        [
            'extends'=>'theme.layout.master',
            'section'=>'content'
        ],
        'show'=>
        [
            'extends'=>'theme.layout.master',
            'section'=>'content'
        ],
    ],

];
