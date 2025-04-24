<?php

use SweetAlert2\Laravel\Swal;

if (! function_exists('swal')) {
    /**
     * Dispara um toast SweetAlert2.
     *
     * @param  string  $titulo
     * @param  string  $texto
     * @param  string  $icon    ('success','error','warning','info','question')
     * @return void
     */
    function toast(string $titulo = '', string $texto = '', string $icon = '')
    {
        Swal::fire([
            'toast'            => true,
            'showCloseButton'  => true,
            'showConfirmButton' => false,
            'timer'            => 5000,
            'timerProgressBar' => true,
            'position'         => 'bottom',
            'title'            => $titulo,
            'text'             => $texto,
            'icon'             => $icon,
        ]);
    }
}
