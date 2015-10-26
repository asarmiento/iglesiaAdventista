<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 07:22 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Member;

class MemberRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Member();
    }
}