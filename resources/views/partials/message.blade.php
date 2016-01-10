<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 10/01/16
 * Time: 11:33 AM
-->

@if (session('message'))
<div class="alert alert-info">
    {{  session('message') }}
</div>
@endif

