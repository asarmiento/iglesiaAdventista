<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 08:25 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Departament;

class DepartamentRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Departament();// TODO: Implement getModel() method.
    }

    public function saldosIndex($date)
    {
            return $this->newQuery()->selectRaw('departaments.*,
             ( SELECT SUM(expenses.amount) FROM type_expenses
             INNER JOIN expenses ON expenses.type_expense_id=type_expenses.id
             WHERE type_expenses.departament_id = departaments.id AND expenses.invoiceDate >= '.$date['dateIn'].'
             AND expenses.invoiceDate <= '.$date['dateOut'].') as month,

             ( SELECT SUM(expenses.amount) FROM type_expenses
             INNER JOIN expenses ON expenses.type_expense_id=type_expenses.id
             WHERE type_expenses.departament_id = departaments.id AND expenses.invoiceDate < '.$date['dateIn'].') as expense,
             ( SELECT SUM(incomes.balance) FROM type_incomes
            INNER JOIN incomes ON incomes.type_income_id=type_incomes.id
             WHERE type_incomes.departament_id = departaments.id AND incomes.date < '.$date['dateIn'].') as income,

             ( SELECT SUM(expenses.amount) FROM type_expenses
             INNER JOIN expenses ON expenses.type_expense_id=type_expenses.id
             WHERE type_expenses.departament_id = departaments.id AND expenses.invoiceDate >= '.$date['dateIn'].') as yearExpense,
             ( SELECT SUM(incomes.balance) FROM type_incomes
            INNER JOIN incomes ON incomes.type_income_id=type_incomes.id
             WHERE type_incomes.departament_id = departaments.id AND incomes.date >= '.$date['dateIn'].') as yearIncome,

             ( SELECT SUM(expenses.amount) FROM type_expenses
             INNER JOIN expenses ON expenses.type_expense_id=type_expenses.id
             WHERE type_expenses.departament_id = departaments.id ) as allExpense,
            ( SELECT SUM(incomes.balance) FROM type_incomes
            INNER JOIN incomes ON incomes.type_income_id=type_incomes.id
             WHERE type_incomes.departament_id = departaments.id) as allIncome'
    )->with('typeExpenses')->get();
    }

    public function updateAmountExpense($id,$amount){
        $credit = $this->newQuery()->where('id',$id)->sum('balance')-$amount;
        return $this->newQuery()->where('id',$id)
            ->update(['balance'=>$credit]);
    }
}