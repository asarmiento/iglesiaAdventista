<!--
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 04:11 PM
 */-->

@if(Session::has('alert'))
    <p class="alert alert-success">
        {{ Session::get('alert') }}
    </p>
@endif