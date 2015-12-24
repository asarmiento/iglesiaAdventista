<!--/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 04:11 PM
 */-->
@if (count($errors) > 0)
    <div class="alert alert-danger">
        @lang('auth.errors_title'):<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif