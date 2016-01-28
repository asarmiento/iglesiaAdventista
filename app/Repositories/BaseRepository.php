<?php namespace SistemasAmigables\Repositories;

/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 12:44 PM
 */

/**
 * Description of BaseRepository
 *
 * @author Anwar Sarmiento
 */
abstract class BaseRepository {


    /**
     * @return mixed
     */
    abstract public function getModel();

    public function __construct(){

    }

    public function token($token) {
        $consults = $this->newQuery()->where('_token', $token)->get();
        if ($consults):
            foreach ($consults as $consult):
                return $consult;
            endforeach;
        endif;

        return false;
    }

    public function newQuery() {
        return $this->getModel()->newQuery();
    }

    public function lists($token,$name){
        return $this->newQuery()->orderBy('id', 'desc')->lists($token,$name);
    }

    public function allData()
    {
        return $this->newQuery()->get();
    }
    public function allSum($data)
    {
        return $this->newQuery()->sum($data);
    }
    public function oneWhere($data,$id)
    {
        return $this->newQuery()->where($data,$id)->get();
    }

    public function oneWhereList($data,$id,$sum)
    {
        return $this->newQuery()->where($data,$id)->sum($sum);
    }

    public function twoWhereList($data,$id,$data1,$id1,$sum)
    {
        return $this->newQuery()->where($data,$id)->where($data1,$id1)->sum($sum);
    }

    public function updateBalance($id,$amount,$data)
    {
        $balance= $this->oneWhere('id',$id);
        $newbalance= $balance[0]->balance + $amount;
        $this->newQuery()->where('id',$id)->update([$data=>$newbalance]);

    }

    public function updatesOutBalance($id,$amount,$data)
    {
        $balance= $this->oneWhere('id',$id);
        $newbalance= $balance[0]->balance - $amount;
        $this->newQuery()->where('id',$id)->update([$data=>$newbalance]);

    }
}